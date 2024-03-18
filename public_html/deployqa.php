<?php
/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying websites via GitHub
 * Based on: https://gist.github.com/oodavid/1809044
 */

$key = 'AlfonseIngaSavingssites';

if ($_GET['key'] != $key){
    header('Location: ./');
    die();
}
    
// array of commands
$commands = array(
    'whoami',
    'git checkout -- .',
    'git pull github qa',
    'git status',
    'git submodule sync',
    'git submodule update',
    'git submodule status',
);

chdir("/home/qasavingssites/savingssites_root");

// exec commands
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<div style="width:700px">
    <div style="float:left;width:350px;">
    <p style="color:white;">Git Deployment Script</p>
    <?php
    foreach($commands AS $command){
        echo htmlentities($command) . "\n<br />";
        $tmp = shell_exec($command);
        echo htmlentities(trim($tmp)) . "\n<br /><br />";
    }
 ?>
    </div>
</div>
</body>
</html>
