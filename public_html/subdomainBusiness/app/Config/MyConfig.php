<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyConfig extends BaseConfig
{
    
    
    public $adminEmailId= 'DoNotReply@HGD.deals';
    public $fromemail = 'DoNotReply@HGD.deals';
    public $hash_method = 'sha1';
    public $store_salt = FALSE;
    public $salt_length = 10;
    public $remember_users= TRUE;
    public $track_login_attempts= FALSE;
    public $identity_column= 'username';
    public $identity = 'username';               // A database column which is used to login with
    public $identityzone = 'username';               // A database column which is used to login with
    public $identitybusiness = 'username';               // A database column which is used to login with
    public $identityorg = 'email';              // A database column which is used to login with
    public $identityuser = 'email'; 
    public $AWSimageurl = 'https://cdn.savingssites.com';
    public $referAmount = 8;
    public $buinessshareurl = 'https://www.snap.deals'; // business detail page share url
    public $residentshareurl = 'http://www.givebysaving.com'; // resident page invite url
}