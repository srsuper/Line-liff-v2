<?php

class LineMessage {
	
	private $db;
	private $log;
	private $limit_send_messages = 100;
	private $limit_upload_time = 30;
	
	function __construct($db) {
		$this->db = $db;
		$this->log = new LineLog();
		$this->_verifyActiveAlarmStatus();
	}

	function setLimitSendMessages($count) {
		$this->limit_send_messages = $count;
	}

	function setLimitUploadTime($time) {
		$this->limit_upload_time = $time;
	}
	
	function newMessage($rowId, $type, $toUserId, $title, $message, $delivery=NULL) {
		$when = (!empty($delivery)) ? "'$delivery'" : 'NOW()';
		$sql = "INSERT INTO line_messages
				SELECT * FROM ( SELECT
					NULL AS Column1,
					$rowId AS Column2,
					'$type' AS Column3,
					$toUserId AS Column4,
					'$title' AS Column5,
					'$message' AS Column6,
					'queued' AS Column7,
					$when AS Column8,
					NOW() AS Column9,
					NOW() AS Column10
				) AS tmp
				WHERE NOT EXISTS (
					SELECT message FROM line_messages WHERE row_id=$rowId AND type='$type' AND to_user_id=$toUserId
				) LIMIT 1";
				
		$this->db->query($sql);
	}
	
	/**
	 Cancel line message if active_alarm_id is not exist in active_alarm
	 */
	private function _verifyActiveAlarmStatus() {
		$sql1 = "UPDATE line_messages
				LEFT JOIN active_alarm ON active_alarm.ID = line_messages.row_id
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND (type='alarm') AND (active_alarm.ID IS NULL)";

		$sql2 = "UPDATE line_messages
				LEFT JOIN delivery_record ON delivery_record.ID = line_messages.row_id
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND (type='delivery') AND (delivery_record.ID IS NULL)";
		$sql3 = "UPDATE line_messages
				LEFT JOIN inventory ON inventory.ID = line_messages.row_id
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND (type='inventory') AND (inventory.ID IS NULL)";
		$sql4 = "UPDATE line_messages
				LEFT JOIN dailyreport ON dailyreport.ID = line_messages.row_id
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND (type='dailyreport') AND (dailyreport.ID IS NULL)";
		$sql5 = "UPDATE line_messages
				LEFT JOIN shift_time_report ON shift_time_report.ID = line_messages.row_id
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND (type='shift_report') AND (shift_time_report.ID IS NULL)";


		$this->db->query($sql1);
		$this->db->query($sql2);
		$this->db->query($sql3);
		$this->db->query($sql4);
		$this->db->query($sql5);
	}
	
	private function _fetchMessages() {
		$sql = "SELECT 
					line_messages.*,
					user_information.line_access_token
				FROM line_messages
				INNER JOIN user_information ON user_information.user_id = line_messages.to_user_id
				WHERE status IN ('queued', 'failed') AND delivery <= NOW()
				ORDER BY line_messages.created ASC LIMIT $this->limit_send_messages;";
				
		$this->_iterateMessages($sql);
	}
	
	private function _iterateMessages($sql) {
		if ($result = $this->db->query($sql)) {
			if ($result->num_rows) {
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$id = $row['ID'];
					$title = $row['title'];
					$message = $row['message'];
					$token = $row['line_access_token'];
					
					$startTime = microtime(true);
					$this->_sendImage($id, $title, $message, $token);
					$endTime = microtime(true);
					
					// log execute time
					$exectionTime = $endTime - $startTime;
					$this->log->setExecutionTime($id, round($exectionTime, 2));
				}
			}
		}
	}
	
	private function _sendMessage($id, $message, $token) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://notify-api.line.me/api/notify",
			CURLOPT_TIMEOUT => $this->limit_upload_time,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_SSL_VERIFYHOST => false,
		  	CURLOPT_SSL_VERIFYPEER => false,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_POSTFIELDS => "message=" . $message,
		  	CURLOPT_HTTPHEADER => array(
		    	"authorization: Bearer " . $token,
				"content-type: application/x-www-form-urlencoded"
			)
		));
		
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if (!$err) {
			$json = json_decode($result, true);
			$status = $json['status'];
			$message = $json['message'];
			
			if ($status == 200) {
				$this->_sendSuccess($id);
			} else {
				$this->_sendFailed($id);
			}
			
			// log status
			$this->log->setStatus($id, $status);
			$this->log->setMessage($id, $message);
			
		} else {
			
			$this->_sendFailed($id);
			
			// log status
			$this->log->setStatus($id, $info['http_code']);
			$this->log->setMessage($id, $err);
		}
	}

	private function _sendImage($id, $title, $message, $token) {
		
		$imageName = $this->_randomString(50);
		$file = "upload/$imageName.jpg";
		$fontSize = 20;
		
		$img = new TextToImage();
		$img->createLineImage($message, $fontSize);
		$img->saveAsJpg($imageName, 'upload/');
		$imageFile = new CurlFile(realpath($file), 'image/jpg');
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://notify-api.line.me/api/notify",
			CURLOPT_TIMEOUT => $this->limit_upload_time,  
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_SSL_VERIFYHOST => false,
		  	CURLOPT_SSL_VERIFYPEER => false,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_POSTFIELDS => array("message" => $title, "imageFile" => $imageFile),
		  	CURLOPT_HTTPHEADER => array(
		    	"authorization: Bearer " . $token,
				"content-type: multipart/form-data"
			)
		));
		
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		// delete uploaded file
		if (file_exists($file)) {
        	unlink($file);
        }
		
		if (!$err) {
			$json = json_decode($result, true);
			$status = $json['status'];
			$message = $json['message'];
			
			if ($status == 200) {
				$this->_sendSuccess($id);
			} else {
				$this->_sendFailed($id);
			}
			
			// log status
			$this->log->setStatus($id, $status);
			$this->log->setMessage($id, $message);
			
		} else {
			
			$this->_sendFailed($id);
			
			// log status
			$this->log->setStatus($id, $info['http_code']);
			$this->log->setMessage($id, $err);
		}
	}
	
	private function _randomString($length) {
    	$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));

		for ($i = 0; $i < $length; $i++) {
        	$key .= $keys[array_rand($keys)];
    	}

		return $key;
	}
	
	private function _sendSuccess($id) {	
		$sql = "UPDATE line_messages SET status='delivered' WHERE ID=$id";
		$this->db->query($sql);
	}
	
	private function _sendFailed($id) {
		$sql = "UPDATE line_messages SET status='failed' WHERE ID=$id";
		$this->db->query($sql);
	}
	
	function processQueue() {
		$this->_fetchMessages();
	}
	
	function getLog() {
		return $this->log->getLog();
	}
}

class LineLog {
	
	private $log;
	
	function __construct() {
		$log = array();
	}
	
	private function _result($id) {
		$result = $this->log[$id];
		if ($result == null) {
			$result = array();
		}
		return $result;
	}
	
	function setStatus($id, $code) {
		$result = $this->_result($id);
		$result['status'] = $code;
		$this->log[$id] = $result;
	}
	
	function setMessage($id, $message) {
		$result = $this->_result($id);
		$result['message'] = $message;
		$this->log[$id] = $result;
	}
	
	function setExecutionTime($id, $time) {
		$result = $this->_result($id);
		$result['execution_time'] = $time;
		$this->log[$id] = $result;
	}
	
	function getStatus($id) {
		$result = $this->_result($id);
		return $result[$id];
	}
	
	function getLog() {
		$results = array();
		$processTime = 0;
		$keys = array();

		foreach ($this->log as $key => $value) {
			$keys[] = $key;
		}

		asort($keys);

		foreach ($keys as $key) {
			$value = $this->log[$key];
			$processTime += $value['execution_time'];

			$result = array();
			$result['id'] = $key;
			$result['status'] = $value['status'];
			$result['message'] = $value['message'];
			$result['execution_time'] = $value['execution_time'];
			$results[] = $result;
		}

		return array('process_time' => round($processTime, 2), 'results' => $results);
	}
}
	
?>