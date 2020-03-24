<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeeOil Application</title>
    <link rel="stylesheet" href="style.css">
    <style media="screen">

                #inventory_detail {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 95%;
                    padding: 5px;
                    border: solid 1px red;
                    box-shadow: 5px 5px rgba(255,0,0,0.5);
                    margin: 10px;
                    box-sizing: border-box;

                }
                #main_selling {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 40%;
                    margin: 0 auto;
                    padding: 5px;
                    border: solid 1px red;
                    box-shadow: 5px 5px rgba(255,0,0,0.5);

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

    <div class="thad">
    <article class="uk-article">
        
    <div = class="inventory">
    <h2 align = "center">รายงานสรุปยอดขาย</h2>


    <table id = "main_selling"> 
        <tr>   
        <th>ยอดขายรวม</th> 
        </tr>
        <?php

            $query2 = "SELECT 
            sum(t1.selling) as Selling_day
         FROM dailyreport as t1
             INNER JOIN (
									SELECT site.ID, inv.tank, inv.time
									FROM site
												INNER JOIN (
																SELECT dailyreport.site_id, tank_number AS tank,  MAX(closing_DT) AS time
																FROM dailyreport
																GROUP BY site_id, tank_number
																														) AS inv ON inv.site_id = site.ID
																																) AS t2 ON t2.ID = t1.site_id AND t2.tank = t1.tank_number AND t2.time = t1.closing_DT
             
             INNER JOIN site ON site.ID = t1.site_id 
             
                    WHERE $type_for_whare = $site_id_from_liff";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <td><?php echo number_format($row['Selling_day'],0); ?></td>
                
              </tr>
                <?php 

                        } 
                
                ?>
                
    </table>




  <div>
    </div>
    <div>
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
            <table id = "inventory_detail">
              <h3> <?php 
                echo $row_new['site_name'];
                
                ?>
                
              </h3>
              

              <tr>
                <th>ถัง</th>
               <th>ยอดขาย</th>
                <th>ลงน้ำมัน</th>
                <th>ผลต่าง</th>
                <th>เวลาปิดวัน</th>
              </tr>
              <?php

            $query2 = "SELECT 
            t1.ID,
            t1.site_id as user_id,
            site.name as site_name,
            site.name,
            concat ('วันที่ ',date_format(t1.closing_DT,'%d/%m/%Y'),' เวลาปิดวัน ',date_format(t1.closing_DT,'%H:%m')) as Open_date,
            concat (date_format(t1.closing_DT,'%b,%d'),',',date_format(t1.closing_DT,'%H:%m')) as close_time,
           concat(t1.tank_number,':',tank_name) as tank_detail,
           site.tank as total_tank,
          concat('สรุปยอดขายประจำวัน') as Title,
           selling,
           format(t1.opening_volume,0) as Opening,
           t1.delivery as Delivery,			
           format(t1.closing_Volume,0) as Closing,
           format(t1.selling,0) as Selling_day,
           selling as Selling_for_header,
           site.groupid as group_ID,
           t1.variance as Variance
        FROM dailyreport as t1
            INNER JOIN (
                SELECT site.ID, site.name, inv.tank, inv.tank_name, inv.time
                FROM site
                INNER JOIN (
                    SELECT dailyreport.site_id, tank_number AS tank, tank.name AS tank_name, MAX(closing_DT) AS time
                    FROM dailyreport
                    INNER JOIN tank ON dailyreport.site_id = tank.site_id AND dailyreport.tank_number = tank.number
                    GROUP BY site_id, tank_number
                ) AS inv ON inv.site_id = site.ID
            ) AS t2 ON t2.ID = t1.site_id AND t2.tank = t1.tank_number AND t2.time = t1.closing_DT
            INNER JOIN site ON site.ID = t1.site_id 
            
        WHERE site_id = ".$_SESSION['site_id']."
        ORDER BY site_id, tank_number";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                <td id="tank_detail"><?php echo $row['tank_detail']; ?></td>
                <td><?php echo $row['selling']; ?></td>
                <td><?php echo $row['Delivery']; ?></td>
                <td><?php echo $row['Variance']; ?></td>
                <td><?php echo $row['close_time']; ?></td>
              </tr>
              <?php 

                @$total = $total + $row["selling"];
                @$i++;
                  
                        } 
                
                ?>
              <tr>
                <td colspan="1" align="right">ยอดขายรวม : </td>
                <td><b></b><?php echo number_format($total); ?></td>
                
                </tr>
                <?php unset ($total);?>
	</table>
            </table>
        </div>
    
                       
                </article>
                </div> 
                <?php } ?>
    
    </div>
    

    

    
    
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="liff-starter.js"></script>
</body>