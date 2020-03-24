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
    include 'buttom_head.php';
    include 'connectdb.php';
?>

<div = class="inventory">
    
  <div>
    <br>
    <div>
    <h2 align = "center">สถานะสมาชิก</h2>
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

              
                
               
               
              
               
               
               
               
                
              
              <?php

            $query2 = "SELECT 
            'สถานะสมาชิก' as type_flex,
             T1.ID as number_ID,
            'สถานนะสมาชิก' as Title,
            concat ('ประจำวันที่ ',date_format(current_date(),'%d/%m/%Y ')) as Date,
            T1.ID as user_id,
            T1.name as site_name,
            concat('ตัวแทนขาย คุณ',persanal_sale.name) as sale_detail,
            concat(tank,' ถัง') as total_tank,
            
            
            IF(DATEDIFF(expired_date,current_date()) <= 0,'สถานะ ยกเลิก',concat(DATEDIFF(expired_date,current_date()),' วัน')) remaining_date,
            date_format(activation_date,'%d/%m/%Y ') as start_service,
            date_format(expired_date,'%d/%m/%Y ') as stop_service,
            concat ('จำนวน',tank,' ถังx100 บาท',' (',(tank * 100),' บาท/เดือน', ' , ' ,format(((tank * 100)*12),0),' บาท/ปี)' ) as cost_detail,
            concat('2,000 บาท') as Flied_2_price,
            concat('(รอบบัญชี ',date_format(expired_date - interval 1 year,'%d/%m/%Y '),'- ',date_format(expired_date,'%d/%m/%Y '),')') as period_user,
            groupId as group_ID,
            concat('โทร ',phone) as sale_phone,
            persanal_sale.name as sale_name
             FROM seeoil.site as T1
             INNER JOIN persanal_sale on T1.sale_area = persanal_sale.persanal_code
             where T1.ID = ".$_SESSION['site_id']."";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <th id="tank_detail">วันเปิดใช้บริการ</th>
                <td id="tank_detail"><?php echo $row['start_service']; ?></td>
              </tr> 
              <tr>
                <th id="tank_detail">วันครบกำหนดค่าบริการ</th>
                <td id="tank_detail"><?php echo $row['stop_service']; ?></td>
              </tr>
              <tr>
                <th id="tank_detail">ระยะเวลาคงเหลือ</th>
                <td id="tank_detail"><?php echo $row['remaining_date']; ?></td>
              </tr>
              <tr>
              <th id="tank_detail">จำนวนถังน้ำมัน</th>
                <td id="tank_detail"><?php echo $row['total_tank']; ?></td>
              </tr>
              <tr>
              <th id="tank_detail">รอบค่าบริการ</th>
                <td id="tank_detail"><?php echo $row['period_user']; ?></td>
              </tr>
              <tr>
              <th id="tank_detail">ค่าบริการ</th>
                <td id="tank_detail"><?php echo $row['cost_detail']; ?></td>
              </tr>
              <tr>
              <th id="tank_detail">ตัวแทนขาย</th>
                <td id="tank_detail"><?php echo $row['sale_detail']; ?></td>
              </tr>
              <tr>
              <th id="tank_detail">เบอร์โทร</th>
                <td id="tank_detail"><?php echo $row['sale_phone']; ?></td>
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