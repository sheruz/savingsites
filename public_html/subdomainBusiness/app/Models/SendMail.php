<?php
namespace App\Models;

use CodeIgniter\Model;
#[\AllowDynamicProperties]
class SendMail extends Model{
    public function __construct(){
        $this->db = \Config\Database::connect();
    } 
}