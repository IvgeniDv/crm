<?php
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){
  
$message_err ="";
$message = "";


// get the post records by name

$id_num = mysqli_real_escape_string($con, $_POST['id_num']);
$first_name =mysqli_real_escape_string($con, $_POST['first_name']);
$last_name =  mysqli_real_escape_string($con,$_POST['last_name']);
$service_name =  mysqli_real_escape_string($con,$_POST['service_name']);
$service_fee =  mysqli_real_escape_string($con,$_POST['service_fee']);
$short_desription =  mysqli_real_escape_string($con,$_POST['short_desription']);
$full_description =  mysqli_real_escape_string($con,$_POST['full_description']);
$comments =  mysqli_real_escape_string($con,$_POST['comments']);

//$id_num = $mysqli -> real_escape_string($_POST['id_num']);  // nn pk unique
//$first_name = $mysqli -> real_escape_string( $_POST['first_name']);
//$last_name =  $mysqli -> real_escape_string($_POST['last_name']);
//$service_name =  $mysqli -> real_escape_string($_POST['service_name']);
//$service_fee =  $mysqli -> real_escape_string($_POST['service_fee']);
//$short_desription =  $mysqli -> real_escape_string($_POST['short_desription']);
//$full_description =  $mysqli -> real_escape_string($_POST['full_description']);
//$comments =  $mysqli -> real_escape_string($_POST['comments']);


$sql ="INSERT INTO services
                    (
                    `client_id_num`,
                    `client_first_name`,
                    `client_last_name`,
                    `service_name`,
                    `service_short_desription`,
                    `service_full_description`,
                    `comments`,
                    `service_fee`,
                    `service_fully_paid`,
                    `paid_amount`,
                    `service_completed`,
                    `service_completion_reason`,
                    `service_completion_date`,
                    `service_creation_date`)

        VALUES
                ('$id_num','$first_name','$last_name','$service_name','$short_desription','$full_description','$comments','$service_fee','0','0','0',NULL,NULL,now())";

$result = mysqli_query($con, $sql);

if($result){
    $message = "New service: ".$service_name.", created successfully for client: ".$id_num.", ".$first_name." ".$last_name;

}else{

    $message_err = "Somthing went wrong with creating a new service.<br>The data was not saved.<br>Contact support.";
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
    

      <div class="container mt-5 border border-primary rounded">
        <h2 id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_err; ?></h2>
        <h2 id="sql_result2" style="font-family: Tahoma; font-size: 15px; color: rgb(51, 204, 51)"><?php echo $message; ?></h2>
        <a class="btn btn-outline-primary" style="margin-bottom: 15px; margin-top: 15px;" href="client_record.php?id_num=<?php echo $id_num; ?>" role="button">Back to client's record</a>
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
