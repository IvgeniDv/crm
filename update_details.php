<?php 
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){


$id_num = $_POST['id_num'];  // nn pk unique
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$city = $_POST['city'];
$street = $_POST['street'];
$house_number = $_POST['house_number'];
$apartment_number = $_POST['apartment_number'];
$phone = $_POST['phone']; // do we want to check for same phone in db? dont want to send info to wrong client
$another_phone = $_POST['another_phone'];
$email = $_POST['email'];  // do we want to check for same email in db? dont want to send info to wrong client
$active = $_POST['active'];
$message = "";
$message_err = "";



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
                             'client_active',
                            `client_end_date`
                    FROM `client_details`
                    WHERE id_num = '$id_num'
                    LIMIT 1";


$result = mysqli_query($con, $query_get_client);
$data = mysqli_fetch_assoc($result);


if (mysqli_num_rows($result) < 1) {
    $message_err ="No records matching this id number were found.";
    
}else{


    if($active == $data['client_active']??''){
        $sql = "UPDATE client_details
                SET
                    `id_num` = '$id_num',
                    `first_name` =  '$first_name',
                    `last_name` =  '$last_name',
                    `age` =  '$age',
                    `gender` = '$gender',
                    `city` = '$city',
                    `street` = '$street',
                    `house_num` = '$house_number',
                    `aprtmnt_num` = '$apartment_number',
                    `phone` = '$phone',
                    `another_phone` = '$another_phone',
                    `email` = '$email',
                WHERE `id_num` = '$id_num' ";


        $sql_payments = "UPDATE client_payment_balance
                        SET
                          `client_name` = '$first_name $last_name',
                          `client_email` = '$email',
                          `client_phone` = '$phone'
                        WHERE `id_num` = '$id_num' ";



    }elseif($active == "0"){
        $sql = "UPDATE client_details
                SET
                    `id_num` = '$id_num',
                    `first_name` =  '$first_name',
                    `last_name` =  '$last_name',
                    `age` =  '$age',
                    `gender` = '$gender',
                    `city` = '$city',
                    `street` = '$street',
                    `house_num` = '$house_number',
                    `aprtmnt_num` = '$apartment_number',
                    `phone` = '$phone',
                    `another_phone` = '$another_phone',
                    `email` = '$email',
                    `client_active` = '$active',
                    `client_end_date` = now()
                WHERE `id_num` = '$id_num' ";

        $sql_payments = "UPDATE client_payment_balance
                        SET
                          `client_name` = '$first_name $last_name',
                          `client_email` = '$email',
                          `client_phone` = '$phone'
                        WHERE `id_num` = '$id_num' ";


    }else{

        $sql = "UPDATE client_details
                SET
                    `id_num` = '$id_num',
                    `first_name` =  '$first_name',
                    `last_name` =  '$last_name',
                    `age` =  '$age',
                    `gender` = '$gender',
                    `city` = '$city',
                    `street` = '$street',
                    `house_num` = '$house_number',
                    `aprtmnt_num` = '$apartment_number',
                    `phone` = '$phone',
                    `another_phone` = '$another_phone',
                    `email` = '$email',
                    `client_active` = '$active',
                    `client_end_date` = NULL
                WHERE `id_num` = '$id_num' ";


        $sql_payments = "UPDATE client_payment_balance
                        SET
                          `client_name` = '$first_name $last_name',
                          `client_email` = '$email',
                          `client_phone` = '$phone'
                        WHERE `id_num` = '$id_num' ";


    }
   
    $result = mysqli_query($con, $sql);
    $rs =  mysqli_query($con, $sql_payments);

    if($result && $rs){
        $message = "Client details updated successfully";

    }else{

        $message_err = "Something went wrong. Please contact support.";
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
        <a class="btn btn-outline-primary" style="margin-bottom: 15px; margin-top: 15px;" href="client_record.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Back to client's record</a>
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
