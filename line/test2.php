<?php 

$_POST['groupid']='C9107f81ee505af7d90bf5c5b795f23f5';
$_POST['userid']='U2e0a6d60a5c7df1eca8da371af8fbfc0';

include 'connectdb.php';
if (isset($_POST["groupid"]) && isset($_POST['userid'])){
	$site_userid_line = $_POST['userid'];
	$site_groupid = $_POST['groupid'];

	$sql = "SELECT site_id,user_id FROM seeoil.site_profile where groupid = ?";
    $stmt = mysqli_prepare($dbcon, $sql);
    mysqli_stmt_bind_param($stmt,"s", $site_groupid);
    mysqli_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);
    if ($result_user->num_rows == 1) {
		$row_user = mysqli_fetch_array($result_user,MYSQLI_ASSOC);
		$user_id = $row_user['user_id']."<br>";
		echo $A = "userid check from group".$user_id;
        $site_id = $row_user['site_id'];
        echo $A = "siteid check from group".$site_id."<br>";
        
		//echo $site_id;

		$sql2 = "SELECT user_id FROM user_check WHERE line_id=? ";
		$stmt1 = mysqli_prepare($dbcon, $sql2);
    	mysqli_stmt_bind_param($stmt1,"s", $site_userid_line);
        mysqli_execute($stmt1);
        $resultArray = array();
        $query = mysqli_stmt_get_result($stmt1);
        
        while($result = mysqli_fetch_array($query,MYSQLI_ASSOC))
        {
            array_push($resultArray,$result);
        }
        
		echo '<pre>';
        var_dump($resultArray);
        echo '</pre><hr />';

        // if (array_key_exists("35",$resultArray)){
        //     echo "Found";
            
        // } else {

        //     echo "Not Found";
        // }
        $user_id_test = 23;
        $found = in_array($user_id_test, array_column($resultArray, 'user_id'));
        if ($found) {
            echo "Found";
        } else {
            echo "Not Found";
        }
			
    } else {
        echo $site_groupid;
	}
}








?>