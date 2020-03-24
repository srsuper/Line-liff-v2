<?php

class OilDataConverter {
		public static function convertToShiftreportArray($text) {
		//
		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$check_sum = substr($text, -6);
		$all_code = substr($text, 16, strlen($text) - 22);
		//echo "$all_code";
		$array = array();


		while (strlen($all_code) >= 111) {
			$code = substr($all_code, 0, 111);
			$all_code = substr($all_code, 111);
			//echo "code : $code";


			$tank_number = substr($code, 0, 2);
			$product_code = substr($code, 2, 1);
			$ss = substr($code, 3, 2);
			$nn = substr($code, 5, 2);
			$start_volume_hex = substr($code, 7, 8);
			$start_ullage_hex = substr($code, 15, 8);
			$start_tc_volume_hex = substr($code, 23, 8);
			$start_height_hex = substr($code, 31, 8);
			$start_water_hex = substr($code, 39, 8);
			$start_temperature_hex = substr($code, 47, 8);
			$end_volume_hex = substr($code, 55, 8);
			$end_ullage_hex = substr($code, 63, 8);
			$end_tc_volume_hex = substr($code, 71, 8);
			$end_height_hex = substr($code, 79, 8);
			$end_water_hex = substr($code, 87, 8);
			$end_temperature_hex = substr($code, 95, 8);
			$total_value_hex = substr($code, 103, 8);

			//echo "Tank_number: $tank_number \n";
			//echo "opening_DT: $opening_DT \n";
			//echo "closing_DT: $closing_DT\n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "variance: $variance_hex \n";
			//echo "ss : $ss";

			// Create data
			
			$data = new ShiftreportData();
			$data->date_time = $date_time;
			$data->tank_number = $tank_number;
			$data->shift_time = $ss;
			$data->start_volume = self::convertHexToFloat($start_volume_hex);
			$data->start_ullage = self::convertHexToFloat($start_ullage_hex);
			$data->start_tc_volume = self::convertHexToFloat($start_tc_volume_hex);
			$data->start_height = self::convertHexToFloat($start_height_hex);
			$data->start_water = self::convertHexToFloat($start_water_hex);
			$data->start_temperature = self::convertHexToFloat($start_temperature_hex);
			$data->end_volume = self::convertHexToFloat($end_volume_hex);
			$data->end_ullage = self::convertHexToFloat($end_ullage_hex);
			$data->end_tc_volume = self::convertHexToFloat($end_tc_volume_hex);
			$data->end_height = self::convertHexToFloat($end_height_hex);
			$data->end_water = self::convertHexToFloat($end_water_hex);
			$data->end_temperature = self::convertHexToFloat($end_temperature_hex);
			$data->total_value = self::convertHexToFloat($total_value_hex);

			//echo "start_volume: $start_volume_hex \n";
			//echo "ss : $shift_time";
			$array[] = $data;
		}
		
		return $array;

	}

	public static function convertToDailyreportArray($text) {
		//
		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 8);
		$tank_number = substr($text, 16,2);
		$check_sum = substr($text, -4);
		$all_code = substr($text, 24, strlen($text) - 30);

		$array = array();

		while (strlen($all_code) >= 86) {
			$code = substr($all_code, 0, 86);
			$all_code = substr($all_code, 86);


			$opening_DT = substr($code, 0, 10);
			$closing_DT = substr($code, 10, 10);
			$nn = substr($code, 20, 2);
			$opening_Volume_hex = substr($code, 22, 8);
			$delivery_hex = substr($code, 30, 8);
			$selling_hex = substr($code, 38, 8);
			$manual_hex = substr($code, 46, 8);
			$calulated_Volume_hex = substr($code, 54, 8);
			$closing_Volume_hex = substr($code, 62, 8);
			$water_HT_hex = substr($code, 70, 8);
			$variance_hex = substr($code, 78, 8);

			//echo "Tank_number: $tank_number \n";
			//echo "opening_DT: $opening_DT \n";
			//echo "closing_DT: $closing_DT\n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "variance: $variance_hex \n";

			// Create data
			
			$data = new DailyreportData();
			$data->tank_number = $tank_number;
			$data->opening_DT = self::convertStrToMySQLDateTimeStr($opening_DT);
			$data->closing_DT = self::convertStrToMySQLDateTimeStr($closing_DT);
			$data->opening_Volume = self::convertHexToFloat($opening_Volume_hex);
			$data->delivery = self::convertHexToFloat($delivery_hex);
			$data->selling = self::convertHexToFloat($selling_hex);
			$data->manual = self::convertHexToFloat($manual_hex);
			$data->calulated_volume = self::convertHexToFloat($calulated_Volume_hex);
			$data->closing_Volume = self::convertHexToFloat($closing_Volume_hex);
			$data->water_HT = self::convertHexToFloat($water_HT_hex);
			$data->variance = self::convertHexToFloat($variance_hex);

			//echo "opening_Volume: $opening_Volume_hex \n";
			$array[] = $data;
		}
		
		return $array;

    }

	public static function convertToMonthlyreportArray($text) {
		//
		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$total_tank = substr($text, 10,2); // GG
		$check_sum = substr($text, -4);
		$all_code = substr($text, 18, strlen($text) - 22);
		//echo "$all_code";

		$array = array();

		while (strlen($all_code) >= 92) {
			$code = substr($all_code, 0, 92);
			$all_code = substr($all_code, 92);

			$tank_number = substr($code, 0, 2); // PP
			$tank_number_map = substr($code, 2, 2); // NN
			$tank_number_map_1 = substr($code, 4, 2); // TT
			$opening_DT = substr($code, 6, 10); // Opening DT
			$closing_DT = substr($code, 16, 10); // Closing DT
			$nn = substr($code, 26, 2);
			$opening_Volume_hex = substr($code, 28, 8); // Opening_Volume
			$delivery_hex = substr($code, 36, 8); // delivery totoal
			$selling_hex = substr($code, 44, 8); // Selling total
			$manual_hex = substr($code, 52, 8); // manual entered
			$calulated_Volume_hex = substr($code, 60, 8); // calculated 
			$closing_Volume_hex = substr($code, 68, 8); // Closing Volume
			$water_HT_hex = substr($code, 76, 8);
			$variance_hex = substr($code, 84, 8);

			//echo "Tank_number: $tank_number \n";
			//echo "opening_DT: $opening_DT \n";
			//echo "closing_DT: $closing_DT\n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "variance: $variance_hex \n";

			// Create data
			
			$data = new MonthlyreportData();
			$data->tank_number = $tank_number;
			$data->opening_DT = self::convertStrToMySQLDateTimeStr($opening_DT);
			$data->closing_DT = self::convertStrToMySQLDateTimeStr($closing_DT);
			$data->opening_Volume = self::convertHexToFloat($opening_Volume_hex);
			$data->delivery = self::convertHexToFloat($delivery_hex);
			$data->selling = self::convertHexToFloat($selling_hex);
			$data->manual = self::convertHexToFloat($manual_hex);
			$data->calulated_volume = self::convertHexToFloat($calulated_Volume_hex);
			$data->closing_Volume = self::convertHexToFloat($closing_Volume_hex);
			$data->water_HT = self::convertHexToFloat($water_HT_hex);
			$data->variance = self::convertHexToFloat($variance_hex);

			//echo "opening_Volume: $opening_Volume_hex \n";
			$array[] = $data;
		}
		
		return $array;


	}
	
	public static function convertToInventoryDataArray($text) {

		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
	
		$check_sum = substr($text, -4);
		$all_code = substr($text, 16, strlen($text) - 22);

		$array = array();

		while (strlen($all_code) >= 65) {
			$code = substr($all_code, 0, 65);
			$all_code = substr($all_code, 65);


			$tank_product = substr($code, 0, 2);
			$product_code = substr($code, 2, 1);
			$tank_status = substr($code, 6, 1); //ADD
			$nn = substr($code, 7, 2);
			$volume_hex = substr($code, 9, 8);
			$tc_volume_hex = substr($code, 17, 8);
			$ultrage_hex = substr($code, 25, 8);
			$height_hex = substr($code, 33, 8);
			$water_hex = substr($code, 41, 8);
			$temp_hex = substr($code, 49, 8);
			$water_volume_hex = substr($code, 57, 8);

			//echo "Tank_product: $tank_product \n";
			//echo "product_code: $product_code \n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "volume_hex: $volume_hex \n";
			
			
			// Create data
			$data = new InventoryData();
			$data->tank_product = $tank_product;
			$data->tank_status = $tank_status; //ADD
			$data->volume = self::convertHexToFloat($volume_hex);
			$data->tc_volume = self::convertHexToFloat($tc_volume_hex);
			$data->ullage = self::convertHexToFloat($ultrage_hex);
			$data->height = self::convertHexToFloat($height_hex);
			$data->water = self::convertHexToFloat($water_hex);
			$data->temp = self::convertHexToFloat($temp_hex);
			$data->water_volume = self::convertHexToFloat($water_volume_hex);

			$array[] = $data;
		}
		
		return $array;
	}

	public static function convertToAdjustedDeliveryreportArray($text) {

		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$tank_number = substr($text, 16, 2); 				// TT
		$number_delivery = substr($text, 18, 2);
		$check_sum = substr($text, -4);
		$all_code = substr($text, 20, strlen($text) - 28);
		
		$array = array();

		while (strlen($all_code) >= 190) {
			$code = substr($all_code, 0, 190);
			$all_code = substr($all_code, 190);
			

			$starting_date_time = substr($code, 0, 10);   		// YYMMDDHHmm
			$ending_date_time = substr($code, 10, 10);    			// YYMMDDHHmm
			$nn = substr($code, 20, 2);     					// Number of Eight
			$starting_volume_hex = substr($code, 22, 8);
			$ending_volume_hex = substr($code, 30, 8);
			$adjusted_delivery_volume_hex = substr($code, 38, 8);
			$adjusted_temperature_hex = substr($code, 46, 8);
			$starting_height_hex = substr($code, 54, 8);
			$starting_temp1_hex = substr($code, 62, 8);
			$starting_temp2_hex = substr($code, 70, 8);
			$starting_temp3_hex = substr($code, 78, 8);
			$starting_temp4_hex = substr($code, 86, 8);
			$starting_temp5_hex = substr($code, 94, 8);
			$starting_temp6_hex = substr($code, 102, 8);
			$ending_height_hex = substr($code, 110, 8);
			$ending_temp1_hex = substr($code, 118, 8);
			$ending_temp2_hex = substr($code, 126, 8);
			$ending_temp3_hex = substr($code, 134, 8);
			$ending_temp4_hex = substr($code, 142, 8);
			$ending_temp5_hex = substr($code, 150, 8);
			$ending_temp6_hex = substr($code, 158, 8);
			$total_seling_hex = substr($code, 166, 8);
			$starting_temp_average_hex = substr($code, 174, 8);
			$ending_temp_average_hex = substr($code, 182, 8);
	
			
			$data = new AdjustedDeliveryData();
			$data->tank_number = $tank_number;
			$data->starting_date_time  = self::convertStrToMySQLDateTimeStr($starting_date_time);
			$data->ending_date_time  =  self::convertStrToMySQLDateTimeStr($ending_date_time);		
			$data->starting_volume =  self::convertHexToFloat($starting_volume_hex); 
			$data->ending_volume =  self::convertHexToFloat($ending_volume_hex); 					
			$data->adjusted_delivery_volume = self::convertHexToFloat($adjusted_delivery_volume_hex);
			$data->adjusted_temperature = self::convertHexToFloat($adjusted_temperature_hex);
			$data->starting_height = self::convertHexToFloat($starting_height_hex);
			$data->starting_temp1 = self::convertHexToFloat($starting_temp1_hex);
			$data->starting_temp2 = self::convertHexToFloat($starting_temp2_hex);
			$data->starting_temp3 = self::convertHexToFloat($starting_temp3_hex);
			$data->starting_temp4 = self::convertHexToFloat($starting_temp4_hex);
			$data->starting_temp5 = self::convertHexToFloat($starting_temp5_hex);
			$data->starting_temp6 = self::convertHexToFloat($starting_temp6_hex);
			$data->ending_height = self::convertHexToFloat($ending_height_hex);
			$data->ending_temp1 = self::convertHexToFloat($ending_temp1_hex);
			$data->ending_temp2 = self::convertHexToFloat($ending_temp2_hex);
			$data->ending_temp3 = self::convertHexToFloat($ending_temp3_hex);
			$data->ending_temp4 = self::convertHexToFloat($ending_temp4_hex);
			$data->ending_temp5 = self::convertHexToFloat($ending_temp5_hex);
			$data->ending_temp6 = self::convertHexToFloat($ending_temp6_hex);
			$data->total_seling = self::convertHexToFloat($total_seling_hex);
			$data->starting_temp_average = self::convertHexToFloat($starting_temp_average_hex);
			$data->ending_temp_average = self::convertHexToFloat($ending_temp_average_hex);

			$array[] = $data;
			//echo "$data->starting_volume \n";
		}
		
		return $array;

	}
	
	public static function convertToDeliveryDataArray($text) {

		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$check_sum = substr($text, -4);
		$all_code = substr($text, 16, strlen($text) - 22);

		$array = array();

		while (strlen($all_code) >= 107) {
			$code = substr($all_code, 0, 107);
			$all_code = substr($all_code, 107);
		
			$tank_number = substr($code, 0, 2); 				// TT
			$product_code = substr($code, 2, 1);
			$number_delivery = substr($code, 3, 2);			// DD Number of delivery
			$starting_date_time = substr($code, 5, 10);   		// YYMMDDHHmm
			$end_date_time = substr($code, 15, 10);    			// YYMMDDHHmm
			$nn = substr($code, 25, 1);     					// Number of Eight
			$starting_volume_hex = substr($code, 27, 8);
			$starting_tc_volume_hex = substr($code, 35, 8);
			$starting_water_hex = substr($code, 43, 8);
			$starting_temp_hex = substr($code, 51, 8);
			$ending_volume_hex = substr($code, 59, 8);
			$ending_tc_volume_hex = substr($code, 67, 8);
			$ending_water_hex = substr($code, 75, 8);
			$ending_temp_hex = substr($code, 83, 8);
			$starting_height_hex = substr($code, 91, 8);
			$ending_height_hex = substr($code, 99, 8);
			//echo "Tank_product: $tank_product \n";
			//echo "product_code: $product_code \n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "starting_volume_hex: $starting_volume_hex \n";
		
		// Create data
			$data = new DeliveryData();
			$data->tank_product = $tank_number;
			$data->starting_date_time = self::convertStrToMySQLDateTimeStr($starting_date_time);		// not sure need to more for date format
			$data->end_date_time = self::convertStrToMySQLDateTimeStr($end_date_time); 					// not sure need to more for date format
			$data->starting_volume = self::convertHexToFloat($starting_volume_hex);
			$data->starting_tc_volume = self::convertHexToFloat($starting_tc_volume_hex);
			$data->starting_water = self::convertHexToFloat($starting_water_hex);
			$data->starting_temp = self::convertHexToFloat($starting_temp_hex);
			$data->ending_volume = self::convertHexToFloat($ending_volume_hex);
			$data->ending_tc_volume = self::convertHexToFloat($ending_tc_volume_hex);
			$data->ending_water = self::convertHexToFloat($ending_water_hex);
			$data->ending_temp = self::convertHexToFloat($ending_temp_hex);
			$data->starting_height = self::convertHexToFloat($starting_height_hex);
			$data->ending_height = self::convertHexToFloat($ending_height_hex);
			$data->amount = $data->ending_volume - $data->starting_volume; 

			//echo "starting_volume : $starting_volume \n";

			$array[] = $data;
		}
		
		return $array;
	}

	public static function convertToDeliveryDataArray_2($text) {
		//use for version lower 15.
		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$tank_number = substr($text, 16,2);
		$check_sum = substr($text, -4);
		$all_code = substr($text, 21, strlen($text) - 27);
		//echo "$all_code";

		$array = array();

		while (strlen($all_code) >= 102) {
			$code = substr($all_code, 0, 102);
			$all_code = substr($all_code, 102);
		
			
			$starting_date_time = substr($code, 0, 10);   		// YYMMDDHHmm
			$end_date_time = substr($code, 10, 10);    			// YYMMDDHHmm
			$nn = substr($code, 20, 1);     					// Number of Eight
			$starting_volume_hex = substr($code, 22, 8);
			$starting_tc_volume_hex = substr($code, 30, 8);
			$starting_water_hex = substr($code, 38, 8);
			$starting_temp_hex = substr($code, 46, 8);
			$ending_volume_hex = substr($code, 54, 8);
			$ending_tc_volume_hex = substr($code, 62, 8);
			$ending_water_hex = substr($code, 70, 8);
			$ending_temp_hex = substr($code, 78, 8);
			$starting_height_hex = substr($code, 86, 8);
			$ending_height_hex = substr($code, 94, 8);
			//echo "starting_date_time: $starting_date_time \n";
			//echo "product_code: $product_code \n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "starting_volume_hex: $starting_volume_hex \n";
		
		// Create data
			$data = new DeliveryData();
			$data->tank_product = $tank_number;
			$data->starting_date_time = self::convertStrToMySQLDateTimeStr($starting_date_time);		// not sure need to more for date format
			$data->end_date_time = self::convertStrToMySQLDateTimeStr($end_date_time); 					// not sure need to more for date format
			$data->starting_volume = self::convertHexToFloat($starting_volume_hex);
			$data->starting_tc_volume = self::convertHexToFloat($starting_tc_volume_hex);
			$data->starting_water = self::convertHexToFloat($starting_water_hex);
			$data->starting_temp = self::convertHexToFloat($starting_temp_hex);
			$data->ending_volume = self::convertHexToFloat($ending_volume_hex);
			$data->ending_tc_volume = self::convertHexToFloat($ending_tc_volume_hex);
			$data->ending_water = self::convertHexToFloat($ending_water_hex);
			$data->ending_temp = self::convertHexToFloat($ending_temp_hex);
			$data->starting_height = self::convertHexToFloat($starting_height_hex);
			$data->ending_height = self::convertHexToFloat($ending_height_hex);
			$data->amount = $data->ending_volume - $data->starting_volume; 

			//echo "starting_volume : $starting_volume \n";

			$array[] = $data;
		}
		
		return $array;

	}

	public static function convertToMax_or_lable_DataArray($text) {
		//use for version lower 15.
		$command_code = substr($text, 0, 6);
		$date_time = substr($text, 6, 10);
		$tank_number = substr($text, 16,2);
		$check_sum = substr($text, -4);
		$all_code = substr($text, 18, strlen($text) - 24);
		//echo "$all_code";

		$array = array();

		while (strlen($all_code) >= 8) {
			$code = substr($all_code, 0, 8);
			$all_code = substr($all_code, 8);
		
			
			
			$max_or_lable_hex = substr($code, 0, 8);
			
			//echo "starting_date_time: $starting_date_time \n";
			//echo "product_code: $product_code \n";
			//echo "tank_status: $tank_status \n";
			//echo "nn: $nn \n";
			//echo "starting_volume_hex: $starting_volume_hex \n";
		
		// Create data
			$data = new Max_or_lable_Data();
			$data->tank_number = $tank_number;
			
			$data->max_or_lable = self::convertHexToFloat($max_or_lable_hex);
			

			//echo "max_or_lable : $max_or_lable\n";

			$array[] = $data;
		}
		
		return $array;

	}
	
	public static function convertToActiveAlarmDataArray($text) {
		
		// Split text
		$command_code = substr($text, 0, 6); 				// command code
		$date_time = self::convertStrToMySQLDateTimeStr(substr($text, 6, 10));					// YYMMDDHHmm
		$check_sum = substr($text, -4);
		$all_alarm = substr($text, 16, strlen($text) - 22);
		
		// Create data array
		$array = array();
		
		if ($all_alarm == "00") { // No alarm
			$data = new ActiveAlarmData();
			$data->date_time = $date_time;
			$data->alarm_warning_category = $all_alarm;
			$data->alarm_type = $all_alarm;
			$data->tank_number = $all_alarm;
			$array[] = $data;

		} else {

			while (strlen($all_alarm) >= 6) {
				$alarm = substr($all_alarm, 0, 6);
				$all_alarm = substr($all_alarm, 6);

				$data = new ActiveAlarmData();
				$data->date_time = $date_time;
				$data->alarm_warning_category = substr($alarm, 0, 2);
				$data->alarm_type = substr($alarm, 2, 2);
				$data->tank_number = substr($alarm,4, 2 );
				
				//echo "date_time: $date_time \n";

				$array[] = $data;
			}
		}

		return $array;
	}
	
	public static function convertToHistoryAlarmDataArray($text) {
		
		
		// Split text
		$command_code = substr($text, 0, 6); 				// command code
		$date_time = substr($text, 6, 10);					// YYMMDDHHmm
		$check_sum = substr($text, -4);
		$all_history = substr($text, 16, strlen($text) - 22);
		
		// Create data array
		$array = array();
		
		while (strlen($all_history) >= 20) {
			$history = substr($all_history, 0, 20);
			$all_history = substr($all_history, 20);
			
			$data = new HistoryAlarmData();
			$data->date_time = $date_time;
			$data->alarm_warning_category = substr($history, 0, 2);
			$data->sensor_type = substr($history, 2, 2);
			$data->alarm_type = substr($history, 4, 2);
			$data->tank_number = substr($history, 6, 2);
			$data->alarm_state = substr($history, 8, 2);
			$data->date_time_on_record = substr($history, 10, 10);	// YYMMDDHHmm
			
			$array[] = $data;
		}
		
		return $array;



	}
	
	

	/// Convert YYMMDDHHmm to Y-m-d H:i:s
	public static function convertStrToMySQLDateTimeStr($text) {
		if (strlen($text) != 10) {
			return $text;
		}

		$year = 2000 + (int)substr($text, 0, 2);
		$month = substr($text, 2, 2);
		$day = substr($text, 4, 2);
		$hour = substr($text, 6, 2);
		$minute = substr($text, 8, 2);

		return "$year-$month-$day $hour:$minute:00";
	}
	
	/**
	 * Test with 461C4000 equal 10,000
	 */
	public static function convertHexToFloat($hexstr) {
		if ($hexstr == "00000000") {
			return 0.0;
		}
		
		$binstr = self::convertHexToBin($hexstr);
		
		$S = bindec(substr($binstr, 0, 1));
		$E = bindec(substr($binstr, 1, 8));
		$M = bindec(substr($binstr, 9));
		
		$exp = $E - 127;
		$exponent = pow(2, $exp);
		$mantissa = 1.0 + ($M / 8388608);
		$sign = ($S == 0 ? 1 : -1);
		$decimal =  $sign * $exponent * $mantissa;
		$decimal_value = round($decimal, 4);
		
		return $decimal_value;
	}

	/**
	 * 461C4000h
	 */
	public static function convertHexToBin($hexstr) {
		$hexstr_testable = strtolower($hexstr);
		$hexstr_length = strlen($hexstr);
		$results = "";

		for ($i = 0; $i < $hexstr_length; $i++) {
	        $current_char = $hexstr_testable[$i];
	        
	        switch ($current_char) {
	            case '0':
	                $results .= "0000";
	                break;
	                
	            case '1':
	                $results .= "0001";
	                break;
	                
	            case '2':
	                $results .= "0010";
	                break;
	                
	            case '3':
	                $results .= "0011";
	                break;
	                
	            case '4':
	                $results .= "0100";
	                break;
	                
	            case '5':
	                $results .= "0101";
	                break;
	                
	            case '6':
	                $results .= "0110";
	                break;
	                
	            case '7':
	                $results .= "0111";
	                break;
	                
	            case '8':
	                $results .= "1000";
	                break;
	                
	            case '9':
	                $results .= "1001";
	                break;
	                
	            case 'a':
	                $results .= "1010";
	                break;
	                
	            case 'b':
	                $results .= "1011";
	                break;
	                
	            case 'c':
	                $results .= "1100";
	                break;
	                
	            case 'd':
	                $results .= "1101";
	                break;
	                
	            case 'e':
	                $results .= "1110";
	                break;
	                
	            case 'f':
	                $results .= "1111";
	                break;
	        }
	    }
	    
	    return $results;
	}
}

?>