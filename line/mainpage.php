<?php 

session_start();



$site_id_from_liff = $_SESSION['type_userid']; // เช็คว่าข้อมูลว่าให้ส่งเป็น 35 หรือ 18 คือ ส่งเป็นค่า user_id หรือ site_id
$type_for_whare = $_SESSION['type_where']; // เช็คว่า คือ user_id หรืือ site_id
$for_check_bir = $_SESSION['bir_status_check']; // เช็คว่า สถานะคือมี bir หรือไม่

// $_SESSION['type_where'] = "user_id";
// $_SESSION['type_userid'] = "35";
// $_SESSION['bir_status_check'] = "yes";


// $site_id_from_liff = $_SESSION['type_userid']; // เช็คว่าข้อมูลว่าให้ส่งเป็น 35 หรือ 18 คือ ส่งเป็นค่า user_id หรือ site_id
// $type_for_whare = $_SESSION['type_where']; // เช็คว่า คือ user_id หรืือ site_id
// $for_check_bir = $_SESSION['bir_status_check']; // เช็คว่า สถานะคือมี bir หรือไม่




// echo $type_for_whare;
// echo $site_id_from_liff;
// echo $for_check_bir;
//$site_id_from_liff = $site_id_from_liff;
//$type_for_whare = $type_for_whare;

// echo $aa = 'site data from liff'.''.$site_id_from_liff;
// echo $bb = 'type for where '.''.$type_for_whare;

include 'buttom_head.php';
include 'connectdb.php';
include 'config.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeeOil Application</title>
    <link rel="stylesheet" href="style.css">
    <style media="screen">

                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 95%;
                    padding: 5px;
                    border: solid 1px red;
                    box-shadow: 5px 5px rgba(255,0,0,0.5);
                    margin: 10px;
                    box-sizing: border-box;

                }

                td, th {
                    border: 3px solid #dddddd;
                    text-align: center;
                    font-size: 70%;
                    padding: 2px;
                }


                tr:nth-child(even) {
                    background-color: #dddddd;
                }
                h3 {
                text-align:lift;
                padding: 10px;

                }
                #tank_detail{
                    text-align: left;

                }
                #main_selling {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 80%;
                    margin: 0 auto;
                    padding: 5px;
                    border: solid 1px red;
                    box-shadow: 5px 5px rgba(255,0,0,0.5);

                    box-sizing: border-box;

                }

           
</style>
</head>


<?php // Past for Alarm
$servername = "www.see-oilweb.com";
$username = "seeoil";
$password = "25242524";//ไม่มีก็ไม่ต้องใส่
$dbName = "seeoil";
$conn = new mysqli($servername, $username, $password, $dbName);
//ให้อ่านภาษาไทยได้ คอมเม้น devbanban.com 
mysqli_query($conn, "SET NAMES 'utf8' "); 
//ถ้าเชื่อมต่อฐานอข้มูลไม่ได้ให้แจ้งเตือน
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//เอาข้อมูลจากตารางมาแสดง
$query = "SELECT
				
                                    site.ID AS user_id,

                                    site.name as site_name,

                                    concat (date_format(active_alarm.Timestamp,'%d/%m/%y %H:%i')) as Date,



                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0000'), # Dim alarm
                                                    concat('สถานะ ปกติ'),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type)='2108', #plld alarm
                                                    concat('Q ',Tank_Number),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0102','0101','0104'), #plld alarm
                                                    concat('แจ้งเตือนระบบ'),
                                    concat('T',' ',tank_product,' : ' ,tank.name)

                                    ))) AS tank_detail,

                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0000'), # Dim alarm
                                                    concat(''),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type)='2108', #plld alarm
                                                    concat('Q ',Tank_Number),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0102','0101','0104'), #plld alarm
                                                    concat(''),
                                                    concat('T',tank_product,' : ' ,tank.name)

                                    ))) AS tank_detail_1,

                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('1901','1902','1903','1904'), # Dim alarm
                                                    concat('\nE1',space(1),Alarm_Type.description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0000'), # Dim alarm
                                                    concat('All Function Normal '),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type)='2108', #plld alarm
                                                    concat('\nQ',Tank_Number,space(1),Alarm_Type.description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0101','0102','0103','0104','0105','0106','0107','0108','0109','0110','0111','0112'), # Console alarm
                                                    concat(Alarm_Type.description),
                                    IF (concat(Alarm_Warning_Category, Alarm_Type) IN ('0208','0209'),# Probe out , invalite volume
                                                    concat(Alarm_Type.description),
                                    IF (concat(Alarm_Warning_Category, Alarm_Type) IN ('0210','0203'), # Water Alarm
                                                    concat(Alarm_Type.description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0204','0205','0206','0211','0212','24','25'), # In tank movement
                                                    concat(Alarm_Type.description),
                                    concat(Alarm_Type.description)

                                    ))))))) AS alarm_eng,

                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('1901','1902','1903','1904'), # Dim alarm
                                                    concat(Alarm_Type.th_description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0000'), # Dim alarm
                                                    concat('สถานะการแจ้งเตือนกลับสู่สภาวะปกติ  : ','\n','ไม่พบการแจ้งเตือนใดๆ : '),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type)='2108', #plld alarm
                                                    concat('\nQ', Alarm_Type.th_description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0101','0102','0103','0104','0105','0106','0107','0108','0109','0110','0111','0112'), # Console alarm
                                                    concat(Alarm_Type.th_description),
                                    IF (concat(Alarm_Warning_Category, Alarm_Type) IN ('0208','0209'),# Probe out , invalite volume
                                                    concat(Alarm_Type.th_description),
                                    IF (concat(Alarm_Warning_Category, Alarm_Type) IN ('0210','0203'), # Water Alarm
                                                    concat(Alarm_Type.th_description),
                                    IF(concat(Alarm_Warning_Category, Alarm_Type) IN ('0204','0205','0206','0211','0212','24','25'), # In tank movement
                                                    concat(Alarm_Type.th_description),
                                    concat(Alarm_Type.th_description)

                                    ))))))) AS alarm_TH


                                    FROM active_alarm
                                    INNER JOIN site ON site.ID = active_alarm.site_id
                                    INNER JOIN user_information ON user_information.user_id = site.ID
                                    INNER JOIN inventory ON inventory.site_id = active_alarm.site_id and IF(concat(Alarm_Warning_Category, Alarm_Type) = '0000',inventory.tank_product = 1,inventory.tank_product = active_alarm.Tank_Number)
                                    INNER JOIN tank ON tank.site_id = active_alarm.site_id AND IF(concat(Alarm_Warning_Category, Alarm_Type) = '0000',tank.number = 1,tank.number = active_alarm.Tank_Number)
                                    INNER JOIN alarm_warning_category ON alarm_warning_category.code = active_alarm.Alarm_Warning_Category
                                    INNER JOIN alarm_type ON alarm_type.code = concat(Alarm_Warning_Category, Alarm_Type)

                                    WHERE  site.$type_for_whare = $site_id_from_liff
                                    ORDER BY active_alarm.Date_Time ASC";
                                    $result = $conn->query($query);

?>


<?php // Pass for delivery_adj 
$servername = "www.see-oilweb.com";
$username = "seeoil";
$password = "25242524";//ไม่มีก็ไม่ต้องใส่
$dbName = "seeoil";
$conn = new mysqli($servername, $username, $password, $dbName);
//ให้อ่านภาษาไทยได้ คอมเม้น devbanban.com 
mysqli_query($conn, "SET NAMES 'utf8' "); 
//ถ้าเชื่อมต่อฐานอข้มูลไม่ได้ให้แจ้งเตือน
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//เอาข้อมูลจากตารางมาแสดง
$query1 = "SELECT 
site.name as site_name,
starting_date_time,
                        concat('T',tank_number,' ', tank.name) as Tank_detail,
                        starting_volume,
                        date_format(ending_date_time,'%d/%m/%y %H:%i') as ending_date_time,
                        ending_volume,
                        total_seling,
                        adjusted_delivery_volume,
                        timestramp
                        FROM seeoil.adjusteddelivery
                        INNER JOIN site on site.ID = adjusteddelivery.site_id
                        INNER JOIN tank on adjusteddelivery.site_id = tank.site_id AND adjusteddelivery.tank_number = tank.number
                        where site.$type_for_whare = $site_id_from_liff and date(timestramp) = curdate()
                        order by adjusteddelivery.timestramp DESC";
                        $result1 = $conn->query($query1);
?>





<?php
$servername = "www.see-oilweb.com"; // pas for delivery in process
$username = "seeoil";
$password = "25242524";//ไม่มีก็ไม่ต้องใส่
$dbName = "seeoil";
$conn = new mysqli($servername, $username, $password, $dbName);
//ให้อ่านภาษาไทยได้ คอมเม้น devbanban.com 
mysqli_query($conn, "SET NAMES 'utf8' "); 
//ถ้าเชื่อมต่อฐานอข้มูลไม่ได้ให้แจ้งเตือน
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//เอาข้อมูลจากตารางมาแสดง
$query2 = "SELECT
                site.name as site_name,
                concat (date_format(current_timestamp(),'%d/%m/%y %H:%i')) as Date,
                concat('ถัง ',tank_product,':',tank.name) as tank_detail,
                status_delivery,
                if (status_delivery = 1,'อยู่ระหว่างการ  ลงน้ำมัน','-') as status_delivery_process
                    
                        FROM inventory as T1
                                    
                                    INNER JOIN  tank on T1.site_id = tank.site_id and T1.tank_product = tank.number 
                        INNER JOIN site on T1.site_id = site.ID 
                                    INNER JOIN user_information ON user_information.ID = site.ID 
                                    INNER JOIN status_check ON status_check.ID = site.ID
                                    where site.$type_for_whare = $site_id_from_liff  and status_delivery = 1
                                    order  by tank_product";
                        $result2 = $conn->query($query2);
?>

<?php
$servername = "www.see-oilweb.com"; // pass for check water in tank 
$username = "seeoil";
$password = "25242524";//ไม่มีก็ไม่ต้องใส่
$dbName = "seeoil";
$conn = new mysqli($servername, $username, $password, $dbName);
//ให้อ่านภาษาไทยได้ คอมเม้น devbanban.com 
mysqli_query($conn, "SET NAMES 'utf8' "); 
//ถ้าเชื่อมต่อฐานอข้มูลไม่ได้ให้แจ้งเตือน
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//เอาข้อมูลจากตารางมาแสดง
$query3 = "SELECT
                       
                    site.name as site_name,
                    concat ('วันที่ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Date,
                    concat('ถัง ',tank_product,': ',tank.name) as tank_detail,
                    water as water_height,
                    water_volume as water_volume
                            FROM inventory as T1
                                     INNER JOIN  tank on T1.site_id = tank.site_id and T1.tank_product = tank.number 
                            INNER JOIN site on T1.site_id = site.ID 
                                        INNER JOIN user_information ON user_information.ID = site.ID 
                                        INNER JOIN status_check ON status_check.ID = site.ID
                                        where site.$type_for_whare = $site_id_from_liff and water > 0
                                        order  by tank_product";
                        $result3 = $conn->query($query3);
?>

<?php // Pass for delivery
$servername = "www.see-oilweb.com";
$username = "seeoil";
$password = "25242524";//ไม่มีก็ไม่ต้องใส่
$dbName = "seeoil";
$conn = new mysqli($servername, $username, $password, $dbName);
//ให้อ่านภาษาไทยได้ คอมเม้น devbanban.com 
mysqli_query($conn, "SET NAMES 'utf8' "); 
//ถ้าเชื่อมต่อฐานอข้มูลไม่ได้ให้แจ้งเตือน
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//เอาข้อมูลจากตารางมาแสดง
$query4 = "SELECT 
site.name as site_name,
                        Starting_date_time as starting_date_time,
                        concat('T',tank_product,' ', tank.name) as Tank_detail,
                        date_format(End_date_time,'%d/%m/%y %H:%i') as ending_date_time,
                        Amount as adjusted_delivery_volume,
                        Timestamp
                        FROM delivery_record
                        INNER JOIN site on site.ID = delivery_record.site_id
                        INNER JOIN tank on delivery_record.site_id = tank.site_id AND delivery_record.tank_product = tank.number
                        where user_id = $site_id_from_liff and date(Timestamp) = curdate()
                        order by delivery_record.Timestamp DESC";
                        $result4 = $conn->query($query4);
?>

<body>
<div = class="inventory">
  <div class="thad">
        <div = class="inventory">
        <h2 align = "center">รายงานการแจ้งเตือน</H2>
            <table>
              <tr>
                <th>สถานี</th>
               <th>วันที่แจ้งเตือน</th>
                <th>ข้อความแจ้งเตือน Eng</th>
                <th>ข้อความแจ้งเตือน Th</th>
              </tr>
              <?php
              	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row['site_name']; ?></td>
                <td id="tank_detail"><?php echo $row['Date']; ?></td>
                <td id="tank_detail"><?php echo $all=$row['tank_detail_1'].' '.$row['alarm_eng']; ?></td>
                <td id="tank_detail"><?php echo $all1=$row['tank_detail_1'].' '.$row['alarm_TH']; ?></td>
              </tr>
          		<?php 
          				} 
          		
          		?>
            </table>
        </div>
</div>
<br>
<?php 

if ($for_check_bir == "yes"){?>
  <div = class="inventory">  
  <div class="thad">
        <div = class="inventory">
        <h2 align = "center">รายงานรับน้ำมันวันนี้</H2>
            <table>
              <tr>
              <th>สถานี</th>
              <th>ถัง</th>
               <th>วันที่ลงน้ำมัน</th>
                <th>ยอดรับน้ำมัน</th>
                <th>ยอดขายระหว่างลง</th>
              </tr>
              <?php
                while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row1['site_name']; ?></td>
                <td id="Tank_detail"><?php echo $row1['Tank_detail']; ?></td> 
                <td id=><?php echo $row1['ending_date_time']; ?></td>
                <td><?php echo number_format($row1['adjusted_delivery_volume'],0); ?></td>
                <td><?php echo number_format($row1['total_seling'],0); ?></td>
              </tr>
                  <?php 
                   @$total = $total + $row1["adjusted_delivery_volume"];
                   @$i++;
                        } 
                
                ?>
                <tr>
                <td colspan="3" align="right">ยอดลงน้ำมันรวม : </td>
                <td><b></b><?php echo number_format($total); ?></td>
                
                </tr>
            </table>
        </div> 
</div>

<?php }  elseif ($for_check_bir == "no") {?>
  
  <div = class="inventory">  
  <div class="thad">
        <div = class="inventory">
        <h2 align = "center">รายงานรับน้ำมันวันนี้</H2>
            <table>
              <tr>
              <th>สถานี</th>
              <th>ถัง</th>
               <th>วันที่ลงน้ำมัน</th>
                <th>ยอดรับน้ำมัน</th>
                <th>ยอดขายระหว่างลง</th>
              </tr>
              <?php
                while ($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row4['site_name']; ?></td>
                <td id="Tank_detail"><?php echo $row4['Tank_detail']; ?></td> 
                <td id=><?php echo $row4['ending_date_time']; ?></td>
                <td><?php echo number_format($row4['adjusted_delivery_volume'],0); ?></td>
                <td><?php echo "N/A"; ?></td>
              </tr>
                  <?php 
                   @$total = $total + $row4["adjusted_delivery_volume"];
                   @$i++;
                        } 
                
                ?>
                <tr>
                <td colspan="3" align="right">ยอดลงน้ำมันรวม : </td>
                <td><b></b><?php echo number_format($total); ?></td>
                
                </tr>
            </table>
        </div> 
</div>


<?php 

}

?>

<hr>
<div = class="inventory">
  <div class="thad">
        <div = class="inventory">
        <h2 align = "center">รายงานสถานะการลงน้ำมัน</H2>
            <table>
              <tr>
                <th>สถานี</th>
               <th>วันที่และเวลา</th>
                <th>ถังน้ำมัน</th>
                <th>สถานะการลงน้ำมัน</th>
              </tr>
              <?php
              	while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row2['site_name']; ?></td>
                <td id="tank_detail"><?php echo $row2['Date']; ?></td>
                <td id="tank_detail"><?php echo $row2['tank_detail']; ?></td>
                <td><?php echo $row2['status_delivery_process']; ?></td>
              </tr>
          		<?php 
          				} 
          		
          		?>
            </table>
        </div>
</div>
<hr>
<div = class="inventory">
  <div class="thad">
        <div = class="inventory">
        <h2 align = "center">รายงานตรวจสอบสถานะค่า น้ำ ในถัง</H2>
            <table>
              <tr>
                <th>สถานี</th>
               <th>วันที่และเวลา</th>
                <th>ถังน้ำมัน</th>
                <th>ปริมาณ น้ำ (ลิตร)</th>
                <th>ความสูง น้ำ (มิลลิเมตร)</th>
              </tr>
              <?php
              	while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row3['site_name']; ?></td>
                <td id="tank_detail"><?php echo $row3['Date']; ?></td>
                <td id="tank_detail"><?php echo $row3['tank_detail']; ?></td>
                <td><?php echo number_format($row3['water_volume'],2); ?></td>
                <td><?php echo number_format($row3['water_height'],2); ?></td>
              </tr>
          		<?php 
          				} 
          		
          		?>
            </table>
        </div>
</div>
    
</body>