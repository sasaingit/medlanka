<?php include("includes.php"); ?>

<?php
//check whether user logged in or not
session_start();
$json_encoded_user 	= $_SESSION[$conf['appId'].'_user']; 
$user 				= !empty($json_encoded_user)?json_decode($json_encoded_user):null;
session_write_close ();

$appFb = new AppFb();
$appFb->init($conf);

$manager = new appManager();
$manager->init($conf);

$method = $_REQUEST['method'];
$params = $_REQUEST;
error_log("user in action:".print_r($user,true));

$actionManager = new actionManager();
echo json_encode($actionManager->handleAction($user,$method,$params,$manager,$appFb));
?>