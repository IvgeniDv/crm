

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
                                WHEN STRCMP(client_active, '0') = 0 THEN 'No'
                                ELSE 'Yes'
                            END AS 'client_active',
                            `client_end_date`
                    FROM `client_details`
                    WHERE id_num = '$id_num'
                    LIMIT 1";


$result = mysqli_query($con, $query_get_client);
$data = mysqli_fetch_assoc($result);


if (mysqli_num_rows($result) < 1) {
    $message_err ="No records matching this id number were found.";
    
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
    



      <div class="container mt-5 border border-primary rounded" style="margin-bottom:10px;">
    
    <div class="row">
      <div class="col-sm">
        <h2>Update client details</h2>
      </br>
  
      <form method="post"  action="update_details.php" > <!--  class="was-validated"  -->
  
  
          <div class="row" style="margin: 15px">
  
            <div class="col">
              
              
                <label for="id_num" class="form-label">ID number:</label>        
                <input class="form-control w-75"  type="text" minlength="6" maxlength="9"  id="id_num" 
                  value="<?php echo $data['id_num']??''; ?>" name="id_num" pattern="[0-9]{6,9}"title="Valid id number is needed" readonly>      
             
      
              <div class="mb-3">
                <label for="first_name" class="form-label">First name:</label>
                <input class="form-control w-75" type="text" maxlength="45"  id="first_name" 
                value="<?php echo $data['first_name']??''; ?>" name="first_name" pattern="[A-Za-z ]{0,45}"  title="Name should consist of letters only">    
              </div>
      
             
              <div class="mb-3">        
                  <label for="last_name" class="form-label">Last name:</label>
                  <input class="form-control w-75" type="text" maxlength="45"  id="last_name"  value="<?php echo $data['last_name']??''; ?>" name="last_name" 
                    pattern="[A-Za-z ]{0,45}" title="Last name should consist of letters only">        
              </div>
      
              <div class="mb-3">        
                <label for="age" class="form-label">Age</label>
                <input class="form-control w-75" type="text" min=0 max=120 maxlength="3"  id="age"  value="<?php echo $data['age']??''; ?>" name="age" 
                pattern="[0-9]{0,3}" title="Age is a number between 0 and 119" >        
              </div>
            

              <?php 
                if($data['last_name']??'' == 'Male'){
              ?>
                <div class="mb-3  w-25">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" size="2" aria-label="size 2 gender" name="gender" >
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                    </select>
                </div>


              <?php 
                }else{
              ?>
                  <div class="mb-3  w-25">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" size="2" aria-label="size 2 gender" name="gender" >
                        <option value="Male" >Male</option>
                        <option value="Female" selected>Female</option>
                        </select>
                </div>

              <?php } ?>



              <!--
              <div class="mb-3">        
               <label for="gender" class="form-label">Gender</label>
               <input class="form-control w-75" type="text" maxlength="6"  id="gender"  name="gender" 
               pattern="Female|Male" title="The two genders are: Female or Male">        
              </div>
        -->
              <label for="active" class="form-label">Client active:</label>
              <div class="mb-3  w-25">
              <select class="form-select" size="2" aria-label="size 2 active" name="active" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
                </select>
            </div>
  
              <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_err; ?></p> 
              <button  name="submit_btn" type="submit" class="btn btn-outline-success" style="margin-top: 55px">Update client</button>
              <a name="back"  class="btn btn-outline-primary" style="margin-top: 55px" href="client_Record.php?id_num=<?php echo $data['id_num']??''; ?>" >Discard changes</a>
            </div>
  
            <div class="col">
  
              <div class="mb-3">        
                <label for="city" class="form-label">City:</label>
                <input class="form-control w-75" type="text" maxlength="40"  id="city"  value="<?php echo $data['city']??''; ?>" name="city" 
                pattern="[A-Za-z -]{0,50}" title="Numbers are not allowed in ciy name" >        
              </div>
      
                <div class="mb-3">
                  <label for="street" class="form-label">Street:</label>
                  <input class="form-control w-75" type="text" maxlength="40" id="street"  value="<?php echo $data['street']??''; ?>" name="street" 
                  pattern="[A-Za-z0-9 -]{0,50}" >
                </div>
      
                <div class="mb-3">
                  <label for="house_number" class="form-label">House number:</label>
                  <input class="form-control w-75" type="text"  maxlength="10" id="house_number" value="<?php echo $data['house_num']??''; ?>" name="house_number" 
                  pattern="[A-Za-z0-9 -]{0,10}">
                </div>
      
                <div class="mb-3">
                  <label for="apartment_number" class="form-label">Apartment number:</label>
                  <input class="form-control w-75" type="text" maxlength="10" id="apartment_number"   value="<?php echo $data['aprtmnt_num']??''; ?>" name="apartment_number" 
                  pattern="[A-Za-z0-9]{0,10}">
                </div>
      
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone number:</label>
                  <input class="form-control w-75" type="text"  maxlength="11" id="phone"  value="<?php echo $data['phone']??''; ?>" name="phone" 
                    pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                </div>
      
      
                <div class="mb-3">
                  <label for="another_phone" class="form-label">Another phone:</label>
                  <input class="form-control w-75" type="text"  maxlength="11" id="another_phone" value="<?php echo $data['another_phone']??''; ?>" name="another_phone" 
                    pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                </div>
      
                <div class="mb-3">
                  <label for="email" class="form-label">Email:</label>
                  <input class="form-control w-75" type="text"  maxlength="110" id="email"  value="<?php echo $data['email']??''; ?>" name="email" 
                  pattern="[A-Za-z0-9]{1,50}@[A-Za-z0-9]{1,50}.(co.il|com|ac.il|gov.il|org|ru)" title="Make sure email address is typed correctly">
                </div>
                
            </div>
              
          </div>
  
        </form>
        <br>
        
      </div>
  </div>
  
  
  </body>
  
  
  </html>
  













<?php // free result from memory
mysqli_free_result($result);

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
