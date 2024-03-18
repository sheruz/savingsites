<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" href="https://savingssites.com/assets/scrap/css/custom-scrap.css">

<style type="text/css">
  /*  .wrap{
      width: 300px;
    margin: 42px auto;
    text-align: center;
    }
.wrap a {
    color: #203f96;
    text-decoration: none;
    font-size: 19px;
    margin-top: 13px;
    display: inline-block;
} */
</style>
<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	header("Location: https://savingssites.com/scrap");  
}

$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time()+3600, "/"); 



$log_directory = '.';

$results_array = array();

if (is_dir($log_directory))
{
        if ($handle = opendir($log_directory))
        {
                //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
                        $results_array[] = $file;
                }
                closedir($handle);
        }
}
echo "<div class='admin_ligin'><div class='wrap'>";

//Output findings
foreach($results_array as $value)
{   
 
    if(trim($value) == 'users.php' || trim($value) == 'create_zone.php'  || trim($value) == 'deals.php' || trim($value) == 'projects.php' || trim($value) == 'uploadImage.php'){
      echo '<a href="https://savingssites.com/scrap/'.$value.'"> https://savingssites.com/scrap/'.$value.'</a><br />';
   }else{
     
   }
}

echo "</div></div>";