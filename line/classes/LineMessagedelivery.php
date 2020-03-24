<?php

class LineMessage {
	
	private $db;
	
	function __construct($db) {
		$this->db = $db;
		$this->_verifyDeliveryStatus();
	}
	
	function newMessage($deliveryRecordID, $message, $delivery=NULL) {
		$when = (!empty($delivery)) ? "'$delivery'" : 'NOW()';
		$sql = "INSERT INTO line_messages_delivery
				SELECT * FROM ( SELECT
					NULL AS Column1,
					$deliveryRecordID AS Column2,
					'$message' AS Column3,
					'queued' AS Column4,
					$when AS Column5,
					NOW() AS Column6,
					NOW() AS Column7
				) AS tmp
				WHERE NOT EXISTS (
					SELECT message FROM line_messages_delivery WHERE delivery_record_ID=$deliveryRecordID AND message='$message'
				) LIMIT 1";
				
		$this->db->query($sql);
	}
	
	/**
	 Cancel line message if active_alarm_id is not exist in active_alarm
	 */
	private function _verifyDeliveryStatus() {
		$sql = "UPDATE line_messages_delivery
				LEFT JOIN delivery_record
					ON line_messages_delivery.delivery_record_ID = delivery_record.ID
				SET status = 'cancelled'
				WHERE status IN ('queued', 'failed') AND delivery_record.ID IS NULL;";
		$this->db->query($sql);
	}
	
	private function _fetchMessages() {
		$sql = "SELECT 
					line_messages_delivery.*,
					user_information.line_access_token
					FROM line_messages_delivery
				INNER JOIN delivery_record
					ON delivery_record.ID = line_messages_delivery.delivery_record_ID
				INNER JOIN site
					ON delivery_record.site_id = site.ID
				INNER JOIN user_information
					ON user_information.user_id = site.user_id
				WHERE status IN ('queued', 'failed') AND delivery <= NOW()
				ORDER BY line_messages_delivery.created ASC;";
				
		$this->_iterateMessages($sql);
	}
	
	private function _iterateMessages($sql) {
		if ($result = $this->db->query($sql)) {
			if ($result->num_rows) {
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$id = $row['ID'];
					$message = $row['message'];
					$token = $row['line_access_token'];
					$this->_sendMessage($id, $message, $token);
				}
			}
		}
	}
	
	private function _sendMessage($id, $message, $token) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => "https://notify-api.line.me/api/notify",
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
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if (!$err) {
			$json = json_decode($result, true);
			$status = $json['status'];
			if ($status == 200) {
				$this->_sendSuccess($id);
			} else {
				$this->_sendFailed($id);
			}
		} else {
			echo 'Curl error: ' . $err;
			$this->_sendFailed($id);
		}
	}
	
	private function _sendSuccess($id) {	
		$sql = "UPDATE line_messages_delivery SET status='delivered' WHERE ID=$id";
		$this->db->query($sql);
	}
	
	private function _sendFailed($id) {
		$sql = "UPDATE line_messages_delivery SET status='failed' WHERE ID=$id";
		$this->db->query($sql);
	}
	
	function processQueue() {
		$this->_fetchMessages();
	}
}
	
?>