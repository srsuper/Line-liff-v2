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

<body>
<?php
session_start();
$site_id_from_liff = $_SESSION['type_userid'];
$type_whare = $_SESSION['type_where'];
$site_id_from_liff = $site_id_from_liff;
if ($type_whare == "user_id"){
$type_for_whare = $type_whare;
}
if ($type_whare == "ID"){
    $type_for_whare = $command = 'site_'.strtolower($type_whare);
}


//echo $aa = 'site data from liff'.''.$site_id_from_liff;
//echo $bb = 'type for where '.''.$type_for_whare;
    include 'buttom_head.php';
    include 'connectdb.php';
    
?>

<div = class="inventory">
    
  <div>
    <br>
    <div>
    <h2 align = "center">สถานะการแจ้งเตือนปัจจุบัน</h2>
    <?php 

            

            
            include 'connectdb.php';
            $query1 = "SELECT 
                            site_profile.site_id as site_id,
                            name as site_name,
                            concat ('ประจำวันที่ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Date
                                    FROM site_profile 
                                        INNER JOIN site ON site.ID = site_profile.site_id
                                        WHERE site_profile.$type_for_whare = $site_id_from_liff";

            $result1 = mysqli_query($dbcon,$query1);


        ?>
            <?php 
            while ($row_new = mysqli_fetch_assoc($result1)){
                $_SESSION['site_id'] = $row_new['site_id'];
                ?>

                <div class="thad">
        		<article class="uk-article">
                    
        <div = class="inventory">
            <table>
              <h3> <?php 
                echo $row_new['site_name'];?>
                  
              </h3>

              <tr>
                <th>วันที่แจ้งเตือน</th>
               <th>ข้อความแจ้งเตือน Eng</th>
               <th>ข้อความแจ้งเตือน Th</th>
                
              </tr>
              <?php

            $query2 = "SELECT
				
            site.ID AS user_id,
            
            site.name as site_name,
            
            concat (date_format(active_alarm.Timestamp,'%d/%m/%Y %H:%i')) as Date,
        


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

WHERE  site.ID = ".$_SESSION['site_id']."
ORDER BY active_alarm.Date_Time ASC";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row['Date']; ?></td>
                <td><?php echo $all=$row['tank_detail_1'].' '.$row['alarm_eng']; ?></td>
                <td><?php echo $all1=$row['tank_detail_1'].' '.$row['alarm_TH']; ?></td>
                
              </tr>
                <?php 
                        } 
                
                ?>
              
            </table>
        </div>
    
                       
                </article>
                </div> 
                <?php } ?>
    
    </div>
    

    

    
    
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="liff-starter.js"></script>
</body>