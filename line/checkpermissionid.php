<?php 

//$_POST['groupid']='Cb2503fd5c9426b9568deff6a69970789'; // Caltex ศรีสยาม
//$_POST['groupid']='Ca3190787bda9b1caf5287a79f395d41b'; // PTT เลยปิโตรเลียม
//$_POST['groupid']='C88f9729c09cadd8e0078405e9fb0a8c4'; //PTT LTM
//$_POST['groupid']='Cbe563455d346cacf12ad0ff206eb3d00'; // PTT สุรชัยสำนักงานใหญ่
//$_POST['groupid']='C862c29dc401a15fb59c87372566f3a5a'; // PTT เมืองแสนปิโตรเลียม
// $_POST['groupid']='C524f74c7b30e53cc475b7b24a22998a1'; // PTT กนกนภา
// $_POST['userid']='U39de91b2844df3cc53a6889fa7955812';

function sentnotify_userlifflogin($site_name,$user_id){
            date_default_timezone_set('Asia/Bangkok');
            $date = date('m/d/Y H:i a', time());
            $lineapi = "39fEEnOuJpPPvoczE1VrNTl0MYcy0MSX8AvzrrugdIy"; // ใส่ token key ที่ได้มา
            $mms =  'LiffUsed : '.$site_name."\n".'เมื่อเวลา : '.$date;
            date_default_timezone_set("Asia/Bangkok");
            $chOne = curl_init(); 
            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt( $chOne, CURLOPT_POST, 1); 
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
            curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
            $result = curl_exec( $chOne ); 
            //Check error 
            if(curl_error($chOne)) 
            { 
                echo 'error:' . curl_error($chOne); 
            } 
            else { 
            $result_ = json_decode($result, true); 
            echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                } 
            curl_close( $chOne );   
    
}

function setuserlifflogin ($site_id,$user_id,$site_groupid,$site_userid){
            $servername = "www.see-oilweb.com";
            $username = "seeoil";
            $password = "25242524";
            $dbname = "seeoil";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO updateuserlogin (site_id, user_id, group_id,line_user_id) VALUES (?, ?, ?,?)");
            $stmt->bind_param("ssss", $site_id,$user_id,$site_groupid,$site_userid);
            //$group_id_bid = $site_groupid;
            $stmt->execute();
            echo "New records created successfully";
            $stmt->close();
            $conn->close();
}

include 'connectdb.php';
if (isset($_POST["groupid"]) && isset($_POST['userid'])){
	$site_userid_line = $_POST['userid'];
    $site_groupid = $_POST['groupid'];
	$sql = "SELECT site_id,site_profile.user_id,bir,name as site_Name , site_profile.user_type FROM seeoil.site_profile
    INNER JOIN site on site.ID = site_profile.site_id 
    where site_profile.group_id = ?";; // เอา Group Id ไปเช็คในตารางเพื่อหาว่ามี groupId นี้อยู่หรือ ถ้ามีก็ให้ return userId กลับมาให้ แต่ถ้าไม่มีระบบก็จะ alart คุณไม่ได้รับอนุญาติให้เข้าใช้งาน
    $stmt = mysqli_prepare($dbcon, $sql);
    mysqli_stmt_bind_param($stmt,"s", $site_groupid);
    mysqli_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);

    if ($result_user->num_rows == 1) {

		$row_user = mysqli_fetch_array($result_user,MYSQLI_ASSOC);
		$user_id = $row_user['user_id']; // ประกาศตัวแปร user_id
		echo $A = "userid check from group".$user_id."<br>";
        $site_id = $row_user['site_id']; // ประกาศตัวแปร site_id
        echo $A = "siteid check from group".$site_id."<br>";
        $bir_status = $row_user['bir']; // ประกาศตัวแปร bir
        echo $A = "siteid BIR group".$bir_status."<br>";
        $site_name = $row_user['site_Name']; // ประกาศตัวแปร site_name
        echo $A = "Name is".$site_name."<br>";
        $user_type_check = $row_user['user_type']; // ประกาศตัวแปร user_type
		//echo $site_id;

        $sql2 = "SELECT user_id FROM user_check WHERE line_id=? ";  // ขอ user_id จากการเช็คจาก line_id
        
		$stmt1 = mysqli_prepare($dbcon, $sql2);
    	mysqli_stmt_bind_param($stmt1,"s", $site_userid_line);
    	mysqli_execute($stmt1);
        $result_query = mysqli_stmt_get_result($stmt1);
        $resultArray = array();

        while($result = mysqli_fetch_array($result_query,MYSQLI_ASSOC))
        {
            array_push($resultArray,$result);
        }
        $found = in_array($user_id, array_column($resultArray, 'user_id')); // เอาตัวแปล $user_id จากด้านบนมาเช็ค เพื่อให้รู้ว่าเป็นสถานีแบบ group หรือ ทั่วไป 

        if ($found) { 
                //setuserlifflogin($site_id,$user_id,$site_groupid,$site_userid_line); // เอา data ไป login
                session_destroy();
				session_start();
				$_SESSION['type_where'] = "user_id";
                $_SESSION['type_userid'] = $user_id;
                $_SESSION['bir_status_check'] = $bir_status;
                //sentnotify_userlifflogin($site_name,$user_id);
                header("location:mainpage.php");
        } elseif ($user_type_check  == "all") {
                //setuserlifflogin($site_id,$user_id,$site_groupid,$site_userid_line); // ถ้า user_type_check == 'all' ก็ให้แสดงข้อมูลทั้งหมด ใครๆในกลุ่ม line ก็จะเข้าได้หมด
                session_destroy();
                session_start();
                $_SESSION['type_where'] = "user_id";
                $_SESSION['type_userid'] = $user_id;
                $_SESSION['bir_status_check'] = $bir_status;
                sentnotify_userlifflogin($site_name,$user_id);
                header("location:mainpage.php");
               
        } else { // ถ้าเช็คเจอว่า ไม่อยู่สถานะ group ก็ให้ส่งเข้ามาเพื่อป้อนข้อมูลแบบ site_id จะไม่สามารถเห็นข้อมูลแบบข้ามกลุ่มได้ 
                session_destroy();
                session_start();
                //setuserlifflogin($site_id,$user_id,$site_groupid,$site_userid_line);
                $_SESSION['type_where'] = "ID";
                $_SESSION['type_userid'] = $site_id;
                $_SESSION['bir_status_check'] = $bir_status;
                sentnotify_userlifflogin($site_name,$user_id);
                header("location:mainpage.php");
        }
		} else {

			echo "คุณไม่ได้รับอนุญาติให้เข้าใช้งาน";
		}
			
  


    


    }


?>