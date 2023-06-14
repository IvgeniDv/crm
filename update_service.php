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
                `service_fully_paid`,
                `paid_amount`,
                `service_completed`,
                `service_completion_reason`,
                `service_completion_date`,
                `service_creation_date`

            FROM services
            WHERE `service_id` = '$service_id' 
            LIMIT 1 ";


    $result = mysqli_query($con, $sql);

    if($result){
        $data =  mysqli_fetch_assoc($result);

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
    


    <div class="container mt-5 border border-primary rounded" style=" margin-bottom: 10px;">
        <h2>Update service details</h2>

                <form method="post"  action="update_service_details.php" >
                    <div class="row" >
                        <div class="col-md-auto">
                            <div class="mb-3">    
                                <h6>Creation date: </h6>    
                                <input class="form-control" type="text"  maxlength="20"  id="service_creation_date" value="<?php echo $data['service_creation_date']??''; ?>"  name="service_creation_date" 
                                pattern="[0-9]{4}[-][0-9]{2}[-][0-9]{2}[ ][0-9]{2}[:][0-9]{2}[:][0-9]{2}" required>        
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <input type="hidden" id="service_id" name="service_id" value="<?php echo $data['service_id']??''; ?>">
              
                            <div class="mb-3">
                                <h6>Service name: </h6>
                                <input class="form-control" type="text" maxlength="50"  id="service_name" 
                                pattern="[A-Za-z0-9 -]{0,50}"  value="<?php echo $data['service_name']??''; ?>" name="service_name">    
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div class="mb-3">    
                                <h6>Service fee: </h6>    
                                <input class="form-control" type="text" min=0 max=1000000 maxlength="7"  id="service_fee" value="<?php echo $data['service_fee']??''; ?>"  name="service_fee" 
                                pattern="[0-9]{0,7}" >        
                            </div>
                        </div>

                        <?php 
                            if($data['service_fully_paid']??'' == '0'){
                        ?>

                            <div class="col-md-auto">
                                <div class="mb-3">
                                <h6>Service fully paid: </h6>
                                <select class="form-select" size="2" aria-label="size 2 service_fully_paid" name="service_fully_paid">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    </select>
                                </div>
                            </div>

                        <?php 
                            }else{
                        ?>
                            <div class="col-md-auto">
                                <div class="mb-3">
                                <h6>Service fully paid: </h6>
                                <select class="form-select" size="2" aria-label="size 2 service_fully_paid" name="service_fully_paid">
                                    <option value="1" selected>Yes</option>
                                    <option value="0" >No</option>
                                    </select>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="col-md-auto">
                            <div class="mb-3">        
                                <h6>Paid amount: </h6>
                                <input class="form-control w-75" type="text" min=0 max=1000000 maxlength="7"  id="paid_amount" value="<?php echo $data['paid_amount']??''; ?>"   name="paid_amount" 
                                pattern="[0-9]{0,7}" >        
                            </div>
                        </div>

                    </div>  


                    <div class="row" >
                    <?php 
                        if($data['service_completed']??'' == '0'){
                    ?>
                        <div class="col-md-auto">
                            <div class="mb-3">
                                <h6>Service completed: </h6>
                                <select class="form-select" size="2" aria-label="size 2 service_completed" name="service_completed">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>


                    <?php }elseif($data['service_completed']??'' == '1'){?>
                        <div class="col-md-auto">
                            <div class="mb-3">
                                <h6>Service completed: </h6>
                                <select class="form-select" size="2" aria-label="size 2 service_completed" name="service_completed">
                                    <option value="1" selected>Yes</option>
                                    <option value="0" >No</option>
                                </select>
                            </div>
                        </div>

                    <?php }else{ ?>
                        <div class="col-md-auto">
                            <div class="mb-3">
                                <h6>Service completed: </h6>
                                <select class="form-select" size="2" aria-label="size 2 service_completed" name="service_completed">
                                    <option value="1" >Yes</option>
                                    <option value="0" >No</option>
                                </select>
                            </div>
                        </div>

                    <?php } ?>

                    <?php 
                        if($data['service_completion_reason']??'' == '0'){
                    ?>
                        <div class="col-md-auto">
                            <div class="mb-3">
                            <h6>Completion reason: </h6>
                            <select class="form-select" size="3" aria-label="size 3 completion_reason" name="completion_reason">
                                <option value="0" selected>Success - fully paid and fully done</option>
                                <option value="1">Client side termination</option>
                                <option value="2">Organisation side termination</option>
                                </select>
                            </div>
                        </div>

                    <?php }elseif(($data['service_completion_reason']??'' == '1')){?>
                        <div class="col-md-auto">
                            <div class="mb-3">
                            <h6>Completion reason: </h6>
                            <select class="form-select" size="3" aria-label="size 3 completion_reason" name="completion_reason">
                                <option value="0" >Success - fully paid and fully done</option>
                                <option value="1" selected>Client side termination</option>
                                <option value="2">Organisation side termination</option>
                                </select>
                            </div>
                        </div>

                    <?php }elseif(($data['service_completion_reason']??'' == '2')){?>

                        <div class="col-md-auto">
                            <div class="mb-3">
                            <h6>Completion reason: </h6>
                            <select class="form-select" size="3" aria-label="size 3 completion_reason" name="completion_reason">
                                <option value="0" >Success - fully paid and fully done</option>
                                <option value="1" >Client side termination</option>
                                <option value="2" selected>Organisation side termination</option>
                                </select>
                            </div>
                        </div>

                    <?php }else{ ?>

                        <div class="col-md-auto">
                            <div class="mb-3">
                            <h6>Completion reason: </h6>
                            <select class="form-select" size="3" aria-label="size 3 completion_reason" name="completion_reason">
                                <option value="0" >Success - fully paid and fully done</option>
                                <option value="1" >Client side termination</option>
                                <option value="2" >Organisation side termination</option>
                                </select>
                            </div>
                        </div>

                        <?php } ?>

                        <div class="col-md-auto">
                            <div class="mb-3">    
                                <h6>Completion date: </h6>    
                                <input class="form-control" type="text"   id="service_completion_date" value="<?php echo $data['service_completion_date']??''; ?>"  name="service_completion_date" 
                                pattern="[0-9]{4}[-][0-9]{2}[-][0-9]{2}[ ][0-9]{2}[:][0-9]{2}[:][0-9]{2}" >        
                            </div>
                        </div>


                    </div>
                        

                    

                        <div class="mb-3">
                                <h6>Short description</h6><br>
                                <textarea class="form-control w-75"  id="short_desription" pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,100}" name="short_desription" maxlength="100" rows="3" cols="100"><?php echo $data['service_short_desription']??''; ?></textarea>
                        </div>

                        <div class="mb-3">
                                <h6>Full description</h6><br>
                                <textarea class="form-control w-75"  id="full_description" pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,10000}" name="full_description" maxlength="10000" rows="13" cols="100"><?php echo $data['service_full_description']??''; ?></textarea>
                        </div>

                        <div class="mb-3">
                                <h6>Comments</h6><br>
                                <textarea class="form-control w-75"  id="comments" name="comments" pattern="[A-Za-z0-9,.*!@#$%&?\:;/ -]{0,200}"  maxlength="200" rows="4" cols="100"><?php echo $data['comments']??''; ?></textarea>
                        </div>
                    
                        <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 20px; margin-bottom: 10px;">Update service</button>
                        <a class="btn btn-outline-primary" style="margin-top: 20px; margin-bottom: 10px;" href="service_record.php?service_id=<?php echo $data['service_id']??''; ?>" role="button">Discard changes</a>
                </form>
                

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
                <input class="form-control " type="text" maxlength="10"  id="password" 
                  placeholder="Password" name="password" pattern="[A-Za-z 0-9]{8,8}" >    
              </div>


              <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 25px;margin-bottom: 25px; ">Log in</button>

        </form>
    </div>








        </body>


        </html>





<?php } ?>
