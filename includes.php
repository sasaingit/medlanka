<?php include("config.php"); ?>
<?php include("core/fbApp.php"); ?>
<?php include("core/appManager.php"); ?>
<?php include("core/actionManager.php"); ?>

<?php
include_once('lib/adodb5/adodb.inc.php');
include_once('lib/adodb5/adodb-active-record.inc.php');

$ADODB_ASSOC_CASE = 2;
$db = NewADOConnection('mysql://root:wetteest1@localhost/standalone_basic');
ADOdb_Active_Record::SetDatabaseAdapter($db);

class User extends ADOdb_Active_Record{}

?>

