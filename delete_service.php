<?php
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$message_err ="";
$message = "";


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
                    WHEN STRCMP(service_completion_reason, '0') = 0 THEN 'success - fully paid and full done'
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
    }else{
        $message_err ="Can't find client in database. Contact support.";
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
            <a class="nav-link active" href="client_record.php">Client record</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payments_list.php" >Payments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"   href="service_list.php">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="existing _client.php">Client list</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="archive_list.php">Archive</a>
          </li>
        </ul>
      </div>
    

      <div class="container mt-5 border border-warning rounded" style="margin-bottom:10px;">
        <h2>Are you sure you want to permanently delete the following service?</h2>

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

            <a class="btn btn-outline-success" style="margin-bottom: 15px;" href="service_record.php?service_id=<?php echo $data['service_id']??''; ?>" role="button">No, take me back</a>
            <a class="btn btn-outline-danger" style="margin-bottom: 15px;" href="truly_delete_service.php?service_id=<?php echo $data['service_id']??''; ?>" role="button">Yes, delete this service forever</a>


    </div>







</body>


</html>









<?php 
// close connection
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
                <input class="form-control " type="text" maxlength="10"  id="password" 
                  placeholder="Password" name="password" pattern="[A-Za-z 0-9]{8,8}" >    
              </div>


              <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 25px;margin-bottom: 25px; ">Log in</button>

        </form>
    </div>








        </body>


        </html>





<?php } ?>
