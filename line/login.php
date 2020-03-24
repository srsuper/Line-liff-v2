<?php
    require 'connectdb.php';
    
    $login_username = mysqli_real_escape_string($dbcon,$_POST['username']);
    $login_password = mysqli_real_escape_string($dbcon,$_POST['password']);
    
    $salt = 'tikde78uj4ujuhlaoikiksakeidke';
    $hash_login_password = hash_hmac('sha256', $login_password, $salt);
    
    $sql = "SELECT * FROM site WHERE username=? AND password=?";
    $stmt = mysqli_prepare($dbcon, $sql);
    mysqli_stmt_bind_param($stmt,"ss", $login_username,$login_password);
    mysqli_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);
    if ($result_user->num_rows == 1) {
        session_start();
        $row_user = mysqli_fetch_array($result_user,MYSQLI_ASSOC);
        $_SESSION['login_id'] = $row_user['ID'];
        $_SESSION['login_name'] = $row_user['name'];
        header("Location: main.php");
    } else {
        echo "ผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
    