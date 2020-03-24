<?php
	
	$dbcon = mysqli_connect ('www.seeoil-web.com','seeoil','25242524','seeoil');

	if (mysqli_connect_errno()){

		echo "ไม่สามารถติดต่อฐานข้อมูลได้".mysqli_connect_error();
		exit;
	}
	mysqli_set_charset ($dbcon,'utf8');
	
?>