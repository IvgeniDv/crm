<?php
include("database_connection.php");


session_start();

if(isset($_SESSION["login"] )){



$message_err ="";
$message = "";




//check GET request id parameter
if(isset($_GET['id_num'])){
    $id_num = mysqli_real_escape_string($con, $_GET['id_num']);

    $query_get_client = "UPDATE client_details
                            SET
                            `client_active` =  '0',
                            `client_end_date` = now() 
                            WHERE `id_num` = '$id_num'
                            ";


$result = mysqli_query($con, $query_get_client);

if($result){

    $message = "Client disabled successfully";

  } else{
    $message_err = "Somthing went wrong with updating the database.<br>Client wasnt disabled.<br>Contact support.";
    
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
    </style>
</head>
<body>


<div class="container-fluid" role="navigation" style="margin-top: 10px">
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
            <a class="nav-link"   href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="existing _client.php">Client list</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="archive_list.php">Archive</a>
          </li>
        </ul>
      </div>
    

    <?php 
        if($message == "Client disabled successfully"){      
    ?>

        <div class="container mt-5 border border-success rounded">
            <h2><?php echo $message; ?></h2>

        </div>

    <?php }else{?>
        
        <div class="container mt-5 border border-danger rounded">
            <h2><?php echo $message_err; ?></h2>
    
        </div>
    <?php }?>

</body>


</html>

















<?php // free result from memory


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
                
                <input class="form-control" style="margin-top: 45px;" type="text" maxlength="15"  id="user_name" 
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
