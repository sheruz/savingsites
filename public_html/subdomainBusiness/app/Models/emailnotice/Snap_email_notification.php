<?php
namespace App\Models\emailnotice;

use CodeIgniter\Model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Snap_email_notification extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->table = "tblClaimedZips";
        $this->CommonController = new CommonController();
    } 



	/**
	  *@description  fetch all snap criteria
	  *@return array of criteria
	*/
	public function fetchSnapCriteria() {
		$percentageCriteriaData = $this->getPercentageCriteria();
		$snapWeekDays           = $this->getSnapWeekDays();
		$snapStartTime          = $this->getSnapStartTime();
		return array(
					'percentageCriteria'=>$percentageCriteriaData,
					'snapWeekDays' => $snapWeekDays,
					'snapStartTime' => $snapStartTime
					);
	}

	/**
	  *@description fetch all percentage criteria
	  *@return $percentage array
	*/
	public function getPercentageCriteria() {
		$sql = "SELECT 
					*
				FROM
					snap_discount_table";
		$query           = $this->db->query($sql);
		$percentageArray = $query->getResultArray();
		$percentageData  = array();
		foreach ($percentageArray as $value) {
			$id                  = $value['id'];
			$percentageData[$id] = $value['discount_percentage'];
		}
		return $percentageData;
	}
	/**
	  *@description fetch all snap week days
	  *@return weekdays array
	*/
	public function getSnapWeekDays() {
		$sql = "SELECT
					*
				FROM 
					snap_week_days";
		$query         = $this->db->query($sql);
		$snapWeekDays  = $query->getResultArray();
		$weekDaysArray = array();
		foreach ($snapWeekDays as $value) {

			$id                  = $value['id'];
			$weekDaysArray[$id]  = $value['day'];
		}
		return $weekDaysArray;
	}
	/**
	  *@description fetch all snap_start_time data
	  *@return snapStartTime array
	*/
	public function getSnapStartTime() {
		$sql = "SELECT
					*
					FROM
						snap_start_time";
		$query = $this->db->query($sql);
		$timeArray = $query->getResultArray();
		$timeData  = array();
		foreach ($timeArray as $value) {
			$id            = $value['id'];
			$time          = $value['time'];
			$timeData[$id] = $time;
		}
		return $timeData;
	}
	/**
	  * @description function to fetch snapuser details
	  * @param $businessId,$zoneId,$snapWeekDays,$snapTime,$minPercentage
	  * @return resultarray
	*/
	public function getSeachSnapData($businessId,$zoneId,$snapWeekDays,$snapTime,$minPercentage,$lowerLimit,$upperLimit) {
		$minPercentage = (int)$minPercentage;
		$whereStatement = "WHERE a.status = 1 AND a.createdby_id =".$businessId." AND a.user_id = b.id";
		if($snapTime != 0) {
			$whereStatement.= " AND FIND_IN_SET($snapTime,a.snap_time_id) > 0";
		}
		if($snapWeekDays != 0) {
			$whereStatement.= " AND FIND_IN_SET($snapWeekDays,a.snap_days_id) > 0";
		}
		if($minPercentage != 0) {
			$whereStatement.= " AND a.snap_min_percentage_id >= ".$minPercentage;
		}
		if($upperLimit != 0) {
			$whereStatement.=" ORDER BY a.id LIMIT ".$lowerLimit.",".$upperLimit;
		}
		//$whereStatement.=" ORDER BY id LIMIT ".$lowerLimit." OFFSET ".$upperLimit;
		$sql = "SELECT
					a.status AS snap_status,
					a.user_id AS user_id,
					a.zone_id AS zone_id,
					a.snap_min_percentage_id AS snap_percentage,
					a.snap_days_id AS snap_day,
					a.snap_time_id AS snap_time,
					CONCAT(b.first_name,' ',b.last_name) AS name,
					b.email AS email
				FROM
					user_offer_status AS a,
					users AS b 
				$whereStatement";
	 // return $sql;
		/*$sql = "SELECT
					a.status AS snap_status,
					a.user_id AS user_id,
					c.time AS snap_time,
					"*/

		/*if($snapTime != 0 && $snapWeekDays != 0){
			$sql = "SELECT
					 a.status AS snap_status,
					 a.user_id AS user_id,
					 c.time AS snap_time,
					 d.discount_percentage AS snap_percentage,
					 b.day AS snap_week_day
				FROM
					user_offer_status a,
					snap_week_days b,
					snap_start_time c,
					snap_discount_table d

				WHERE
					FIND_IN_SET($snapWeekDays,a.snap_days_id) > 0
				AND
					FIND_IN_SET($snapTime,a.snap_time_id) > 0
				 AND
					c.id = ".$snapTime."
				 AND
				 	b.id = ".$snapWeekDays."
				 AND
				 	a.snap_min_percentage_id = d.id
				 AND
					a.snap_min_percentage_id >= ".$minPercentage;

		} else {
			$sql = "SELECT
					 a.status AS snap_status,
					 a.user_id AS user_id,
					 c.time AS snap_time,
					 d.discount_percentage AS snap_percentage,
					 b.day AS snap_week_day
				FROM
					user_offer_status a,
					snap_week_days b,
					snap_start_time c,
					snap_discount_table d

				WHERE
					FIND_IN_SET($snapWeekDays,a.snap_days_id) > 0
				AND
					FIND_IN_SET($snapTime,a.snap_time_id) > 0
				 AND
				 	a.snap_min_percentage_id = d.id
				 AND
					a.snap_min_percentage_id >= ".$minPercentage;

		}*/
		//return $sql;
		$query = $this->db->query($sql);
		$snapOfferArray = $query->result_array();
		$finalArray = array();
	   	if(count($snapOfferArray) == 0 || count($snapOfferArray) < 10) {
		$checkCustomSnapSettingUserssql = "SELECT
											user_id
										FROM
											user_offer_status
										WHERE
											createdby_id = ".$businessId."
										AND
											zone_id = ".$zoneId;
		$checkCustomSnapSettingUsersQuery = $this->db->query($checkCustomSnapSettingUserssql);
		$checkCustomSnapSettingUsersresultArray = $checkCustomSnapSettingUsersQuery->result_array();
		$checkCustomSnapSettingUsersresultString = '';
		if(count($checkCustomSnapSettingUsersresultArray) > 0){
			foreach ($checkCustomSnapSettingUsersresultArray as $key => $value) {
				$checkCustomSnapSettingUsersresultString.=(int)$value['user_id'].',';
			}
			$checkCustomSnapSettingUsersresultString = rtrim($checkCustomSnapSettingUsersresultString,',');
		}
		$globalWhereStatement = "WHERE a.status = 1 AND a.created_for_zone =".$zoneId." AND a.user_id = b.id";
		if($checkCustomSnapSettingUsersresultString) {
			$globalWhereStatement.=" AND a.user_id NOT IN($checkCustomSnapSettingUsersresultString)";
		}
		if($snapTime != 0) {
			$globalWhereStatement.= " AND FIND_IN_SET($snapTime,a.snap_start_time) > 0";
		}
		if($snapWeekDays != 0) {
			$globalWhereStatement.= " AND FIND_IN_SET($snapWeekDays,a.snap_week_days) > 0";
		}
		if($minPercentage != 0){
			$globalWhereStatement.= " AND a.snap_minimum_percentage >= ".$minPercentage;
		}
		$globalSnapGlobaldataQuery = "SELECT
											a.status AS snap_status,
											a.user_id AS user_id,
											a.created_for_zone AS zone_id,
											a.snap_minimum_percentage AS snap_percentage,
											a.snap_week_days AS snap_day,
											a.snap_start_time AS snap_time,
											CONCAT(b.first_name,' ',b.last_name) AS name,
											b.email AS email,
											a.from_where
									  FROM
										global_snap_settings AS a,
										users AS b 
									  $globalWhereStatement";
		$snapGlobalQuery = $this->db->query($globalSnapGlobaldataQuery);
		$globalResult = $snapGlobalQuery->result_array();
		$finalArray = array_merge($snapOfferArray,$globalResult);
		/*$finalendNotification = array(
										'snap_status'     => 'end',
										'user_id'         => 'end',
										'zone_id'         => 'end',
										'snap_percentage' => 'end',
										'snap_day'        => 'end',
										'snap_time'       => 'end',
										'name'            => 'end',
										'email'           => 'end'
									 );
		$finalArray = array_merge($tempArray,$finalendNotification);*/

	} else {
		$finalArray = $snapOfferArray;
	}
	return $finalArray;
		

	}
	/**
	  * Get snap result
	  * @param $userId,$createdById,$zoneId,$type
	  * @return array snap result
	*/
	public function getSelectedSnapCriteria($userId,$createdById,$zoneId,$type){
		$userId = (int)$userId;
		$createdById = (int)$createdById;
		$zoneId = (int)$zoneId;
		$type = (int)$type;
		$sql = "SELECT snap_days_id AS snapDayId, snap_time_id AS snapTimeId, snap_min_percentage_id AS snapPercentage, status FROM user_offer_status WHERE user_id =".$userId." AND createdby_id =".$createdById." AND zone_id =".$zoneId." AND type = ".$type;
		$result = $this->CommonController->SelectRawquery($sql,'row');
		if($result) {
			return $result;
		} else {
			$sqlGlobalSnapQuery = "SELECT snap_week_days AS snapDayId, snap_start_time AS snapTimeId, snap_minimum_percentage AS snapPercentage, status FROM global_snap_settings WHERE user_id = ".$userId." AND created_for_zone =".$zoneId;
			return $this->CommonController->SelectRawquery($sqlGlobalSnapQuery,'row');
		}
	}
	public function getGlobalSnapEmailData($userId,$zoneId) {
		$sqlGlobalSnapQuery = "SELECT
										snap_week_days AS snapDayId,
										snap_start_time AS snapTimeId,
										snap_minimum_percentage AS snapPercentage,
										snap_send_type AS snap_type,
										status
									FROM
										global_snap_settings
									WHERE
										user_id = ".$userId."
									AND
										created_for_zone =".$zoneId;
			$query = $this->db->query($sqlGlobalSnapQuery);
			return $query->row();
		
	}
	/**
	   * @description method to check if user has already exists in global snap setting table
	   * @param $snapUserId,$snapZoneId
	   * @return boolean
	*/
	public function checkGlobalSnapSettingsExists($snapUserId,$createdZoneFor) {
		$sql = "SELECT
					id
				FROM
					global_snap_settings
				WHERE
					user_id = ".$snapUserId."
				AND
					created_for_zone = ".$createdZoneFor;
		$query = $this->db->query($sql);
		$isExists = false;
		if($query->num_rows() > 0){
			$isExists = true;
		}
		return $isExists;
	}
	/**
	  *@description method to update snap status globally
	  *@param $userId,$zoneId,$snapStatus,$snapType,$snapWeekDays,$snapStartTime,$snapDisountpercentage
	  *@return update status boolean
	*/
	public function updateGlobalSnapStatus($snapType,$snapWeekDays,$snapStartTime,$snapDiscountPercentage,$snapUserId,$snapZoneId,$snapStatus) {
		$snapWeekDays            = implode(',',$snapWeekDays);
		$snapStartTime           = implode(',', $snapStartTime);
		$snapUserId              = (int)$snapUserId;
		$snapZoneId              = (int)$snapZoneId;
		$snapType                = (int)$snapType;
		$snapDiscountPercentage  = (int)$snapDiscountPercentage;
		$snapStatus              = (int)$snapStatus;
		$checkIfExists           = $this->checkGlobalSnapSettingsExists($snapUserId,$snapZoneId);
		$updateStatus = false;
		if($checkIfExists) {
			$sqlUpdateQuery = "UPDATE
									global_snap_settings
								SET
									snap_send_type =".$snapType.",
									snap_week_days = '".$snapWeekDays."',
									snap_start_time = '".$snapStartTime."',
									snap_minimum_percentage = ".$snapDiscountPercentage.",
									status = ".$snapStatus."
								WHERE
									created_for_zone = ".$snapZoneId."
								AND
									user_id =".$snapUserId;
			$updateStatus = $this->db->query($sqlUpdateQuery);
		} else {
			$sqlInsertQuery = "INSERT INTO
										global_snap_settings
								SET
									snap_send_type =".$snapType.",
									snap_week_days = '".$snapWeekDays."',
									snap_start_time = '".$snapStartTime."',
									snap_minimum_percentage = ".$snapDiscountPercentage.",
									status = ".$snapStatus.",
									created_for_zone =".$snapZoneId.",
									from_where = 'global_snap_settings',
									user_id = ".$snapUserId;
			$updateStatus = $this->db->query($sqlInsertQuery);
		}
		return $updateStatus;

	}
	public function deActiveGlobalSnapStatus($snapStatus,$userId,$zoneId) {
		$snapStatus = (int)$snapStatus;
		$userId     = (int)$userId;
		$zoneId     = (int)$zoneId;

		$checkGlobalSettingsUserExists = $this->checkGlobalSnapSettingsExists($userId,$zoneId);
		$sql = "";
		if($checkGlobalSettingsUserExists) {
			$sql = "UPDATE
						global_snap_settings
					SET
						status = ".$snapStatus."
					WHERE
						user_id =".$userId."
					AND
						created_for_zone =".$zoneId;
		} else {
			$sql = "INSERT INTO
							global_snap_settings
					SET
						status = ".$snapStatus.",
						user_id = ".$userId.",
						created_for_zone = ".$zoneId.",
						from_where = 'global_snap_settings'";
		}
		$updateStatus = $this->db->query($sql);
		return $updateStatus;
	}
}


?>