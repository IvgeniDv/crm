<?php
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$message_err ="";
$message = "";

//check GET request id parameter
if(isset($_GET['id_num'])){
    $id_num = mysqli_real_escape_string($con, $_GET['id_num']);

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
                                WHEN STRCMP(client_active, '0') = 0  THEN 'No'
                                ELSE 'Yes'
                            END AS 'client_active',
                            `client_end_date`
                    FROM `client_details`
                    WHERE id_num = '$id_num'
                    LIMIT 1";


    $result = mysqli_query($con, $query_get_client);
    $data = mysqli_fetch_assoc($result);



}else{
    $message_err ="Can't locate client in database.<br>Contact support.";
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

  <div class="container-fluid" role="navigation" >
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
                      if (mysqli_num_rows($result) > 0) {
                       ?>
                        
                <tr >   
                    <td><h6>ID number: </h6><?php echo $data['id_num']??''; ?></td>
                    <td>
                    <td><h6>Full Name: </h6>
                        <?php 
                            echo $data['first_name']??''; 
                            echo " ";
                            echo $data['last_name']??'';
                        ?> 
                    </td>
                    <td><h6>Age: </h6><?php echo $data['age']??''; ?></td>
                    <td><h6>Gender: </h6><?php echo $data['gender']??''; ?></td>
                    <td><h6>Active: </h6><?php echo $data['client_active']??''; ?></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><h6>Active since: </h6><?php echo $data['client_creation_date']??''; ?></td>
                
                    <td>
                        <h6 >Address: </h6>
                        <?php
                            echo $data['city']??'';
                            echo " ";
                            echo $data['street']??'';
                            echo " ";
                            echo $data['house_num']??'';
                            echo " ";
                            echo $data['aprtmnt_num']??'';

                        ?>
                    </td>
                    <td>
                        <h6>Contact info: </h6>
                        <?php
                            echo $data['phone']??'';
                            echo " ";
                            echo $data['another_phone']??'';
                            echo " ";
                            echo $data['email']??'';                            
                        ?>
                    </td>
                    
                    
                </tr>

                    <?php
                        } else { 
                    ?>
                <tr>
                    <td colspan="8">
                        <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_err; ?></p> 
                     
                    </td>
                </tr>
                     <?php
                        }?>

                </tbody>
            </table>

        </div>


        <?php 
            if( $message_err == "Can't locate client in database.<br>Contact support."){}else{    
        ?>

            <div class="container mt-5 border border-primary rounded" style=" margin-bottom: 10px;">
            <h2>New service</h2>
                <form method="post"  action="create_new_service.php" >
                    <div class="row" >
                        <div class="col-md-auto">
                            <input type="hidden" id="id" name="id_num" value="<?php echo $data['id_num']??''; ?>">
                            <input type="hidden" id="first_name" name="first_name" value="<?php echo $data['first_name']??''; ?>">
                            <input type="hidden" id="last_name" name="last_name" value="<?php echo $data['last_name']??''; ?>">

                            <div class="mb-3">
                                <input class="form-control" type="text" maxlength="45"  id="service_name" 
                                pattern="[A-Za-z0-9 -]{0,50}"  placeholder="Service name" name="service_name" required>    
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div class="mb-3">        
                                <input class="form-control w-75" type="text" min=0 max=1000000 maxlength="7"  id="service_fee" placeholder="Service fee"  name="service_fee" 
                                pattern="[0-9]{0,7}" >        
                            </div>
                        </div>

                        <!--
                        <div class="col">
                            <div class="mb-3  w-25">
                            <label for="service_fully_paid" class="form-label">Service fully paid</label>
                            <select class="form-select" size="2" aria-label="size 2 service_fully_paid" name="service_fully_paid">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>
            

                        <div class="col">
                            <div class="mb-3  w-25">
                            <label for="service_completed" class="form-label">Service completed</label>
                            <select class="form-select" size="2" aria-label="size 2 service_completed" name="service_completed">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col">
                            <div class="mb-3">        
                                <label for="service_paid_amountfee" class="form-label">Paid amount</label>
                                <input class="form-control w-75" type="text" min=0 max=1000000 maxlength="7"  id="paid_amount" placeholder="Paid amount"  name="paid_amount" 
                                pattern="[0-9]{0,7}" >        
                            </div>
                        </div>

                        

                        <div class="col">
                            <div class="mb-3  w-25">
                            <label for="completion_reason" class="form-label">Completion reason</label>
                            <select class="form-select" size="2" aria-label="size 2 completion_reason" name="completion_reason">
                                <option value="0">success - fully paid and full done</option>
                                <option value="1">Client side termination</option>
                                <option value="2">Organisation side termination</option>
                                </select>
                            </div>
                        </div>
                        
                    -->

                    </div>

                        <div class="mb-3">
                                <label for="short_desription" class="form-label">Short description</label>
                                <textarea class="form-control w-75"  id="short_desription"  placeholder="Up to 100 characters" name="short_desription" maxlength="100" rows="3" cols="100"></textarea>
                        </div><!--pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,100}"  -->

                        <div class="mb-3">
                                <label for="full_description" class="form-label">Full description</label>
                                <textarea class="form-control w-75"  id="full_description"  placeholder="Up to 10,000 characters" name="full_description" maxlength="10000" rows="13" cols="100"></textarea>
                        </div><!--  pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,10000}"    -->

                        <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control w-75"  id="comments"  placeholder="Up to 200 characters" name="comments" maxlength="200" rows="4" cols="100"></textarea>
                        </div><!-- pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,200}" -->
                    
                        <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 20px; margin-bottom: 10px;">Create new service</button>
                        <a class="btn btn-outline-primary" style="margin-top: 20px; margin-bottom: 10px;" href="client_record.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Back to client's record</a>
                </form>
                
            </div>


        <?php }?>













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
