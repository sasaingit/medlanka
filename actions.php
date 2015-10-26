<?php include("includes.php"); ?>

<?php
$init_user =  new stdClass();
session_start();
$user_fb_id = $_SESSION[$conf['appId'].'_user_fb_id']; // store session data
session_write_close ();

$init_user->fb_id = $user_fb_id;
$manager = new appManager();
$manager->init($conf);

$appFb = new AppFb();
$appFb->init($conf);


$user = $manager->setupUser($init_user);
$method = $_REQUEST['method'];
$params =  $_REQUEST;
error_log("user in action:".print_r($init_user,true));

$actionManager = new actionManager();
echo json_encode($actionManager->handleAction($user,$method,$params,$manager,$appFb));
?>