<?php 

$_POST['ID'] = "19149";
require_once 'header.php';
require_once 'includes/config.php';
require_once 'classes/DbConnect.php';


if (isset($_POST["ID"])){
        

    $ID = $_POST["ID"];
    //echo $macaddress;
    
    $sql = "SELECT messages FROM seeoil.store_json where ID = $ID";
    $results = run_querys($sql);
    echo $results;

    if (count($results) > 0) {
        $row = $results[0];
        //echo $row;
        //echo $row["Volume"];
        //echo $row["user_id"];
        //echo "Success";
        $json = json_encode($results);
        header('Content-Type: application/json');
        echo $json;

    } else {
        //echo "Fail";
        
        $myObj->flex_type = "None";
        $myObj->type_test = "None";
        $myJSON = json_encode($myObj);
        header('Content-Type: application/json');
        echo $myJSON;
    }
}



function run_querys($sql) {

    // Create connection
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $conn->query("SET NAMES utf8");
    if (!$conn) {die("Connection failed: " . mysqli_connect_error());}
    
    $result = mysqli_query($conn,$sql);
    $rows = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    } else {
        die("Query Failed.");
    }
    
    mysqli_free_result($result);
    mysqli_close($conn);
    

    return $rows;
}








?>