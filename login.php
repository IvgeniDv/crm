<?php

include("database_connection.php");

// Start the session
session_start();


//$_SESSION["login"] = "cat";


$login =  $_POST['user_name']; 
$pass = $_POST['password']; 

$sql = "SELECT *
        FROM users
        WHERE 
            user_name LIKE '$login'
            AND pass LIKE '$pass'
        ";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {

  $_SESSION["login"] = "ok";

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
        <a class="nav-link" href="newClient.php">New client</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="search_client.php">Client search</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="client_record.php">Client record</a>
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
    
    
        <h2>Search for a client</h2>

        <form method="post"  action="search_client.php" > 
                <div class="row">
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">
                        <label for="id_num_search" class="form-label">ID number:</label>        
                        <input class="form-control w-85"  type="text" minlength="6" maxlength="9"  id="id_num_search" 
                            placeholder="Enter a valid id number" name="id_num_search" pattern="[0-9]{6,9}" title="Valid id number is needed">
                    </div>
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">
                        <label for="first_name_search" class="form-label">First name:</label>
                        <input class="form-control w-85" type="text" maxlength="45"  id="first_name_search" 
                            placeholder="First name" name="first_name_search" pattern="[A-Za-z]{0,45}"  title="Name should consist of letters only">    
                    </div>
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">        
                        <label for="last_name_search" class="form-label" >Last name:</label>
                        <input class="form-control w-85" type="text" maxlength="45"  id="last_name_search" placeholder="Last name"  name="last_name_search" 
                          pattern="[A-Za-z]{0,45}" title="Last name should consist of letters only">        
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">        
                        <label for="city_search" class="form-label">City:</label>
                        <input class="form-control w-85" type="text" maxlength="40"  id="city_search" placeholder="City"  name="city_search" 
                        pattern="[A-Za-z -]{0,50}" title="Numbers are not allowed in ciy name" >        
                    </div>
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">
                        <label for="street_search" class="form-label">Street:</label>
                        <input class="form-control w-85" type="text" maxlength="40" id="street_search" placeholder="Street"  name="street_search" 
                        pattern="[A-Za-z0-9 -]{0,50}" >
                    </div>
                    <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">
                        <label for="phone_search" class="form-label">Phone number:</label>
                        <input class="form-control w-85" type="text"  maxlength="11" id="phone_search" placeholder="050-1234567"  name="phone_search" 
                          pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                    </div>
                
                </div>
                
                <button  name="search_client_btn" type="submit" class="btn btn-outline-primary"  style="margin-top:15px; margin-bottom: 15px;">Search for client</button>
        </form>
</div>


<div class="container mt-5 border border-primary rounded" style="margin-bottom: 10px; ">
    
    
    <h2>I know whom im looking for</h2>

    <form method="post"  action="client_record.php" > 
            <div class="row">
                <div class="col-sm-3 mb-3 mt-3" style="margin-right: 20px;">
                    <label for="id_num_get" class="form-label">ID number:</label>        
                    <input class="form-control w-85"  type="text" minlength="6" maxlength="9"  id="id_num_get" 
                        placeholder="Enter a valid id number" name="id_num_get" pattern="[0-9]{6,9}" title="Valid id number is needed">
                        
                    </div>        
                
            </div>     
            <button  name="open_client_btn" type="submit" class="btn btn-outline-primary"  style="margin-top:15px; margin-bottom: 15px;">Open record</button>
    </form>
</div>





</body>


</html>




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
        <h2>Not valid credentials</h2>
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
