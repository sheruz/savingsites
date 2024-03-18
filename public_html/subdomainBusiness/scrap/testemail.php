<?php
$to = "anish.sett@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: noreply@savingssites.com" . "\r\n" ;

$res = mail($to,$subject,$txt,$headers);
var_dump($res);
?>