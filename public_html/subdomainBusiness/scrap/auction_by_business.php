<?php
/**
* class to Get auction by business name
*/
class Auction
{
	private $zoneId="demo";
	private $businessId="demo 1";
	public $mysqli;

	function __construct()
	{
		/*Server setup strat*/
		$hostname='localhost';
		$database='savingssites';
		$username='savingssites_new';
		$password='z9wlq2sOS8E6QU1P';
		$hide = 0 ;
		$this->mysqli = new mysqli($hostname,$username,$password,$database);
		/* check connection */
		if ($this->mysqli->connect_errno)
		{
			printf("<p class='alert-danger'>Connect failed: %s\n</p>", $this->mysqli->connect_error);
			exit();
		}
		else
		{
			printf("<p class='alert-success'>connected to server.. version: %s\n", $this->mysqli->server_info);
			echo ' | Current user: ' . get_current_user()."</p><br/>";
		}
		/*Server setup end*/
		$this->zoneId = (isset($_REQUEST['z']))? $_REQUEST['z'] : "213";
		$this->businessId = (isset($_REQUEST['b']))? $_REQUEST['b'] : "213";
		echo "Zone Id:		".$this->zoneId."<br />";
		echo "Business Id:	".$this->businessId."<br />";
	}
	/**
	* Get auction by business name
	*/
	function show_auction_by_business(){

		$sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$this->zoneId' and b.id='$this->businessId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";
		$query=$this->mysqli->query($sql);
		$business_peekaboo=$query->fetch_assoc(); 
		echo "<pre>";
		echo $sql;
		print_r($business_peekaboo);
		echo "</pre>";
		$username = $business_peekaboo['username']; 
		$busid = $business_peekaboo['busid'];
		$current_date = date('Y-m-d');

		// $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status='Live' and c.id='$adId' order by b.auc_id DESC,d.product_name DESC limit 1"; 
		$peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live','Public') and c.id='$this->businessId' and b.start_date<='$current_date' and b.product_id=d.product_id group by b.auc_id order by b.start_date ASC,d.product_name";
		$peekaboo_popup =$this->mysqli->query($peekaboo_popup_sql);
		//$peekaboo_popup_show = $peekaboo_popup->fetch_assoc();///echo "<pre>"; var_dump($peekaboo_popup_show);//exit;
		$peekaboo_popup_show = array();
		while ($dataname = $peekaboo_popup->fetch_assoc()) { 
			$peekaboo_popup_show[] = $dataname;
			echo "<pre>";
			//echo $peekaboo_popup_sql;
			print_r($dataname);
			echo "</pre>";
		}
		echo "<pre>";
		//echo $peekaboo_popup_sql;
			print_r($peekaboo_popup_show);
		echo "</pre>";
		// ++ Add remaining time of each auction
		foreach($peekaboo_popup_show as $key=>$val){
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
		$peekaboo_popup_show[$key] = array_merge($val,$arr) ;
		}
		// -- Add remaining time of each auction
		return $peekaboo_popup_show;
	}
}

$auction = new Auction;
$auctions = $auction->show_auction_by_business();
echo "<pre>Hello";
print_r($auctions);