<?php
	
// configure limit time
$limit_send_messages = 100;
$limit_img_generate_time = 5;
$limit_line_upload_time = 30;

// calculate process time
$limit_msg_exe_time = $limit_img_generate_time + $limit_line_upload_time;
$limit_process_time = $limit_msg_exe_time * $limit_send_messages;

// set time limit
set_time_limit($limit_process_time);


require_once 'includes/config.php';
require_once 'classes/DbConnect.php';
require_once 'classes/LineMessage.php';
require_once 'classes/TextToImage.php';


// create database object
$db = new DbConnect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->show_errors();
$db->query("SET NAMES utf8");
		
// create line object
$line = new LineMessage($db);
$line->setLimitSendMessages($limit_send_messages);		// limit number of messages to send
$line->setLimitUploadTime($limit_line_upload_time);		// limit line upload time

// add new messages
$sql1 = "SELECT 
	active_alarm.*,
	
	'การแจ้งเตือน','\n','http://www.see-oilweb.com/testt000/' AS Title,
    
	IF(concat(Alarm_Warning_Category, Alarm_Type)='193', 
		concat('การแจ้งเตือน :','\n', site.name,'\nE1\n',Alarm_Type.description,'\n', Alarm_Type.th_description), 
	IF (concat(Alarm_Warning_Category, Alarm_Type) = '210',
		concat('การแจ้งเตือน ', site.name, Alarm_Warning_Category.description,Alarm_Type.description),
        
    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('211', '212','202','203','204','207'), 
		concat('การแจ้งเตือน :','\n', site.name,'\n','ถัง ', tank.number, '   ', tank.name, '\n', Alarm_Type.description, '\n', Alarm_Type.th_description, '\n','น้ำมันคงเหลือ : ', 
			(SELECT FORMAT(volume,2) FROM inventory WHERE site_id=site.ID AND tank_product=tank.number ORDER BY timestamp DESC LIMIT 1),' ลิตร','\n',
            'น้ำมันที่ลงได้ : ',
            (SELECT FORMAT(ullage,2) FROM inventory WHERE site_id=site.ID AND tank_product=tank.number ORDER BY timestamp DESC LIMIT 1),' ลิตร'),
			    
	concat('การแจ้งเตือน :','\n', site.name,'\n','ถัง  ', tank.number, '   ', tank.name, '\n', Alarm_Type.description, '\n', Alarm_Type.th_description)
    
   ))) AS Message,
		
	site.user_id
FROM active_alarm
	INNER JOIN site ON site.ID = active_alarm.site_id
	INNER JOIN user_information ON user_information.user_id = site.user_id
	
	INNER JOIN tank ON tank.site_id = active_alarm.site_id AND tank.number = active_alarm.Tank_Number
	INNER JOIN alarm_warning_category ON alarm_warning_category.code = active_alarm.Alarm_Warning_Category
	INNER JOIN alarm_type ON alarm_type.code = concat(Alarm_Warning_Category, Alarm_Type)
	LEFT JOIN line_messages ON line_messages.row_id = active_alarm.ID AND line_messages.type = 'alarm'
WHERE line_access_token IS NOT NULL AND line_messages.ID IS NULL
ORDER BY active_alarm.Date_Time ASC";

$sql2 = "SELECT 
	t1.ID,
	tank_product,
	Starting_date_time,
	Amount,
	t1.Timestamp,
	'รายงานการรับน้ำมัน','\n','http://www.see-oilweb.com/tested/' AS Title,
	concat('รายงานการรับน้ำมัน   ','\n', site.name, '\n',
		'ถัง',' ', t1.tank_product,' ' ,tank_name ,'\n',
		'วัน-เวลา-เริ่มลง : ',t1.Starting_date_time,'\n',
		'น้ำมันก่อนลง :',' ',format(t1.Starting_volume,2),' ลิตร','\n',
		'วัน-เวลา-หลังลง :',' ',t1.End_date_time,'\n',
		'น้ำมันหลังลง :',' ',format(t1.Ending_volume,2),' ลิตร','\n',
		'ยอดรับน้ำมัน : ', format(t1.Amount,2),' ลิตร') as Message,
	site.user_id
FROM delivery_record as t1
	INNER JOIN (
		SELECT site.ID, site.name, inv.tank, inv.tank_name, inv.time
		FROM site
		INNER JOIN (
			SELECT delivery_record.site_id, tank_product AS tank, tank.name AS tank_name, MAX(timestamp) AS time
			FROM delivery_record
			INNER JOIN tank ON delivery_record.site_id = tank.site_id AND delivery_record.tank_product = tank.number
			GROUP BY site_id, tank_product
		) AS inv
	) AS t2 ON t2.ID = t1.site_id AND t2.tank = t1.tank_product AND t2.time = t1.timestamp
	INNER JOIN site ON site.ID = t1.site_id
	INNER JOIN user_information ON user_information.user_id = site.user_id
	LEFT JOIN line_messages ON line_messages.row_id = t1.ID AND line_messages.type = 'delivery'
WHERE line_access_token IS NOT NULL AND line_messages.ID IS NULL
ORDER BY site_id, tank_product";


if (isset($_POST["oil_text"])){

	$oil_inventory = $_POST["oil_text"];	

	if ($oil_inventory == "shift_inventory") {

$sql3 = "SELECT 
	MIN(ID) AS ID,
	user_id, 
    current_date(),
    current_time(),
    concat('\n','รายงานน้ำมันคงเหลือ ','\n','วันที่ : เวลา  ', current_date(),' ',current_time(),'\n','สถานี : ',t3.name,'\n','http://www.see-oilweb.com/inventory-report/')  AS Title,
	GROUP_CONCAT(Message ORDER BY site_id, tank_product SEPARATOR '\n') AS Message
FROM (

	SELECT 
		t1.ID,
        t1.site_id,
		t1.tank_product,
        site.user_id,
        site.name,		
        CONCAT('ถัง',' ', t1.tank_product,' ' ,tank_name ,'\n',
			'คงเหลือ :',' ',format(t1.volume,2),' ลิตร',' ', 'ลงเพิ่มได้ :',' ',format(t1.ullage,2),' ลิตร') as Message
	FROM inventory as t1
		INNER JOIN (
			SELECT site.ID, site.name, inv.tank, inv.tank_name, inv.time
			FROM site
			INNER JOIN (
				SELECT inventory.site_id, tank_product AS tank, tank.name AS tank_name, MAX(timestamp) AS time
				FROM inventory
				INNER JOIN tank ON inventory.site_id = tank.site_id AND inventory.tank_product = tank.number
				GROUP BY site_id, tank_product
			) AS inv
		) AS t2 ON t2.ID = t1.site_id AND t2.tank = t1.tank_product AND t2.time = t1.timestamp
		INNER JOIN site ON site.ID = t1.site_id 
		INNER JOIN user_information ON user_information.user_id = site.user_id
	WHERE line_access_token IS NOT NULL
	ORDER BY site_id, tank_product
    
) AS t3
GROUP BY user_id
ORDER BY user_id";

insertLineMessages ($sql3, "inventory");
}
}

insertLineMessages($sql1, "alarm");
insertLineMessages($sql2, "delivery");


// send all messages
$line->processQueue();

// display results
$result = array();
$result["limit_time"] = $limit_process_time;
$result += $line->getLog();
echo json_encode($result);

function insertLineMessages($sql, $type) {
	global $db, $line;
	if ($result = $db->query($sql)) {
		if ($result->num_rows) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$line->newMessage($row['ID'], $type, $row['user_id'], $row['Title'], $row['Message']);
			}
		}
	}
}
	
?>