<?php include("config.php"); ?>
<?php include("core/fbApp.php"); ?>
<?php include("core/appManager.php"); ?>
<?php include("core/actionManager.php"); ?>

<?php
include_once('/usr/lib/php5/adodb/adodb5/adodb.inc.php');
include_once('/usr/lib/php5/adodb/adodb5/adodb-active-record.inc.php');

$ADODB_ASSOC_CASE = 2;
$db = NewADOConnection('mysql://root:sasa123Nga@localhost/medlanka');
ADOdb_Active_Record::SetDatabaseAdapter($db);

class User extends ADOdb_Active_Record{}
class Admin extends ADOdb_Active_Record{}
class Comment extends ADOdb_Active_Record{}
class Doctor extends ADOdb_Active_Record{}

?>

