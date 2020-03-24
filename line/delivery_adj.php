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
$for_check_bir = $_SESSION['bir_status_check'];

//echo $site_id_from_liff;
//echo $for_check_bir;
if ($type_whare == "user_id"){
$type_for_whare = $type_whare;
}
if ($type_whare == "ID"){
    $type_for_whare = $command = 'site_'.strtolower($type_whare);
}
include 'buttom_head.php';
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

if ($for_check_bir == "yes"){ ?>

    <br>
    <div>
        <h2 align = "center">รายงานรับน้ำมันล่าสุด</h2>
        <?php 
        while ($row_new = mysqli_fetch_assoc($result1)){ 
            $_SESSION['site_id'] = $row_new['site_id'];
            ?>

        <div class="thad">
                <article class="uk-article">
                    <div = class="inventory">
                        <table>
                            <h3> <?php echo $row_new['site_name'];?>   </h3>

                                <tr>
                                    <th>ถัง</th>
                                    <th>วันที่ลงน้ำมัน</th>
                                    <th>ยอดรับน้ำมัน</th>
                                    <th>ยอดขายระหว่างลง</th>
                                </tr>
                                <?php
                                $query2 = "SELECT
                                starting_date_time,
                                concat('T',tank_number,' ', t2.tank_name) as Tank_detail,
                                starting_volume,
                                date_format(ending_date_time,'%d/%m/%y %H:%i') as ending_date_time,
                                ending_volume,
                                total_seling,
                                adjusted_delivery_volume
                                FROM adjusteddelivery AS t1
                                INNER JOIN (
                                SELECT site.ID, site.user_id,site.name, inv.tank, inv.tank_name, inv.time
                                FROM site
                                INNER JOIN (
                                SELECT adjusteddelivery.site_id, tank_number tank, tank.name AS tank_name, MAX(starting_date_time) AS time
                                FROM adjusteddelivery
                                INNER JOIN tank
                                ON adjusteddelivery.site_id = tank.site_id AND adjusteddelivery.tank_number = tank.number
                                GROUP BY site_id, tank_number
                                ) AS inv
                                ) AS t2
                                ON t1.site_id = t2.ID AND t1.tank_number = t2.tank AND t1.starting_date_time = t2.time
                                where site_id = ".$_SESSION['site_id']."
                                ORDER BY site_id, tank_number";
                        $result2 = mysqli_query($dbcon,$query2);
                                ?>    
                                <?php while ($row = mysqli_fetch_assoc($result2)){?>
                                    <tr>
                                        <td id="Tank_detail"><?php echo $row['Tank_detail']; ?></td>
                                        <td><?php echo $row['ending_date_time']; ?></td>
                                        <td><?php echo number_format($row['adjusted_delivery_volume'],0); ?></td>
                                        <td><?php echo number_format($row['total_seling'],0); ?></td>
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


<?php }  else   { ?>

    <br>
    <div>
        <h2 align = "center">รายงานรับน้ำมันล่าสุด</h2>
        <?php 
        while ($row_new = mysqli_fetch_assoc($result1)){
            $_SESSION['site_id'] = $row_new['site_id'];
            ?>

        <div class="thad">
                <article class="uk-article">
                    <div = class="inventory">
                        <table>
                            <h3> <?php echo $row_new['site_name'];?>   </h3>

                                <tr>
                                    <th>ถัง</th>
                                    <th>วันที่ลงน้ำมัน</th>
                                    <th>ยอดรับน้ำมัน</th>
                                    <th>ยอดขายระหว่างลง</th>
                                </tr>
                                <?php
                                $query3 = "SELECT
                                Starting_date_time as starting_date_time,
                                concat('T',tank_product,' ', t2.tank_name) as Tank_detail,
                                starting_volume,
                                date_format(End_date_time,'%d/%m/%y %H:%i') as ending_date_time,
                                Amount as adjusted_delivery_volume
                                FROM delivery_record AS t1
                                INNER JOIN (
                                SELECT site.ID, site.user_id,site.name, inv.tank, inv.tank_name, inv.time
                                FROM site
                                INNER JOIN (
                                SELECT delivery_record.site_id, tank_product tank, tank.name AS tank_name, MAX(Starting_date_time) AS time
                                FROM delivery_record
                                INNER JOIN tank
                                ON delivery_record.site_id = tank.site_id AND delivery_record.tank_product = tank.number
                                GROUP BY site_id, tank_product
                                ) AS inv
                                ) AS t2
                                ON t1.site_id = t2.ID AND t1.tank_product = t2.tank AND t1.starting_date_time = t2.time
                                where site_id = ".$_SESSION['site_id']."
                                ORDER BY site_id, tank_product";
                        $result3 = mysqli_query($dbcon,$query3);
                                ?>       
                                <?php while ($row = mysqli_fetch_assoc($result3)){?>
                                    <tr>
                                        <td id="Tank_detail"><?php echo $row['Tank_detail']; ?></td>
                                        <td><?php echo $row['ending_date_time']; ?></td>
                                        <td><?php echo number_format($row['adjusted_delivery_volume'],0); ?></td>
                                        <td><?php echo "N/A"; ?></td>
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


<?php } 

?>

    
    

    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="liff-starter.js"></script>
</body>