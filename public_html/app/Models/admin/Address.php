<?php
class Address extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('address', array('id' => $id), 1)->result();
        $addr = new AddressImpl();
        $addr->Id = $query->id;
        $addr->StreetLine1 = $query->street_address_1;
        $addr->StreetLine2 = $query->street_address_2;
        $addr->City = $query->city;
        $addr->State = $query->state;
        $addr->ZipCode = $query->zip_code;
        $addr->Phone = $query->phone;
        $addr->Longitude = $query->longitude;
        $addr->Latitude = $query->latitude;

        return $addr;
    }

    public function save($addr)
    {
        if(empty($addr->Id))
        {
            create($addr->StreetLine1,
                $addr->StreetLine2,
                $addr->City,
                $addr->State,
                $addr->ZipCode,
                $addr->Phone,
                $addr->Longitude,
                $addr->Latitude
            );
        }
        else
        {

        }
    }

    public function create($street1, $street2, $city, $state, $zip, $phone = false, $longitude = false, $latitude= false)
    {
        $data = array(
            'street_address_1' => $street1,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip
        );
        if(!empty($street2)){ $data['street_address_2'] = $street2;}
        if(!empty($phone)){ $data['phone'] = $phone;}


        $this->db->insert('address', $data);
    }

}

class AddressImpl
{
    var $StreetLine1;
    var $StreetLine2;
    var $City;
    var $State;
    var $ZipCode;
    var $Id;
    var $Phone;
    var $Longitude;
    var $Latitude;

    public function Changed($street1, $street2, $city, $state, $zip,$id)
    {
        if($id != $this->Id){ return true;}
        if($street1 != $this->StreetLine1){return true;}
        if($street2 != $this->StreetLine2){return true;}
        if($city != $this->City){return true;}
        if($state != $this->State){return true;}
        if($zip != $this->ZipCode){return true;}
        return false;
    }

    public function SingleLineAddress()
    {
        $address = "";
        $address .= empty($this->StreetLine1) ? "" : $this->StreetLine1;
        $address .= empty($this->StreetLine2) ? "" : "," . $this->StreetLine2;
        $address .= empty($this->City) ? "" : "," . $this->City;
        $address .= empty($this->State) ? "" : "," . $this->State;
        $address .= empty($this->ZipCode) ? "" : "," . $this->ZipCode;

        return $address;
    }
}
