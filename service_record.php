<?php 
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$message_err ="";
$message = "";

//check GET request id parameter
if(isset($_GET['service_id'])){
    $service_id = mysqli_real_escape_string($con, $_GET['service_id']);

    $sql = "SELECT 
                `service_id`,
                `client_id_num`,
                `client_first_name`,
                `client_last_name`,
                `service_name`,
                `service_short_desription`,
                `service_full_description`,
                `comments`,
                `service_fee`,
                CASE
                    WHEN STRCMP(service_fully_paid, '0') = 0 THEN 'No'
                    ELSE 'Yes'
                END AS `service_fully_paid`,
                
                `paid_amount`,
                CASE
                    WHEN STRCMP(service_completed, '0') = 0 THEN 'No'
                    ELSE 'Yes'
                END AS `service_completed`,
                
                CASE
                    WHEN STRCMP(service_completion_reason, '0') = 0 THEN 'success - fully paid and fully done'
                    WHEN STRCMP(service_completion_reason, '1') = 0 THEN 'client side termination'
                    WHEN STRCMP(service_completion_reason, '2') = 0 THEN 'organisation side termination'
                    ELSE ''
                END AS  `service_completion_reason`,
            
                `service_completion_date`,
                `service_creation_date`

            FROM services
            WHERE `service_id` = '$service_id' 
            LIMIT 1";


    $result = mysqli_query($con, $sql);

    if($result){
        $data =  mysqli_fetch_assoc($result);
        $client_id = $data['client_id_num']??'';

        $query_get_client = "SELECT `id_num`,
                            `first_name`,
                            `last_name`,
                            `age`,
                            `gender`,
                            `city`,
                            `street`,
                            `house_num`,
                            `aprtmnt_num`,
                            `phone`,
                            `another_phone`,
                            `email`,
                            `client_creation_date`,
                            CASE
                                WHEN STRCMP(client_active, '0') = 0 THEN 'No'
                                ELSE 'Yes'
                            END AS 'client_active',
                            `client_end_date`
                    FROM `client_details`
                    WHERE id_num = '$client_id'
                    LIMIT 1";


        $rs = mysqli_query($con, $query_get_client);

        if($rs){
            $client_data =  mysqli_fetch_assoc($rs);

        }else{
            $message_err ="Can't find client in database. Contact support.";
        }


    }else{
        $message_err ="Can't find service in database. Contact support.";
    }

}



?>







<!DOCTYPE html>
<html lang="en">
<head>
  <title>HeyCat</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          display: none;
         }
         h6{
            display: inline;
         }
         .inline{
            display: inline;

         }
         .gallery {
            max-width: 100px;
            height: 100px;
            display: inline;
         }  
       
    </style>
</head>
<body>

    <div class="container-fluid" role="navigation">
        <img src="images/cat_banner.jpg" alt="cats" style="height: 100px;">
    </div>

    <div class="container-fluid" role="navigation" style="margin-top: 10px">
        <ul class="nav nav-tabs"  >  <!--class="nav nav-bar"-->
          <li class="nav-item">
            <a class="nav-link"  href="newClient.php">New client</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search_client.php">Client search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="client_record.php">Client record</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payments_list.php" >Payments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="service_list.php">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="existing _client.php">Client list</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="archive_list.php">Archive</a>
          </li>
        </ul>
      </div>
    

    <div class="container mt-5 border border-primary rounded">
        <h2>Client details</h2>

        <table class="table table-borderless">

            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>   
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($rs) > 0) {
                    //$sn=1;
                    //while($data = mysqli_fetch_assoc($result)) {
                ?>
                    
            <tr >   
                <td><h6>ID number: </h6><?php echo $client_data['id_num']??''; ?></td>
                <td>
                <td><h6>Full Name: </h6>
                    <?php 
                        echo $client_data['first_name']??''; 
                        echo " ";
                        echo $client_data['last_name']??'';
                    ?> 
                </td>
                <td><h6>Age: </h6><?php echo $client_data['age']??''; ?></td>
                <td><h6>Gender: </h6><?php echo $client_data['gender']??''; ?></td>
                <td><h6>Active: </h6><?php echo $client_data['client_active']??''; ?></td>
                
            </tr>
            <tr>
            <td></td>
                <td></td>
            <td><h6>Active since: </h6><?php echo $client_data['client_creation_date']??''; ?></td>

                <td>
                    <h6 >Address: </h6>
                    <?php
                        echo $client_data['city']??'';
                        echo " ";
                        echo $client_data['street']??'';
                        echo " ";
                        echo $client_data['house_num']??'';
                        echo " ";
                        echo $client_data['aprtmnt_num']??'';

                    ?>
                </td>
                <td>
                <h6>Contact info: </h6>
                    <?php
                        echo $client_data['phone']??'';
                        echo " ";
                        echo $client_data['another_phone']??'';
                        echo " ";
                        echo $client_data['email']??'';                            
                    ?>
                </td>
                
                
            </tr>

            <?php
                //$sn++;}
                } else { 
            ?>
                <tr>
                <td colspan="8">
                <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_err; ?></p> 
                
                </td>
                <tr>
                <?php
                    }?>

            </tbody>
        </table>

        <a class="btn btn-outline-primary" style="margin-bottom: 10px;" href="client_record.php?id_num=<?php echo $client_data['id_num']??''; ?>" role="button">Back to client's record</a>            
    </div>


    <div class="container mt-5 border border-primary rounded">
        <h2>Service details</h2>

        <table class="table table-borderless">
                
                
                <tbody>
                    <?php
                      if (mysqli_num_rows($result) > 0) {
                        
                    ?>
                           <tr >    
                                <td>
                                    <h6 >Service name: </h6>
                                    <?php echo $data['service_name']??'';  ?> 
                                </td>
                                <td>
                                    <h6 >Creation date: </h6>
                                    <?php echo $data['service_creation_date']??''; ?> 
                                </td>
                                <td>
                                    <h6 >Completed: </h6>
                                    <?php echo $data['service_completed']??''; ?>
                                </td>
                                <td>
                                    <h6 >Completion reason: </h6>
                                    <?php echo $data['service_completion_reason']??''; ?>
                                </td>
                                <td>
                                    <h6 >Completion date: </h6>
                                    <?php echo $data['service_completion_date']??''; ?>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <h6 >Service fee: </h6>
                                    <?php echo $data['service_fee']??'';  ?> 
                                </td>
                                <td>
                                    <h6 >Is fully paid: </h6>
                                    <?php echo $data['service_fully_paid']??'';  ?> 
                                </td>
                                <td>
                                    <h6 >Current paid amount: </h6>
                                    <?php echo $data['paid_amount']??'';  ?> 
                                </td>
                            </tr>

                    <?php
                         } else { 
                    ?>
                    <tr>
                    <td colspan="8">
                     <?php echo $message_err; ?>
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>
            </table>

           

            <form action="upload_file_service.php" method="post" enctype="multipart/form-data" style="margin-bottom: 10px; " >
                <input type="hidden" id="id_service" name="service_id_num" value="<?php echo $data['service_id']??''; ?>">

                <input  type="file" class= "form-control w-25 inline" name ="file_upload">
                <input  class="btn btn-outline-primary" type="submit" name="submit_file" value="Upload">
            </form>
          

            <div style="margin-bottom:10px;" >
                 
                        <?php 
                        
                            $sql_files = "SELECT *
                                            FROM service_attached_files WHERE service_id LIKE  '$service_id' ORDER BY upload_date DESC
                                        ";

                            $result_files =mysqli_query($con, $sql_files);

                            if(mysqli_num_rows($result_files) > 0){
                                while($row = mysqli_fetch_assoc($result_files)){
                                    $fileURL = "uploads/".$row['file_name'];

                                     $fileType = pathinfo($fileURL,PATHINFO_EXTENSION);


                        ?>


                       <div class="container inline" >

                            <a href="<?php echo $fileURL; ?>" target="_blank">
                                <img class="gallery" src="<?php echo $fileURL; ?>" alt=" " title="<?php echo $row['file_name']; ?>" />
                            </a>
                            <a class="btn btn-outline-primary" style="margin-bottom: 10px;" href="" role="button">Delete file</a>

                        </div>


                        <?php }}else{
                        ?>

                           <p>No files found... </p>
                            
                        <?php   } ?>
                  
            </div>

            <div  >
                    <form method="post"  action="create_pdf.php" class="inline" > 
                        <input type="hidden"  id="service_id" name="service_id" value="<?php echo $data['service_id']??''; ?>">
                        <button  name="submit_btn" type="submit" class="btn btn-outline-primary inline" style="margin-bottom: 15px">Service to pdf</button>
                    </form>
            
            
                <a class="btn btn-outline-primary" style="margin-bottom: 15px;" href="update_service.php?service_id=<?php echo $data['service_id']??''; ?>" role="button">Update Service</a>
                <a  class="btn btn-outline-danger" style="margin-bottom: 15px;" href="delete_service.php?service_id=<?php echo $data['service_id']??''; ?>" role="button">Delete service</a>
                
            </div>         

    </div>

    <div class="container mt-5 border border-primary rounded" style="margin-bottom:10px;">
        <h2>Service content</h2>
                    
        
        <table class="table table-borderless">
                
                <tbody>
                    <?php
                      if (mysqli_num_rows($result) > 0) {
                        
                    ?>
                    <tr>
                        <td>    
                            <h6 >Desription: </h6>
                            <br>
                            <?php echo $data['service_short_desription']??'';  ?> 
                        </td>
                    </tr>
                    

                    <tr>
                        <td>    
                            <h6 >Service content: </h6>
                            <br>
                            <?php echo $data['service_full_description']??'';  ?> 
                        </td>
                    </tr>

                    <tr>
                        <td>   
                            <h6 >Comments: </h6>
                            <br>
                            <?php echo $data['comments']??'';  ?>  
                        </td>
                    </tr>


                    <?php
                         } else { 
                    ?>
                    <tr>
                    <td colspan="8">
                     <?php echo $message_err; ?>
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>

        </table>


    </div>




</body>


</html>




<?php 
mysqli_close($con);
 ?>

 
<?php
}else{


        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
          <title>HeyCat</title>
          <link rel="icon" type="image/x-icon" href="images/favicon.ico">
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
          <style>
                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                  display: none;
                }
            </style>
        </head>
        <body>

          <div class="container-fluid" role="navigation">
            <img src="images/cat_banner.jpg" alt="cats" style="height: 100px;">
          </div>


            

              <div class="container mt-5 border border-primary rounded">
                <h2>Restricted access. please log in</h2>
            </div>



      <div class="container mt-5 border border-primary rounded"  style=" margin-bottom: 10px; margin-top: 10px; width: 20%; text-align: center;">
        
        <h2 style="text-align: center;  margin-top: 25px;">Log in</h2>


        <form method="post"  action="login.php" >

            <div class="mb-3">
                
                <input class="form-control " style="margin-top: 45px;" type="text" maxlength="15"  id="user_name" 
                  placeholder="User name" name="user_name" pattern="[A-Za-z ]{5,15}"  >    
              </div>

              <div class="mb-3">
                <input class="form-control" type="text" maxlength="10"  id="password" 
                  placeholder="Password" name="password" pattern="[A-Za-z 0-9]{8,8}" >    
              </div>


              <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 25px;margin-bottom: 25px; ">Log in</button>

        </form>
    </div>








        </body>


        </html>





<?php } ?>
