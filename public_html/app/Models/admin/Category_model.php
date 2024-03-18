<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Category_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    }






    public function get_ads_from_id($adId, $zone = false)
    {
        $sql = "select t1.*,t1.id as ad_id, t2.name as biz_name, t2.website, t2.contactemail as email, t3.*,t4.timezone as timezone, t6.name as categroy, t5.name as business_type from ads as t1 join business as t2 on t1.business_id = t2.id
    	join address as t3 on t2.addressid = t3.id join zipcode as t4 on t4.zip = t3.zip_code join business_category as t6 on t6.id = t1.category_id join business_type as t5 on t5.id = t6.business_type_id 
    	where t1.active = 1 AND
    	t1.id = $adId";
        if(!empty($zone)){
            $sql .= " AND t2.id in (select business_id from business_to_zone where zone_id = $zone)";
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $newresult = array();

        foreach ($result as $result1){

            date_default_timezone_set($result1['timezone']);
            $date = new DateTime();
            $interval = new DateInterval('PT1H');

            $date->add($interval);
            $today =  $date->format('h:i a');
            $inow = convert_to_number($today);

            if($result1['starttime'] <= $inow && $result1['stoptime'] >= $inow){
                $newresult[]=$result1;
            }
        }

        return $newresult;
    }

    public function get_category_subcategory($zone){
        $sql_ad_count = " (select count(*) from ads as t6 where t6.category_id = t2.id AND t6.business_id IN (select business_id from business_to_zone where zone_id = $zone) AND t6.active = 1) as Ad_Count ";
        $sql_option="select category_option from sales_zone where id= $zone";
        $query_option=$this->db->query($sql_option);

        if($query_option->row())
        {
            $cat_option = $query_option->row()->category_option;
        }else{
            $cat_option = 0;
        }

        if($cat_option == 1)
        {
            $sql = "select t1.name as Category, t1.icon_directory as Category_Directory, t1.id as CategoryId, t2.name as SubCategory, t2.id as SubCategoryId
					 , t2.icon_directory as SubCategory_Directory, $sql_ad_count from business_type as t1 join business_category as t2 on t1.id = t2.business_type_id
					order by t1.ordinal, t1.name,t2.ordinal,t2.name";
        }
        elseif($cat_option == 2)
        {
            $sql_category="select category_id from category_exluded where zone_id= $zone";
            $query_category=$this->db->query($sql_category);

            $result_category=$query_category->result();
            $category_array='';
            foreach($result_category as $result_category)
            {
                if($category_array=='')
                {
                    $category_array.="'".$result_category->category_id."'";
                }else{
                    $category_array.=",'".$result_category->category_id."'";
                }

            }

            if(!empty($category_array)){
                $category_array = " and t2.id NOT IN ( $category_array )";
            }
            $sql = "select t1.name as Category, t1.icon_directory as Category_Directory, t1.id as CategoryId, t2.name as SubCategory, t2.id as SubCategoryId
					 , t2.icon_directory as SubCategory_Directory, $sql_ad_count from business_type as t1 join business_category as t2 on t1.id = t2.business_type_id $category_array
					order by t1.ordinal, t1.name,t2.ordinal,t2.name";
        }
        else
        {
            $sql = "select t1.name as Category, t1.icon_directory as Category_Directory, t1.id as CategoryId, t2.name as SubCategory, t2.id as SubCategoryId
					 , t2.icon_directory as SubCategory_Directory, $sql_ad_count from business_type as t1 join business_category as t2 on t1.id = t2.business_type_id
					join ads as t3 on t3.category_id = t2.id
					join business_to_zone as t4 on t3.business_id = t4.business_id
					join business as t5 on t5.id = t4.business_id
					where t4.zone_id = $zone
					order by t1.ordinal, t1.name,t2.ordinal,t2.name";
        }
        $query = $this->db->query($sql);

        $data = array();
        $curId = 0;
        $cat = array();
        foreach($query->result_array() as $q)
        {
            extract($q);
            if($curId == $SubCategoryId){ continue;}
            $curId = $SubCategoryId;
            $subcatDir = empty($SubCategory_Directory) ? strtolower($SubCategory) : $SubCategory_Directory;
            $catDir = empty($Category_Directory) ? strtolower($Category) : $Category_Directory;

            $data[] = array('SubCategoryId' => $SubCategoryId, 'SubCategory' => $SubCategory, 'Category' => $Category, 'Ad_Count' => $Ad_Count
            , "CategoryDirectory" => $catDir, "SubCategoryDirectory" => $subcatDir
            );
        }

        return $data;

    }
    public function get_categories_for_index()
    {
        $sql = "select t1.*, t2.id as bti, t2.name as btn from business_category as t1
                join business_type as t2 on t1.business_type_id = t2.id
                order by t1.business_type_id, t1.ordinal";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_categories()
    {
        $query = $this->db->query('SELECT * from business_category order by name, business_type_id');
        return $query->result_array();
    }
    public function get_all_subcategories()
    {
        $this->db->order_by("name", "asc");
        return $this->db->get('business_category')->result_array();
    }

    public function get_category_tree(){
        $cat_tree = new CategoryTree();
        foreach($this->get_categories() as $ra)
        {
            $cat_tree->addCategory($ra['id'], $ra['name']);
        }

    }

    public function get_category_display($category_display_type){
        switch($category_display_type)
        {
            case "1":
            {
                return "Show All Categories";
            }
            case "2":
            {
                return "Show All Categories except those I exclude";
            }
            default:
                {
                return "Only Show Categories for Ads I have";
                }
        }
    }

    public function get_excluded_for_zone($zone_id)
    {
        $sql_category="select category_id from category_exluded where zone_id= $zone_id";
        $query = $this->db->query($sql_category);

        return $query->result_array();

    }
    function zone_locator($zoneId,$user_id)
    {
        $sql="select * from zone_locator where zone='".$zoneId."' and user='".$user_id."'";
        $query = $this->db->query($sql);

        if($query->num_rows()==1)
        {
            return $query->row()->id;
        }
        else
        {
            return false;
        }
    }
    function zone_locator_all($user_id)
    {
        $sql="select l1.id as loc_id,z1.name,z1.id from sales_zone as z1 join zone_locator as l1 on l1.zone=z1.id where l1.user='".$user_id."'";
        $query = $this->db->query($sql);

        if($query->num_rows()>=1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    function get_all_zone_state()
    {
        $sql="select * from sales_zone  order by state";
        $query = $this->db->query($sql);

        if($query->num_rows()>=1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	function get_category_for_zone(){
		$query = $this->db->query('SELECT * from category_new');
		return $query->result_array();
	}

}

class CategoryTree
{
    var $categories;

    public function addSubCategory($id, $name, $category)
    {
        foreach($this->categories as $cat)
        {
            if($cat->id == $category){
                $sc = new SubCategory();
                $sc->id = $id;
                $sc->name = $name;
                $cat->subCategories[] = $sc;
            }
        }
    }
    public function addCategory($id, $name){
        $ci = new CategoryItem();
        $ci->name = $name;
        $ci->id = $id;
        $this->categories[] = $ci;
    }
    public function __construct(){
        $this->categories = array();
    }
}
class CategoryItem
{
    var $name;
    var $subCategories;
    var $id;
    public function __construct()
    {
        $this->subCategories = array();
    }
}

class SubCategory
{
    var $name;
    var $id;
}