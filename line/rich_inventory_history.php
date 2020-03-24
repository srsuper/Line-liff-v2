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
                    text-align: center;

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



//echo $aa = 'site data from liff'.''.$site_id_from_liff;
//echo $bb = 'type for where '.''.$type_for_whare;
    
    include 'connectdb.php';
    
?>

<div = class="inventory">
    
  <div>
    <br>
    <div>
    <h2 align = "center">รายงานประวัติน้ำมันคงเหลือย้อนหลัง</h2>
    <?php 

            

            
            include 'connectdb.php';
            $query1 = "SELECT 
                            site_profile.site_id as site_id,
                            name as site_name,
                            concat ('ประจำวันที่ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Date
                                    FROM site_profile 
                                        INNER JOIN site ON site.ID = site_profile.site_id
                                        WHERE site_profile.ID = 42";

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
              <h3 align = "center"> <?php 
                echo $row_new['site_name'];?>
                  
              </h3>

              <tr>
                
               <th>วันที่</th>
               <th>กดเลือกรายงาน</th>
                
              </tr>
              <?php

            $query2 = "SELECT store_json.ID,
                                            store_json.site_id,
                                                flex_type,title ,
                                                
                                                concat ('ประจำวันที่ ',date_format(current_timestamp(),'%d/%m/%Y %H:%i')) as Date,
                                                        site.name as site_name FROM seeoil.store_json
                                                                inner join site on site.ID = store_json.site_id
                                                                where site_id = 42 and flex_type = 'inventory'
                                                                order by ID DESC
                                                                limit  9";
                $result2 = mysqli_query($dbcon,$query2);
                while ($row = mysqli_fetch_assoc($result2)){
              ?>
              <tr>
                
                <td id="tank_detail"><?php echo $row['title']; ?></td>
                <td id="tank_detail"><button id="sendMessageButton">Send Message</button></td>
                
               
                
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

    <script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
    <script src="liff-starter-1.js"></script>
</body>