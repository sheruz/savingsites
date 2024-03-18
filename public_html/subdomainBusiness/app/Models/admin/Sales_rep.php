<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_rep extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_sales_reps()
    {
        $query = $this->db->query('SELECT t1.id as repid, t1.firstname, t1.lastname, t1.email, t1.addressid,
            t2.street_address_1, t2.street_address_2, t2.city, t2.state, t2.zip_code, t2.phone
            FROM sales_rep AS t1 INNER JOIN address AS t2 ON t1.addressid = t2.id');
        return $query->result_array();
    }

    public function json_result($id)
    {

        $query = $this->db->query('SELECT t1.id as repid, t1.firstname, t1.lastname, t1.email, t1.addressid,
            t2.street_address_1, t2.street_address_2, t2.city, t2.state, t2.zip_code, t2.phone
            FROM sales_rep AS t1 INNER JOIN address AS t2 ON t1.addressid = t2.id where t1.id = ' . $id);
        echo(json_encode($query->row()));
    }

    public function save_sales_rep()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
        $addressId = $_REQUEST['addressid'];
        $street1 = $_REQUEST['street1'];
        $street2 = $_REQUEST['street2'];
        $city = $_REQUEST['city'];
        $state = $_REQUEST['state'];
        $zipcode = $_REQUEST['zipcode'];
        $phone = $_REQUEST['phone'];

        $addressData = array(
            'street_address_1' => $street1,
            'street_address_2' => $street2,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zipcode,
            'phone' => $phone
        );

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
        );
        if(!empty($id) && $id > 0)
        {
            //update
            $this->db->where('id', $id);
            $this->db->update('sales_rep', $data);

            $this->db->where('id', $addressId);
            $this->db->update('address', $addressData);
        }
        else
        {
            //insert
            $this->db->insert('address', $addressData);
            $data['addressid'] = $this->db->insert_id();
            $this->db->insert('sales_rep', $data);
        }
        echo($this->dr->GetDR("Save Successful", "The save was successful", "", "0"));;
    }
}
