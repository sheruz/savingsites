<?php
class Uploadmovers extends CI_Model{
	public function __construct(){
		parent::__construct();
        $this->load->database();
    }
    function multiexplode ($delimiters,$data) {
    $MakeReady = str_replace($delimiters, $delimiters[0], $data);
    $Return    = explode($delimiters[0], $MakeReady);
    return  $Return;
}
    public function insertmovers($dataarr='')
    	{        

        if ($dataarr['month_moved']){
          // $new_arr = explode(",",$dataarr['month_moved']);
            $new_month_arr = $this->multiexplode(array(","," ","/","-","&"),$dataarr['month_moved']);

           $dataarr['month'] = strlen($new_month_arr[0])==1 ? "0".$new_month_arr[0] : $new_month_arr[0];
           $dataarr['year'] = strlen($new_month_arr[1])==2 ? "20".$new_month_arr[1] : $new_month_arr[1];
        }
        $q = $this->db->get_where('movers_details', array('phone_number' => $dataarr['phone_number']));
      //  $this->db->reset_query();
      //  echo $q->num_rows()."<br />";
            if ( $q->num_rows() == 0 ) 
            {
           $this->db->insert('movers_details',$dataarr);
           $insertid=$this->db->insert_id();
          // echo $insertid."<br /><br />";
            }else{
           //     echo "Ignored";
            }
    	}
    public function updatepackages($value='')
        {
        $query = $this->db->get_where('local_directory_sales_dup', array('meta_key' => $value['meta_key']));
        $num = $query->num_rows();
       // $last = $this->db->last_query();
        if ($num>0){
            $this->db->where('meta_key', $value['meta_key']);
            $this->db->update('local_directory_sales_dup', $value);
            $banner_id=$this->db->insert_id();
        echo $banner_id;   
        }
        else{
        $this->db->insert('local_directory_sales_dup',$value);
        $banner_id=$this->db->insert_id();
        echo $banner_id;         
        }
        }
        public function chkpkgarr($value='')
        {
        $this->db->select("*");
        $this->db->from('local_directory_sales_dup');
        $this->db->where_not_in('meta_key', $value);
        $query = $this->db->get();
        $dataaa =  $query->result();
        foreach ($dataaa as $value) {
        $this ->db-> where('id', $value->id);
        $this ->db-> delete('local_directory_sales_dup');
        }
        }
        function local_directory_sales_dup($value='')
        {
        $sql1="SELECT * from local_directory_sales_dup WHERE `active` = '1' ";
        $query1=$this->db->query($sql1);
        $result=$query1->result_array();
        return $result;
        }
        function getpaidzips($month='',$year='')
        {
$sql1 = "SELECT  t1.id as movers_id, t1.first_name as movers_first_name,t1.last_name as movers_last_name ,t1.postal_address as movers_postal_address, t1.zip as movers_zip, t1.month_moved as movers_month_moved, t1.phone_number as movers_phone_number,CONCAT('http://development.savingssites.com/movers/search/',t4.zone_id) as movers_URL
FROM movers_details t1 INNER JOIN zip_code_zone t4 ON t1.zip= t4.zip_code where t1.month=$month and t1.year=$year";
                $query1=$this->db->query($sql1);
        $result=$query1->result_array();
        return $result;
        }
        function changestatus($multipleWhere='',$value)
        {
        $this->db->where($multipleWhere);
        $this->db->update('movers_details', $value);
        return $this->db->affected_rows();
        }
        function deliverdorno($multipleWhere='')
        {
        $query = $this->db->get_where('movers_details', $multipleWhere);
        $num = $query->num_rows();
        $result=$query->result_array();
        return $result;
        }
        function debitpbgcredit($month='',$year='')
        {
$sql1 = "SELECT count(b.business_id) as moverscount, b.business_id , c.id as pbguserid FROM  movers_details a INNER JOIN  pbg_zips b ON a.zip=b.zipcode INNER JOIN  pbg_user c ON b.business_id=c.business_id WHERE a.month=$month AND a.year = $year group by b.business_id";
        $query1=$this->db->query($sql1);
        $result=$query1->result_array();
        //return $result;
        foreach ($result as $key => $value) {
            $paymentarr = array('credit'      => 0 ,
            'debit'       =>$value['moverscount'],
            'pbg_user_id' => $value['pbguserid'],
            'time'        =>date('y-m-d h:i:s')
            );
            $this->db->insert('pbg_credit', $paymentarr);
            echo $this->db->insert_id();
        }
        }
  }
?>