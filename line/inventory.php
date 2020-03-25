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
    <h2 align = "center">รายงานคงเหลือรวม แบ่งตามชนิดน้ำมัน</h2>


    <table id = "main_selling"> 
        <tr>   
        <th>ชนิดน้ำมัน</th>
        <th>คงเหลือรวม</th>  
        </tr>
        <?php

            $query2 = "SELECT
            sum(volume) as sum_inventory,
            t2.grade
     FROM inventory AS t1
     INNER JOIN (
       SELECT site.ID, site.user_id, site.sfl_limit,inv.tank, inv.tank_name, inv.time, inv.grade,inv.lable
       FROM site
       INNER JOIN (
         SELECT inventory.site_id,tank_product AS tank, tank.name AS tank_name, MAX(timestamp) AS time , tank.Grade as grade , tank.max_or_lable as lable
         FROM inventory
         INNER JOIN tank
             ON inventory.site_id = tank.site_id AND inventory.tank_product = tank.number
             GROUP BY site_id, tank_product
       ) AS inv
       ON site.ID = inv.site_id
      
     ) AS t2
     ON t1.site_id = t2.ID AND t1.tank_product = t2.tank AND t1.timestamp = t2.time
     where $type_for_whare = $site_id_from_liff
     group by grade";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <td><?php echo $row['grade']; ?></td>
                <td><?php echo number_format($row['sum_inventory']); ?></td>
                
              </tr>
                <?php 
                @$total = $total + $row["sum_inventory"];
                @$i++;
                        } 
                        
                ?>
                <tr>
                        <td colspan="1" align="right">น้ำมันคงเหลือรวม : </td>
                        <td><b></b><?php echo number_format($total,0); ?></td>
                        
                        </tr>
                        
    </table>




  <div>
    <br>
    <div>
    <h2 align = "center">รายละเอียดรายงานน้ำมันคงเหลือ</h2>
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
                <th>ถัง</th>
               <th>คงเหลือ</th>
                <th>90%ลงได้</th>
                <th>สถานะ</th>
                <th>เคลื่อนไหว</th>
              </tr>
              <?php

            $query2 = "SELECT
                        'inventory' as type_flex,
                        T1.ID as number_ID,
                        concat ('ประจำวันที่ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Date,
                            current_time() as Time,
                            concat('น้ำมันคงเหลือ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Title,
                            concat('วันที่ ',date_format(current_timestamp(),'%d/%m/%y  %H:%i')) as Title_menu,
                            site.tank as total_tank,
                        site.name as site_name,
                        T1.site_id as user_id,
                            tank_product,
                            concat(tank_product,':',tank.name) as tank_detail,
                            concat((site.sfl_limit*100),'%ที่ลงได้' )as Ullage_incress,
                            volume ,
                            format(height,0) as height,
                            format(ullage,0)as Ullage,
                            format(water,0) as water,
                        format(temp,2) as temp,
                            IF(format (((tank.max_or_lable * site.sfl_limit) - T1.volume),0)>0,format (((tank.max_or_lable * site.sfl_limit) - T1.volume),0),0) as SFL,
                            water_volume,
                            site.sfl_limit,
                            timestamp,
                        line_access_token as token,
                        date_format(timestamp,'%b,%d %H:%i') as time_update,
                        site.groupid as group_ID,
                        if (status_delivery = 1,'ลงน้ำมัน','-') as status_delivery,
                            comment
                            
                                FROM inventory as T1
                                            
                                            INNER JOIN  tank on T1.site_id = tank.site_id and T1.tank_product = tank.number 
                                INNER JOIN site on T1.site_id = site.ID 
                                            INNER JOIN user_information ON user_information.ID = site.ID 
                                            INNER JOIN status_check ON status_check.ID = site.ID
                                            where T1.site_id = ".$_SESSION['site_id']."  and member_status = 'none'
                                            order by tank_product";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row['tank_detail']; ?></td>
                <td><?php echo $row['volume']; ?></td>
                <td><?php echo $row['SFL']; ?></td>
                <td><?php echo $row['status_delivery']; ?></td>
                <td><?php echo $row['time_update']; ?></td>
              </tr>
                <?php 

            @$total = $total + $row["volume"];
            @$i++;
                        } 
                
                ?>
              <!-- <tr>
                <td colspan="1" align="right">คงเหลือรวม : </td>
                <td><b></b><?php echo number_format($total); ?></td>

                </tr>
                <?php unset ($total);?> -->
            </table>
        </div>
    
                       
                </article>
                </div> 
                <?php } ?>
    
    </div>
    

    

    
    
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="liff-starter.js"></script>
</body>