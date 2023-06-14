

<?php
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$message_not_found = "";
$message_err ="";
$message = "";
$message_service_not_found = "";

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
                                    WHEN STRCMP(client_active, '0') = 0 THEN 'No'
                                    ELSE 'Yes'
                                END AS 'client_active',
                                `client_end_date`
                        FROM `client_details`
                        WHERE id_num = '$id_num'
                        LIMIT 1";


    $result = mysqli_query($con, $query_get_client);
    $data = mysqli_fetch_assoc($result);

    $sql_get_payment = "SELECT `id_num`,
                                `client_name`,
                                CASE
                                    WHEN STRCMP(client_owes, '0') = 0  THEN 'No'
                                    ELSE 'Yes'
                                END as `client_owes`,
                                `debt_amount`,
                                CASE
                                    WHEN STRCMP(client_in_surplus, '0') = 0  THEN 'No'
                                    ELSE 'Yes'
                                END as `client_in_surplus`,

                                `surplus_amount`,
                                `client_email`,
                                `client_phone`
                        FROM `client_payment_balance`
                        WHERE id_num = '$id_num'
                        LIMIT 1";

    $result_payment = mysqli_query($con, $sql_get_payment);

    if (mysqli_num_rows($result_payment) < 1) {
        $message_not_found = "Sorry,<br>No records matching this id number were found.";
    }


    $sql_service = "SELECT 
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
                WHERE `client_id_num` = '$id_num' AND service_completed = '0'
                ORDER BY `service_completed`,`service_fee`,`service_creation_date` desc ";

        $result_service = mysqli_query($con, $sql_service );
   
        if (mysqli_num_rows($result_service) < 1) {
            $message_service_not_found = "No active records matching this id number were found.";
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
                        //$sn=1;
                        //while($data = mysqli_fetch_assoc($result)) {
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
                    //$sn++;}
                    } else { 
                ?>
                    <tr>
                    <td colspan="8">
                    <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_not_found; ?></p> 
                     
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>
            </table>

                
        <a class="btn btn-outline-primary" style="margin-bottom: 15px;" href="update_client_detail.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Update client details</a>
        <a  class="btn btn-outline-danger" style="margin-bottom: 15px;" href="disable_client.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Disable client</a>


    </div>



    <div class="container mt-5 border border-primary rounded">
        <h2>Client payment balance</h2>
                        
        <table class="table table-borderless">

            <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
            </thead>
            <tbody>
                    <?php
                      if (mysqli_num_rows($result_payment) > 0) {
                        $data = mysqli_fetch_assoc($result_payment) 
                    ?>

                    <tr>
                        <td><h6>Active Debt: </h6>
                            <?php echo $data['client_owes']??''; ?>
                        </td>
                        <td><h6>Debt amount: </h6>
                            <?php echo $data['debt_amount']??''; ?>
                        </td>
                        <td><h6>Active surplus: </h6>
                            <?php echo $data['client_in_surplus']??''; ?>
                        </td>
                        <td><h6>Surplus amount: </h6>
                            <?php echo $data['surplus_amount']??''; ?>
                        </td>
                    </tr>

                    <?php
                        } else { 
                    ?>
                        <tr>
                        <td colspan="8">
                        <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_not_found; ?></p> 
                        </td>
                        <tr>

                        <?php
                        }?>
            </tbody>
        </table>
        
        <h5>Update payment balace</h5>
        <form method="post"  action="update_payment.php" >
                        <div class="row">
                           <div class="col-md-auto">
                            <h6>Active debt: </h6>
                            
                            <div class="mb-3 ">
                            <select class="form-select" size="2" aria-label="size 2 active_debt" name="active_debt" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                </select>
                            </div>
                            <!--
                            <select class="form-select" style="margin-bottom: 15px;" aria-label="active_debt" name="active_debt" id="active_debt" required>                    
                                <option value="0">NO</option>
                                <option value="1">Yes</option>
                            </select>
                            -->
                           </div>
                           <input type="hidden" id="id" name="id_num" value="<?php echo $data['id_num']??''; ?>">
                           <input type="hidden" id="first_name" name="first_name" value="<?php echo $data['first_name']??''; ?>">
                           <input type="hidden" id="last_name" name="last_name" value="<?php echo $data['last_name']??''; ?>">
                           <input type="hidden" id="email" name="email" value="<?php echo $data['email']??''; ?>">
                           <input type="hidden" id="phone" name="phone" value="<?php echo $data['phone']??''; ?>">
                           <div class="col-md-auto">
                            <h6>Debt amount: </h6>
                            <input class="form-control" style="margin-bottom: 15px;" type="text" min=0 max=9999999 maxlength="7"  id="debt_amount"   name="debt_amount" 
                                pattern="[0-9]{0,7}" value="<?php echo $data['debt_amount']??''; ?>" required>     
                           </div>
                           <div class="col-md-auto">
                            <h6>Active surplus: </h6>
                            <div class="mb-3 ">
                            <select class="form-select" size="2" aria-label="size 2 active_surplus" name="active_surplus" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                </select>
                            </div>
                            <!--
                            <select class="form-select" style="margin-bottom: 15px;" aria-label="active_surplus" name="active_surplus" id="active_surplus" required>
                                <option value="0">NO</option>
                                <option value="1">Yes</option>
                            </select>
                            -->
                           </div>
                           <div class="col-md-auto">
                            <h6>Surplus amount: </h6>
                            <input class="form-control" type="text" style="margin-bottom: 15px;" min=0 max=9999999 maxlength="7"  id="surplus_amount"  name="surplus_amount" 
                                pattern="[0-9]{0,7}" value="<?php echo $data['surplus_amount']??''; ?>" required>   
                           </div>
                           <div class="col-md-auto">
                           <h6></h6>
                            <button style="margin-top: 23px;" name="update_payment_btn" type="submit" class="btn btn-outline-primary" >Update payment</button>
                           </div>

                        </div>
        </form>
    </div>

    <div class="container mt-5 border border-primary rounded" style="margin-bottom: 10px;">
            <h2>Client active services</h2>

            <a class="btn btn-outline-primary" style="margin-bottom:15px; margin-top: 15px; margin-right:10px;" href="new_service.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">New service</a>
            <a class="btn btn-outline-primary" style="margin-bottom:15px; margin-top: 15px;" href="#" role="button">Service history</a>


            <table class="table table-striped table-hover">
                
                
                <thead class="table-primary">
                <tr>
                    
                    <th>Service name</th>
                    <th>Creation date</th>
                    <th>Fee</th>
                    <th>Fully paid</th>
                    <th>Paid amount</th>
                    <th>Completion status</th>
                    <th>Completion reason</th>
                    <th>Completion date</th>
                    <th>Desription</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                      if (mysqli_num_rows($result_service) > 0) {
                        $sn=1;
                        while($data_service = mysqli_fetch_assoc($result_service)) {
                       ?>
                           <tr >   <!-- turn each row into a link: onclick="window.location='client_record.php'"-->
                                <td>                      
                                <a href="service_record.php?service_id=<?php echo $data_service['service_id']??''; ?>"><?php echo $data_service['service_name']??''; ?> </a>
                                </td>
                                <td>
                                    <?php echo $data_service['service_creation_date']??'';  ?> 
                                </td>
                                <td><?php echo $data_service['service_fee']??''; ?></td>
                                <td><?php echo $data_service['service_fully_paid']??''; ?></td>
                                <td>
                                    <?php
                                        echo $data_service['paid_amount']??'';
                                    ?>
                                </td>
                                <td><?php echo $data_service['service_completed']??''; ?></td>
                                <td><?php echo $data_service['service_completion_reason']??''; ?></td>
                                <td><?php echo $data_service['service_completion_date']??''; ?></td>
                                <td><?php echo $data_service['service_short_desription']??''; ?></td>
                            </tr>

                    <?php
                         $sn++;}} else { 
                    ?>
                    <tr>
                    <td colspan="8">
                     <?php echo $message_service_not_found; ?>
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>
            </table>



    </div>







</body>


</html>

<?php // free result from memory
mysqli_free_result($result);
mysqli_free_result($result_payment);
// close connection
mysqli_close($con);
 ?>









<?php



}elseif(isset($_POST['id_num_get'])) {
    $id_num_get = $_POST['id_num_get'];  // nn pk unique


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
                        WHERE id_num = '$id_num_get'
                        LIMIT 1";


    $result = mysqli_query($con, $query_get_client);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) < 1) {
        $message_not_found = "No records matching this id number were found.";
    }

    $sql_get_payment = "SELECT `id_num`,
                                `client_name`,
                                CASE
                                    WHEN STRCMP(client_owes, '0') = 0  THEN 'No'
                                    ELSE 'Yes'
                                END as `client_owes`,
                                `debt_amount`,
                                CASE
                                    WHEN STRCMP(client_in_surplus, '0') = 0 THEN 'No'
                                    ELSE 'Yes'
                                END as `client_in_surplus`,

                                `surplus_amount`,
                                `client_email`,
                                `client_phone`
                        FROM `client_payment_balance`
                        WHERE id_num = '$id_num_get'
                        LIMIT 1";

    $result_payment = mysqli_query($con, $sql_get_payment);

    if (mysqli_num_rows($result_payment) < 1) {
        $message_not_found = "No records matching this id number were found.";
    }

    $sql_service = "SELECT 
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
        WHERE `client_id_num` = '$id_num_get' AND service_completed = '0'
        ORDER BY `service_completed`,`service_fee`,`service_creation_date` desc ";

        $result_service = mysqli_query($con, $sql_service );

        if (mysqli_num_rows($result_service) < 1) {
            $message_service_not_found = "No active records matching this id number were found.";
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
                        //$sn=1;
                        //while($data = mysqli_fetch_assoc($result)) {
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
                    //$sn++;}
                    } else { 
                ?>
                    <tr>
                    <td colspan="8">
                    <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_not_found; ?></p> 
                     
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>
            </table>

                
        <a class="btn btn-outline-primary" style="margin-bottom: 15px;" href="update_client_detail.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Update client details</a>
        <a  class="btn btn-outline-danger" style="margin-bottom: 15px;" href="disable_client.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">Disable client</a>


    </div>



    <div class="container mt-5 border border-primary rounded">
        <h2>Client payment balance</h2>
                        
        <table class="table table-borderless">

            <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
            </thead>
            <tbody>
                    <?php
                      if (mysqli_num_rows($result_payment) > 0) {
                        $data = mysqli_fetch_assoc($result_payment) 
                    ?>

                    <tr>
                        <td><h6>Active Debt: </h6>
                            <?php echo $data['client_owes']??''; ?>
                        </td>
                        <td><h6>Debt amount: </h6>
                            <?php echo $data['debt_amount']??''; ?>
                        </td>
                        <td><h6>Active surplus: </h6>
                            <?php echo $data['client_in_surplus']??''; ?>
                        </td>
                        <td><h6>Surplus amount: </h6>
                            <?php echo $data['surplus_amount']??''; ?>
                        </td>
                    </tr>

                    <?php
                        } else { 
                    ?>
                        <tr>
                        <td colspan="8">
                        <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_not_found; ?></p> 
                        </td>
                        <tr>

                        <?php
                        }?>
            </tbody>
        </table>
        
        <h5>Update payment balace</h5>
        <form method="post"  action="update_payment.php" >
                        <div class="row">
                           <div class="col-md-auto">
                            <h6>Active debt: </h6>
                            
                            <div class="mb-3 ">
                            <select class="form-select" size="2" aria-label="size 2 active_debt" name="active_debt" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                </select>
                            </div>
                            <!--
                            <select class="form-select" style="margin-bottom: 15px;" aria-label="active_debt" name="active_debt" id="active_debt" required>                    
                                <option value="0">NO</option>
                                <option value="1">Yes</option>
                            </select>
                            -->
                           </div>
                           <input type="hidden" id="id" name="id_num" value="<?php echo $data['id_num']??''; ?>">
                           <input type="hidden" id="first_name" name="first_name" value="<?php echo $data['first_name']??''; ?>">
                           <input type="hidden" id="last_name" name="last_name" value="<?php echo $data['last_name']??''; ?>">
                           <input type="hidden" id="email" name="email" value="<?php echo $data['email']??''; ?>">
                           <input type="hidden" id="phone" name="phone" value="<?php echo $data['phone']??''; ?>">
                           <div class="col-md-auto">
                            <h6>Debt amount: </h6>
                            <input class="form-control" style="margin-bottom: 15px;" type="text" min=0 max=9999999 maxlength="7"  id="debt_amount"   name="debt_amount" 
                                pattern="[0-9]{0,7}" value="<?php echo $data['debt_amount']??''; ?>" required>     
                           </div>
                           <div class="col-md-auto">
                            <h6>Active surplus: </h6>
                            <div class="mb-3 ">
                            <select class="form-select" size="2" aria-label="size 2 active_surplus" name="active_surplus" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                </select>
                            </div>
                            <!--
                            <select class="form-select" style="margin-bottom: 15px;" aria-label="active_surplus" name="active_surplus" id="active_surplus" required>
                                <option value="0">NO</option>
                                <option value="1">Yes</option>
                            </select>
                            -->
                           </div>
                           <div class="col-md-auto">
                            <h6>Surplus amount: </h6>
                            <input class="form-control" type="text" style="margin-bottom: 15px;" min=0 max=9999999 maxlength="7"  id="surplus_amount"  name="surplus_amount" 
                                pattern="[0-9]{0,7}" value="<?php echo $data['surplus_amount']??''; ?>" required>   
                           </div>
                           <div class="col-md-auto">
                           <h6></h6>
                            <button style="margin-top: 23px;" name="update_payment_btn" type="submit" class="btn btn-outline-primary" >Update payment</button>
                           </div>

                        </div>
        </form>
    </div>

    <div class="container mt-5 border border-primary rounded" style="margin-bottom: 10px;">
            <h2>Client active services</h2>

            <a class="btn btn-outline-primary" style="margin-bottom:15px; margin-top: 15px; margin-right:10px;" href="new_service.php?id_num=<?php echo $data['id_num']??''; ?>" role="button">New service</a>
            <a class="btn btn-outline-primary" style="margin-bottom:15px; margin-top: 15px;" href="#" role="button">Service history</a>


            <table class="table table-striped table-hover">
                
                
                <thead class="table-primary">
                <tr>
                    
                    <th>Service name</th>
                    <th>Creation date</th>
                    <th>Fee</th>
                    <th>Fully paid</th>
                    <th>Paid amount</th>
                    <th>Completion status</th>
                    <th>Completion reason</th>
                    <th>Completion date</th>
                    <th>Desription</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                      if (mysqli_num_rows($result_service) > 0) {
                        $sn=1;
                        while($data_service = mysqli_fetch_assoc($result_service)) {
                       ?>
                           <tr >   <!-- turn each row into a link: onclick="window.location='client_record.php'"-->
                                <td>                      
                                <a href="service_record.php?service_id=<?php echo $data_service['service_id']??''; ?>"><?php echo $data_service['service_name']??''; ?> </a>
                                </td>
                                <td>
                                    <?php echo $data_service['service_creation_date']??'';  ?> 
                                </td>
                                <td><?php echo $data_service['service_fee']??''; ?></td>
                                <td><?php echo $data_service['service_fully_paid']??''; ?></td>
                                <td>
                                    <?php
                                        echo $data_service['paid_amount']??'';
                                    ?>
                                </td>
                                <td><?php echo $data_service['service_completed']??''; ?></td>
                                <td><?php echo $data_service['service_completion_reason']??''; ?></td>
                                <td><?php echo $data_service['service_completion_date']??''; ?></td>
                                <td><?php echo $data_service['service_short_desription']??''; ?></td>
                            </tr>

                    <?php
                         $sn++;}} else { 
                    ?>
                    <tr>
                    <td colspan="8">
                     <?php echo $message_service_not_found; ?>
                     </td>
                     <tr>
                     <?php
                        }?>

                </tbody>
            </table>



    </div>







</body>


</html>

<?php // free result from memory
mysqli_free_result($result);
mysqli_free_result($result_payment);
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
        <h2>Search for a client in the search tab,<br>Select a client from the client list tab,<br>Or select a client from the Archive tab.</h2>
    </div>







</body>


</html>



<?php } ?>





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
