<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
#[\AllowDynamicProperties]
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
    public $twilioSSID = 'AC10c30c235f9022b1c216293b54c55a12'; 
    public $twilioAuthToken = 'ca356a98ad5a75b78af6e418b44c19ad'; 
    public $twilioNumber = '+18886085359'; 
    public $ChatGPTApi = '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'; 
    public $ChatGPTURL = 'https://api.openai.com/v1/chat/completions'; 
    public $AWSimageurl = 'https://cdn.savingssites.com';
}
