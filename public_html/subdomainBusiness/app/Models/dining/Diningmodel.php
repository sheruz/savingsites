<?php
namespace App\Models\dining;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class DiningModel extends Model{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    } 
	// Method to get all special offer list

	public function getAllSpecialOfferList($zoneId,$orderBy) {

		$orderBySql = '';

		if($orderBy == 'maxDiscount') {

			$orderBySql = "ORDER BY c.discount_percentage ASC";

		} else if($orderBy == 'latest') {

			$orderBySql = "ORDER BY a.offered_date ASC";

		}



		$sqlGetSpecialOffer = "SELECT

					             a.actual_price AS originalPrice,

					             a.offered_price AS offerPrice,

					             a.offered_date AS offerDate,

					             a.offer_description AS offerDescription,

					             b.restaurant_name AS offerRestaurantName,

					             b.restaurant_address AS restaurantAddress,

					             b.restaurant_image AS restaurantProfileImage,

					             c.discount_percentage AS restaurantDisPercentage,

					             d.food_name AS foodName

					        FROM

					        	restaurantbooking_special_offer a

					        INNER JOIN

					          	restaurantbooking_restaurant_basic_info b

					        INNER JOIN

					        	snap_discount_table c

					        INNER JOIN

					        	restaurantbooking_food_offered d

					          ON 

					          	a.business_id = b.business_id 

					          AND a.zone_id = b.zone_id

					          AND  a.percentage_id = c.id

					          AND a.food_id = d.id 

					           $orderBySql";

		$query = $this->db->query($sqlGetSpecialOffer);

		return $query->result_array();

	}

	/**

	  * @desc method to get all common snap data

	  * @access public

	  * @return $snapData array

	*/

	public function getAllCommonSnapData() {

		$snapData = array();

		$sqlFoodOffered                    = "SELECT * FROM restaurantbooking_food_offered WHERE status=0 ORDER BY food_name ASC";

		// $sqlSnapDiscountQuery              = "SELECT * FROM snap_discount_table WHERE discount_percentage <=60 ORDER BY discount_percentage";

		$sqlSnapDiscountQuery              = "SELECT * FROM snap_discount_table ORDER BY discount_percentage";

		$sqlSnapStartTime                  = "SELECT * FROM snap_start_time"; 

	    $queryFoodOffered                  = $this->db->query($sqlFoodOffered);

	    $queryDiscountOffered              = $this->db->query($sqlSnapDiscountQuery);

	    $querySnapStartTime                = $this->db->query($sqlSnapStartTime);

		$snapData['foodOffered']           = $queryFoodOffered->result_array();

		$snapData['discountPercentage']    = $queryDiscountOffered->result_array();

		$snapData['snapStartTime']         = $querySnapStartTime->result_array();

		return $snapData;

	}

	/**

	  * @desc method to get result

	  * Data according to search query in front end

	  * @param 

	  * @return $searchResult array

	*/

	public function getSearchQueryData($noOfPerson,$searchDate,$timeId,$foodId,$discountPercentageId,$snapSettingType,$isDelivryRequired,$zoneId,$userId,$orderBy,$outsidedining) {

 

		// Get all restaurant with specific food offered and within specificzone
		$foodId = (int)$foodId;//casting foodid as int

		$snapSettingType = (int)$snapSettingType;

		 

		$dynamicSql = "";

		if($foodId != 0) {

			$dynamicSql.=" AND fd.food_id =".$foodId;

		}

		if($outsidedining != 0) {

			$dynamicSql.=" and  rop.key  = 'o_outdoor_dining'  and  substring_index(rop.value, '::', -1) = 'Yes'";

		}

		if($isDelivryRequired == "true") {

			$dynamicSql.= " AND c.delivaery_status = 1";

		}

		if(!empty($discountPercentageId) && $snapSettingType !=1) {

			$discountPercentageId = (int)$discountPercentageId;

			$dynamicSql.= " AND d.snap_percentage >=".$discountPercentageId." AND d.snap_time_id =".$timeId;

		}

		$snapWeekDayId = (int)$this->getSnapStartDayId($searchDate);

		$dynamicSql.=" GROUP BY ad.id  ";

 


 



		$data = array();
		$response = array();

		$sqlRestaurantDetails = "SELECT DISTINCT  ad.id  , ad.business_id AS businessId ,

                                    auc.auc_id as auc_id, 

									a.zoneid AS zoneId,

									 b.id AS userId, 

									 bs.business_owner_id as busin_owner

								FROM 

									category_display a

								INNER  JOIN

									restaurantbooking_users b

								

								";
	    if($foodId != 0) {

			$sqlRestaurantDetails.=" INNER  JOIN

									restaurantbooking_food_offered_type fd ";

		}


		 if($outsidedining != 0) {

			$sqlRestaurantDetails.=" INNER  JOIN

									restaurantbooking_options rop    ";

		}


       	$sqlRestaurantDetails .= "INNER JOIN

									restaurantbooking_restaurant_basic_info c
							 

								INNER JOIN

									tbl_auction auc 

							   INNER JOIN

							    business bs		

							     Inner join  ads ad 
                                 Inner join  ad_to_zone bz  
                                 Inner join ad_category_subcategory acd
                                 Inner join category_display c_d 					 


								ON (a.zoneid = auc.zone_id and  a.zoneid = b.zone_id and  a.zoneid = c.zone_id   AND c.business_id = bs.id and  

								 ad.status=0 and  ad.id=bz.adid and bz.approval=1 and bz.zoneid=".$zoneId." and ad.categoryid!='-99' and ad.subcategoryid!='-99'   and ad.id=acd.adid and acd.catid=c_d.catid and acd.zoneid=c_d.zoneid and acd.catid=1 and  acd.zoneid=".$zoneId."  and (ad.categoryid!='-99' AND ad.categoryid1!='-99')

								 ";

					if($foodId != 0) {
							$sqlRestaurantDetails .= "  and fd.business_id = bs.id";
					} 


					if($outsidedining != 0) {
							$sqlRestaurantDetails .= " and   rop.business_id = bs.id     ";
					} 



		$sqlRestaurantDetails .= " )  WHERE 
   

									auc.status = 'Live' AND 

									a.zoneid = ".$zoneId."

								    $dynamicSql";




								  // print_r($sqlRestaurantDetails);die;
 
        $queryRestaurantDetails = $this->db->query($sqlRestaurantDetails);  

		$data['restaurantDetails'] = $queryRestaurantDetails->result_array();

	 // print_r($data['restaurantDetails']);die;

		$response = array();

		if(count($data['restaurantDetails']) > 0) {

			$i = 0;
 
			foreach ($data['restaurantDetails'] as $eachRestaurantDetails) {

 
			 	// Get Restaurant userId
				 

				$snapFilterValidate = ($snapSettingType == 1) ? $this->checkSnapFilterSettingsCriteria($eachRestaurantDetails['businessId'],$searchDate,$timeId,$userId,$zoneId) : true;

				if ($snapFilterValidate) {

				 

					$response['restaurantDetails'][$i]['snapValidate'] = $snapFilterValidate;

				//if($snapFilterValidate) {



					$response['restaurantDetails'][$i]['userId'] = $eachRestaurantDetails['userId'];



					$response['restaurantDetails'][$i]['basicInfo'] = $this->getRestaurantBasicInfo($eachRestaurantDetails['businessId']);

					// Get all food offerred by the restaurant

					$response['restaurantDetails'][$i]['foodOffered'] = $this->getFoodOfferredByRestaurant($eachRestaurantDetails['businessId']);

					// Get Offered snap Percentage

					$response['restaurantDetails'][$i]['snapPercentage'] = $this->getSnapPercentage($eachRestaurantDetails['snapPercentage']);
				 
					$response['restaurantDetails'][$i]['auctiondetails'] = $this->getauctionDetails($eachRestaurantDetails['id'] , $zoneId);

					// Get Business smart url

					$response['restaurantDetails'][$i]['smarturlList'] = $this->getSmartUrl($eachRestaurantDetails['businessId']);

					$response['restaurantDetails'][$i]['adsdetails'] = $this->getadsdetails($eachRestaurantDetails['businessId'] );

					$response['restaurantDetails'][$i]['menudetails'] = $this->get_menu($eachRestaurantDetails['businessId'] );



					// Get all available table of a restaurant

					 $response['restaurantDetails'][$i]['availableTable'] = $this->getRestaurantAvailableTable($eachRestaurantDetails['businessId'],$eachRestaurantDetails['userId'],$noOfPerson,$searchDate,$timeId);
 

					$i++;

				}
				

			}



		}


 
		return $response;

	}



   function get_menu($business_id){

        $this->db->select('*');
        $this->db->from('menu_builder_categories');
        $this->db->where('business_id',$business_id);
        //$this->db->where('create_type',1);
        $this->db->order_by("id","desc");         

        $query = $this->db->get();
        return $query->row_array();
    }



	/**

	  * @desc method to get Restaurant basic info

	  * @access public

	  * @param $businessId

	  * @return $basicInfo array

	*/

	public function getRestaurantBasicInfo($businessId) {

		if(empty($businessId)) {

			return;

		}

		$businessId = (int)$businessId;

		$sqlBusinessInfo = "SELECT restaurantbooking_restaurant_basic_info.* , business.logo FROM restaurantbooking_restaurant_basic_info left join business on business.id = restaurantbooking_restaurant_basic_info.business_id  WHERE business_id =".$businessId;

		$queryBusinessInfo = $this->db->query($sqlBusinessInfo);

		return $queryBusinessInfo->row();

	}



// details auction

public function getauctionDetails($adId,$zoneId){

     
     $response = '';
      if(empty($adId)) {

			return;

		}
 
  	$adId = (int)$adId; 


$sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";

        $query=$this->db->query($sql);

        $business_peekaboo=$query->result_array();

        $username = $business_peekaboo['0']['username']; 

        $busid = $business_peekaboo['0']['busid'];

        $current_date = date('Y-m-d');
 

            // Remove stating date condition to how all auctions
            $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live','Public') and c.id='$adId' and b.product_id=d.product_id group by b.auc_id order by b.start_date ASC,d.product_name";

             $peekaboo_popup =$this->db->query($peekaboo_popup_sql);

             $peekaboo_popup_show = $peekaboo_popup->result_array();//echo "<pre>"; var_dump($peekaboo_popup_show);exit;

             // ++ Add remaining time of each auction

             foreach($peekaboo_popup_show as $key=>$val){

             
                $left_consolation = "SELECT   abs(count(so.order_id) - tp.numberofconsolation )  as totalconsolationleft FROM `tbl_inventory_products` as tp left join  tbl_auction as ac on tp.product_id =  ac.product_id inner join  tbl_sales_order as so on so.auc_id =  ac.auc_id where ac.product_id = ".$val['product_id'];
                $lefttotal_consolation =$this->db->query($left_consolation);

                $left_total_consolation = $lefttotal_consolation->result_array();



                $startdate = strtotime('now');

                $stopdate = strtotime($val['end_date']);

                $diff = $stopdate - $startdate; //<-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.

                

                $days = floor($diff / 86400);

                $diff = $diff % 86400;

                $hours = floor($diff / 3600);

                $diff = $diff % 3600;

                $minutes = floor($diff / 60);

                $diff = $diff % 60;

                $seconds = $diff;

                $arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;

                $peekaboo_popup_show[$key] = array_merge($val,$arr ,  $left_total_consolation[0]) ;

             }

             // -- Add remaining time of each auction

             return $peekaboo_popup_show;

             


 // $sqlAuctionInfo = "SELECT DISTINCT tbl_auction.auc_id , tbl_auction.* , b.id as business_owner_id, count(so.order_id) ,  tbl_inventory_products.* , abs(count(so.order_id) - tbl_inventory_products.numberofconsolation )  as totalconsolationleft FROM tbl_auction left join  tbl_sales_order as so on so.auc_id =  tbl_auction.auc_id INNER JOIN tbl_inventory_products on tbl_auction.product_id =  tbl_inventory_products.product_id   
	// 	   INNER JOIN users b on tbl_auction.product_id =  tbl_inventory_products.product_id 

	// 	   WHERE b.id =".$auct_id."  and tbl_inventory_products.zone_id = ".$zoneid."  and    tbl_auction.status = 'Live'  GROUP BY tbl_auction.auc_id ";


 

	// 	$queryAuctionInfo = $this->db->query($sqlAuctionInfo);
 
 
 //    $response =	$queryAuctionInfo->row();
 //   return $response;
}

public function getWorkingTime($date)
	{
		 

	  $sqlTableAvailable = "Select *   FROM `restaurantbooking_dates`
 t1 where t1.date = ".$date."  order By  t1.start_time ASC limit 1 ";
        $queryTable = $this->db->query($sqlTableAvailable);

        $arr =   $queryTable->result_array(); 

         
		if (count($arr) == 0)
		{
			return false;
		}

		if ($arr[0]['is_dayoff'] == 'T')
		{
			return array();
		}
		
		$wt = array();
		$d = getdate(strtotime($arr[0]['start_time']));
		$wt['start_hour'] = $d['hours'];
		$wt['start_minutes'] = $d['minutes'];
	
		$d = getdate(strtotime($arr[0]['end_time']));
		$wt['end_hour'] = $d['hours'];
		$wt['end_minutes'] = $d['minutes'];
		
		$wt['start_ts'] = strtotime($date . " " . $arr[0]['start_time']);
		$wt['end_ts'] = strtotime($date . " " . $arr[0]['end_time']);
		
		return $wt;
	}



	private function pjCheckWTime($date,$time)
	{
        
     
		$date = $date;
	    $wt_arr = $this->getWorkingTime($date);
		$previous_date = date('Y-m-d', strtotime($date) - 86400);
		$next_date = date('Y-m-d', strtotime($date) + 86400);
		$previous_wt_arr =  $this->getWorkingTime($previous_date);
		$next_wt_arr =  $this->getWorkingTime($next_date);
	    $_time = date('H:i:s', strtotime($time));
	  	$ts = strtotime($date . ' ' . $_time);
		$offset = 0;
		 
		$play = 2 * 60;
		
		if ($wt_arr === false)
		{
			$status = 300;
		} else {
			$stime = $ts;
			$wt_arr['end_ts'] += $offset * 3600;
			if(time() + $play > $ts)
			{
			    if($play == 0)
			    {
			        $status = 304;
			    }else{
			        $status = 301;
			    }
			}else{
			    if($ts < $wt_arr['start_ts'])
			    {
			        if($previous_wt_arr['start_ts'] > $previous_wt_arr['end_ts'])
			        {
			            $previous_wt_arr['end_ts'] += 86400;
			            if($previous_wt_arr['end_ts'] >= $wt_arr['start_ts'])
			            {
			                $status = 200;
			            }else{
			                if($previous_wt_arr['end_ts'] < $ts + 180 * 60)
			                {
			                    $status = 303;
			                }else{
			                    $status = 200;
			                }
			            }
			        }else{
			            $status = 302;
			        }
			    }elseif(($wt_arr['end_ts'] < $ts + 180 * 60)) {
			        if($next_wt_arr !== false)
			        {
			            if($next_wt_arr['start_ts'] <= $wt_arr['end_ts'])
			            {
    			            if($ts + 180 * 60 >= $next_wt_arr['start_ts'])
    			            {
    			                $status = 200;
    			            }else{
    			                $status = 303;
    			            }
			            }else{
			                $status = 303;
			            }
			        }else{
			        	$status = 303;
			        }
			    }else{
			        $status = 200;
			    }
			}
		}

		return $status;
	}





	/**

	  * @desc method to get available table within a specific date and time

	  * @param $businessId,$noOfPerson,$searchDate

	  * @return $availableData

	*/

	public function getRestaurantAvailableTable($businessId,$userId,$noOfPerson,$searchDate,$timeId) {



		$getmap = "Select * from restaurantbooking_options t1 where t1.business_id = ".$businessId." and t1.key ='o_use_map' ";
        $getmapquery = $this->db->query($getmap);

        $getmapdata =   $getmapquery->result_array(); 

        if($getmapdata){

        	$use_map = @$getmapdata[0]['value'];
        }
      

        


 

        $timeId = date("H", strtotime($timeId));


        $status   = $this->pjCheckWTime($searchDate,$timeId);
 
         
		$end_time = date('Y-m-d H:i:s', strtotime($searchDate .' '. $timeId) );
  
        
		// check if restaurant is off or not on that day

		$data = array();

		if($noOfPerson !== false && (int) $noOfPerson > 0)

		{

	    $isRestaurantOff   = $this->isRestaurantOff($businessId,$searchDate,$timeId);


		$bookedTable    = $this->getBookedTable($businessId,$userId,$searchDate,$timeId);

		$sqlAlreadyBookedTable = "";

		$sqlNoOFPersonQuery    = ""; 

		$data['availableTableStatus'] = 0;	

		$data['avail_tables'] = 0; 

	    $passed = 0;

		$data['availableTableData'] = 0;

		$data['action'] = 'table';

		$table_id = 0;



		if($isRestaurantOff == false) {

			if(count($bookedTable) > 0) {

				$bookedId = array();

				$i= 0;

				foreach ($bookedTable as $tableId) {

					$bookedId[$i] = (int)$tableId['tableId'];

					$i++;

				}

				$bookedTableIdString = implode(',',$bookedId);

				$sqlAlreadyBookedTable = " AND a.id NOT IN($bookedTableIdString)";

			}

			  

			  $sqlTableAvailable = "Select t1.*  ,  (SELECT COUNT(`table_id`)

									FROM `restaurantbooking_bookings_tables`

									WHERE `table_id` = `t1`.`id`

									AND `booking_id` IN (SELECT `id` FROM `restaurantbooking_bookings` WHERE (

										(`dt` <= '".$end_time."' AND '".$end_time."' < `dt_to`)

										OR (`dt_to` >= '".$end_time."' AND '".$end_time."' > `dt`)

					AND (`status` = 'confirmed' OR (`status`='pending' AND UNIX_TIMESTAMP(`created`) >= UNIX_TIMESTAMP(DATE_SUB(NOW() , INTERVAL 2 MINUTE)  )  ) )
                                          ) )
                                                        
                                                        
                                                    

									LIMIT 1 ) as booked from restaurantbooking_tables t1 where t1.business_id = ".$businessId."";



 
 

			$queryTable = $this->db->query($sqlTableAvailable);

			//$data['availableTableQuery'] = $sqlTableAvailable;

			if($queryTable->num_rows() > 0) {

				// $data['avail_tables'] = 1;

				$table_arr =   $queryTable->result_array(); 

				             


				foreach ($table_arr as $table  ) {
					 
 
                    $data['availableTableStatus'] = 1;
					if((int) $table['booked'] === 0)

				{

					$passed = 1;

					if((int) $noOfPerson <= (int) $table['seats'] && (int) $noOfPerson >= (int) $table['minimum'])

					{


						$data['avail_tables']++;

               

						if($status == 200 && $table_id == 0 && $use_map == 0)

						{

							$table_id = $table['id'];
						 
						}

					}

				}



				}   // loop ends here 

 

				if($passed == 1)

			{
 
				if($data['avail_tables'] == 0)

				{

					$data['action'] = 'enquiry';


				}else{

					if($table_id != 0)

					{

						$data['action'] = 'checkout';

					}else{

						$data['action'] = 'table';

					}

				}

			}


            $data['passed'] = $passed;

			$data['availableTableData'] = $table_arr;



			}

			

		}


		}else{

			$data['passed'] = true;

		}
// echo "<pre>";
        

		return $data;

		

	}


	public function checkBookingPrice($businessId){

		 $sqlTableAvailable = "Select * from restaurantbooking_options t1 where t1.business_id = ".$businessId." and t1.key ='o_booking_price' ";
        $queryTable = $this->db->query($sqlTableAvailable);

        $table_arr =   $queryTable->result_array(); 
      

      return $table_arr[0]['value'];


	}

	/**

	  * @desc method to check booked table on that day and time

	  * @param $businessId,$userId,$searchDate,$timeId

	  * @return $bookedTableId array

	*/

	public function getBookedTable($businessId,$userId,$searchDate,$timeId) {

		$startTime = $this->getOrigninalTime($timeId);

		$endTime   = $startTime;

		$defaultBookingOption = $this->getDefaultBookingOptions($businessId);

		if($defaultBookingOption['restaurantOptionstatus'] == 1) {

			$bookingLength = $defaultBookingOption['bookingData']->bookingLength;

			$endTime       = $this->addMinutesToTime($startTime,$bookingLength);



		}

		$data = array('startTime' => $startTime,'endTime' => $endTime);

		$startDateTime = $searchDate.' '.$startTime;

		$endDateTime   = $searchDate.' '.$endTime;

		$sqlGetBookingTable = "SELECT

									a.table_id AS tableId

								FROM

									restaurantbooking_bookings_tables a

								INNER JOIN

									restaurantbooking_bookings b

								ON (a.booking_id = b.id)

								WHERE ((b.dt BETWEEN '".$endDateTime."' AND '".$startDateTime."')

									   OR (b.dt_to BETWEEN '".$endDateTime."' AND '".$startDateTime."')) 

								AND a.business_id = ".$businessId;

		$queryGetBookingTable = $this->db->query($sqlGetBookingTable);

		return $queryGetBookingTable->result_array();

	}

	/**

	  * @desc method to check if restaurant is off or open

	  * @param $businessId,$searchDate,$timeId

	  * @return $restaurantOnOffStatus boolean

	*/

	public function isRestaurantOff($businessId,$searchDate,$timeId) {

		// check if set date in custom way

		$customRestaurantOffStatus = $this->customWorkingTimeOffStatus($businessId,$searchDate);


		// check if restaurant open within time or day

		$workingTimeStatus = $this->getRestaurantWorkingTimeOffStatus($searchDate,$timeId,$businessId);



		if($customRestaurantOffStatus || $workingTimeStatus) {

			return true;

		}

		return false;

	}

	/**

	  * @desc method to get full day

	  * This method is build specially to match column name with restaurantbooking_working_times table column

	  * @param $shortDay string

	  * @return $fullDayName

	*/

	public function getFullDayNameFromDate($searchDate) {

		// This method day name in small format like mon,sun etc

		$fullDayFormatArray = array('mon' => 'monday',

									'tue' => 'tuesday',

									'wed' => 'wednesday',

									'thu' => 'thursday',

									'fri' => 'friday',

									'sat' => 'saturday',

									'sun' => 'sunday'

								    );

		$nameOfDay = strtolower(date('D', strtotime($searchDate)));

		// we need to convert day to full day name to match with

		return $fullDayFormatArray[$nameOfDay];

	}

	/**

	  * @desc method to check working time

	  * This method check if restaurant working time meets our cureent date and time

	  * @param $searchDate,$businessId,$timeId

	  * @return $dayOffStatus

	*/

	public function getRestaurantWorkingTimeOffStatus($searchDate,$timeId,$businessId) {

		$isDayOff = false;

		$converteDay = $this->getFullDayNameFromDate($searchDate);

       $sqlCheckDefaultTimeSettings = "SELECT

											*

										FROM restaurantbooking_working_times

										WHERE

											".$converteDay."_dayoff = 'T'

										AND

											business_id = ".$businessId;  

		$queryCheckDefaultWorkingTime = $this->db->query($sqlCheckDefaultTimeSettings);

		if($queryCheckDefaultWorkingTime->num_rows() > 0) {

			$isDayOff = true; 

		}

		return $isDayOff;

	}

	/**

	  * @desc method to check custom day off

	  * This method check if restaurant is closed by custom settings

	  * @param $businessId,$searchDate

	  * @return $offStatus boolean

	*/

	public function customWorkingTimeOffStatus($businessId,$searchDate) {

		$isDayOff = false;

		 $sqlCustomDateEntry = "SELECT * FROM restaurantbooking_dates a

										WHERE a.date = '".$searchDate."'

										 AND a.is_dayoff = 'T'

										 AND a.business_id = ".$businessId;


		$queryCustomDateEntry = $this->db->query($sqlCustomDateEntry);

		$customDateResult     = $queryCustomDateEntry->result_array();

		if($queryCustomDateEntry->num_rows() > 0) {

			$isDayOff = true;

		}

		return $isDayOff;



	}

	/**

	  * @desc method to get actual time from timeId

	  * @access public

	  * @param $timeId,

	  * @return $time

	*/

	public function getOrigninalTime($timeId) {

		$timeId = (int)$timeId;

		$sqlGetOrginalTime = "SELECT

				    		a.time AS originalTime

						FROM snap_start_time a

						WHERE

							a.id = ".$timeId;

		$queryGetOrginalTime = $this->db->query($sqlGetOrginalTime);

		$resultGetOrginalTime = $queryGetOrginalTime->row();

		return $resultGetOrginalTime->originalTime;



	}

	/**

	  * @desc method to get default booking length

	  * @access public

	  * @param $businessId

	  * @return $bookingLength in mnt

	*/

	public function getDefaultBookingOptions($businessId) {

		$businessId = (int)$businessId;

		$data['restaurantOptionstatus'] = 0;

		$sqlGetBookingOptions = "SELECT

									a.booking_length AS bookingLength,

									a.booking_price AS bookingPrice,

									a.booking_earlier AS bookingEarlier

								FROM restaurantbooking_business_options a

								WHERE a.business_id = ".$businessId;

		$queryGetBookingOptions = $this->db->query($sqlGetBookingOptions);

		if($queryGetBookingOptions->num_rows() > 0) {

			$data['restaurantOptionstatus'] = 1;

			$data['bookingData'] = $queryGetBookingOptions->row();

		}

		return $data;



	}

	/**

	  * @desc method to get time with some addition mnt

	  * @access public

	  * @param $time,$plusMinutes

	  * @return $additionTime

	*/

	public function addMinutesToTime($time, $plusMinutes ) {

	    $time = new DateTime($time);

	    $time->add( new DateInterval( 'PT' . ( (integer) $plusMinutes ) . 'M' ) );

	    $newTime = $time->format( 'g:i:s' );

	    return $newTime;

	}

	/**

	  * @desc method to get snap_start_day_id

	  * @param $date

	  * @return $dayId int

	*/

	public function getSnapStartDayId($date) {

		$dayName = $this->getFullDayNameFromDate($date);

		$sqlGetSnapWeekDayId = "SELECT id FROM snap_week_days WHERE day LIKE '%$dayName%'";

		$queryGetSnapWeekday = $this->db->query($sqlGetSnapWeekDayId);

		if($queryGetSnapWeekday->num_rows() >0){

			$resultDayId = $queryGetSnapWeekday->row();

			return $resultDayId->id;

		}

		return false;

	}

	/**

	  * @desc method to get all food offered by restaurant

	  * @access public

	  * @param $businessId int

	  * @return array

	*/

	public function getFoodOfferredByRestaurant($businessId) {

		if(! $businessId) {

			return;

		}

		$businessId = (int)$businessId;

		// sql to fetch all food offered by restaurant

		$sqlGetFoodOffered = "SELECT

									b.food_name AS foodName

							  FROM restaurantbooking_food_offered_type a

							  INNER JOIN

							  		restaurantbooking_food_offered b

							  ON (a.food_id = b.id)

							  WHERE a.business_id = ".$businessId;

		$queryGetFoodList = $this->db->query($sqlGetFoodOffered);

		return $queryGetFoodList->result_array();

							  	

	}

	/**

	  * @desc method to get original snap percentage

	  * @access public

	  * @param $percentageId

	  * @return $percentage int

	*/

	public function getSnapPercentage($percentageId) {

		if(!$percentageId) {

			return;

		}

		$sqlGetDisCountPercentage = "SELECT discount_percentage FROM snap_discount_table WHERE id =".$percentageId;

		$queryDiscountPercentage  = $this->db->query($sqlGetDisCountPercentage);

		$resultDiscountPercentage = $queryDiscountPercentage->row();

		return $resultDiscountPercentage->discount_percentage;

	}



		public function getadsdetails($businessId) {

		if(!$businessId) {

			return;

		}

		$businessId = (int)$businessId;

	  	  $sqlGetSmartUrl = "SELECT * FROM ads WHERE business_id=".$businessId;

		$querySmartUrl  = $this->db->query($sqlGetSmartUrl);

		return $querySmartUrl->result_array();

	}




	/**

	  * @desc method to get all restaurant smart url

	  * @access public

	  * @param $businessId

	  * @return $smartUrlList array

	*/

	public function getSmartUrl($businessId) {

		if(!$businessId) {

			return;

		}

		$businessId = (int)$businessId;

		$sqlGetSmartUrl = "SELECT smarturl FROM ads WHERE business_id=".$businessId;

		$querySmartUrl  = $this->db->query($sqlGetSmartUrl);

		return $querySmartUrl->result_array();

	}

	/**

	  * @desc method to fetch offerdetails of a  restaurant business

	  * @param $businessId

	  * @return $offerDetails

	*/

	public function getBusinessDiningOfferDetails($businessId) {

		$businessId = (int)$businessId;

		$sql = "SELECT

					a.snap_week_day_id AS snapWeekDay,

					a.snap_time_id AS snapTimeId,

					a.snap_percentage AS snapPercentage,

				    d.discount_percentage AS discountPercentage

				FROM restaurantbooking_business_snap_offered a

				INNER JOIN snap_week_days b

				INNER JOIN snap_start_time c

				INNER JOIN snap_discount_table d

				INNER JOIN restaurantbooking_business_snap_status e

				ON (a.snap_week_day_id = b.id AND a.snap_time_id = c.id AND a.snap_percentage = d.id AND a.business_id = e.business_id)

				WHERE a.business_id =".$businessId." AND e.snap_status = 1";

		$query = $this->db->query($sql);

		$resltData = $query->result_array();

		$formattedResultArray = array();

		$formattedResultArray['status'] = 0;

		if($query->num_rows() >0) {

			foreach ($resltData as $value) {

				$formattedResultArray[$value['snapWeekDay']][$value['snapTimeId']] = $value['discountPercentage'];

			}

			$formattedResultArray['status'] = 1;

		}

		return $formattedResultArray;



	}

	/**

	  * @desc method to show all timelist

	  * @return $timeListArray

	*/

	public function getTimeListArray() {
		$finalTimeArray = array();
		$sql = "SELECT * FROM snap_start_time WHERE `time`>='10:00:00'";
		$result = $this->CommonController->SelectRawquery($sql, 'resultArray');
		foreach ($result as $value) {
			$finalTimeArray[$value['id']] = $value['time'];
		}
		return $finalTimeArray;
	}

	/**

	  * @desc method to check if snap settings discoun

	  * matches restaurant discount criteria

	  * @param $businessId,$searchDate,$timeId

	  * @return boolean

	*/

	public function checkSnapFilterSettingsCriteria($businessId,$searchDate,$timeId,$userId,$zoneId) {

		$businessId = (int)$businessId;

		$userId     = (int)$userId;

		$zoneId     = (int)$zoneId;

		$snapStartDayId = $this->getSnapStartDayId($searchDate);

		$customBusinessFilterCheckStatus     = false; // Priority 2

		$customBusinessOnStatus              = false; // Priority 1

		$globalBusinessFilterStatus          = false; // Priority 3

		$sqlCheckCustomSnapFilterSetting     = "SELECT

													snap_days_id,

													snap_time_id,

													snap_min_percentage_id,

													status

											    FROM user_offer_status

											    WHERE createdby_id = ".$businessId." AND user_id =".$userId;

		$queryCheckCustomSnapFilterSetting   = $this->db->query($sqlCheckCustomSnapFilterSetting);

		if($queryCheckCustomSnapFilterSetting->num_rows() >0) {

			$resultCheckCustomSnapFilterSetting  = $queryCheckCustomSnapFilterSetting->row();

			$customBusinessOnStatus              = $resultCheckCustomSnapFilterSetting->status;

			if($customBusinessOnStatus) {

				$checkWithinDate = in_array($snapStartDayId,explode(',',$resultCheckCustomSnapFilterSetting->snap_days_id));



				$checkWithinTime = ($resultCheckCustomSnapFilterSetting->snap_time_id == 0) ? true : in_array($timeId,explode(',',$resultCheckCustomSnapFilterSetting->snap_time_id));



				$checkPercentageStatus = $this->checkSnapPercentageStatus($snapStartDayId,$timeId,$resultCheckCustomSnapFilterSetting->snap_min_percentage_id,$businessId);



				$customBusinessFilterCheckStatus = ($checkWithinDate && $checkWithinTime && $checkPercentageStatus) ? true : false;

			}

		} else {

			$sqlCheckGlobalSnapSettings    =   "SELECT

													snap_week_days,

													snap_start_time,

													snap_minimum_percentage

												FROM global_snap_settings

												WHERE created_for_zone = ".$zoneId." AND user_id=".$userId." AND status=1";

			$queryCheckGlobalSnapSettings  = $this->db->query($sqlCheckGlobalSnapSettings);

			if($queryCheckGlobalSnapSettings->num_rows() >0) {

				$resultGlobalSnapSettings = $queryCheckGlobalSnapSettings->row();

				$checkGlobalWithinDate = in_array($snapStartDayId,explode(',',$resultGlobalSnapSettings->snap_week_days));

				$checkGlobalWithinTime = ($resultGlobalSnapSettings->snap_start_time == 0) ? true : in_array($timeId,explode(',',$resultGlobalSnapSettings->snap_start_time));

				$checkGlobalPercentage = $this->checkSnapPercentageStatus($snapStartDayId,$timeId,$resultGlobalSnapSettings->snap_minimum_percentage,$businessId);

				$globalBusinessFilterStatus = ($checkGlobalWithinDate && $checkGlobalWithinTime && $checkGlobalPercentage) ? true : false;

			}

		}

		return ($customBusinessOnStatus) ? $customBusinessFilterCheckStatus : $globalBusinessFilterStatus;



	}

	/**

	  * @desc method to check snap percentage criteria matches

	*/

	public function checkSnapPercentageStatus($snapStartDayId,$timeId,$snamMinimumPercentageId,$businessId) {

		$snapStartDayId            = (int)$snapStartDayId;

		$timeId                    = (int)$timeId;

		$snamMinimumPercentageId   = (int)$snamMinimumPercentageId;

		$businessId                = (int)$businessId;

		$checkPercentageStatus = false;

		$sqlGetDisCountPercentage = "SELECT id

									 FROM restaurantbooking_business_snap_offered

									 WHERE snap_week_day_id = ".$snapStartDayId."

									 AND snap_time_id = ".$timeId."

									 AND snap_percentage >=".$snamMinimumPercentageId." AND business_id =".$businessId;

		$queryGetDiscountPercentage = $this->db->query($sqlGetDisCountPercentage);

		if($queryGetDiscountPercentage->num_rows() >0) {

			$checkPercentageStatus = true;

		}

		return $checkPercentageStatus;

	}

}





?>