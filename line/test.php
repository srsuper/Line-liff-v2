<?php 

//$_POST['groupid']='Cfd835419c5a23519e6471462324f6081';
//$_POST['userid']='U2e0a6d60a5c7df1eca8da371af8fbfc0';
include 'connectdb.php';
if (isset($_POST["groupid"]) && isset($_POST['userid']) && isset($_POST['display_name'])){
	$site_userid_line = $_POST['userid'];
	$site_groupid = $_POST['groupid'];
	$site_display = $_POST['groupid'];
	echo $site_display;

	
}








?>