<?php

include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){


  if (isset($_POST['id_num'])) { 

    // get the post records by name

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
    $tableName = "client_details";
    $message = "";
    $message_err = "";
    $query_id_num = "SELECT *
                      FROM `$tableName`
                      WHERE id_num = '$id_num'
                      LIMIT 1" ;
    $result = mysqli_query($con, $query_id_num);



  if (mysqli_num_rows($result) > 0) {
    $message_err = "This id number is taken by another client";
  
  }else{
  // database insert SQL code
          $sql = "INSERT INTO client_details
                              (`id_num`,
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
                              `client_active`,
                              `client_end_date`)
                  VALUES ('$id_num', '$first_name', '$last_name', '$age', '$gender', '$city','$street','$house_number', '$apartment_number','$phone','$another_phone','$email', now(), '1', NULL)";

            $sql1 = "INSERT INTO client_payment_balance
                              (`id_num`,
                              `client_name`,
                              `client_owes`,
                              `debt_amount`,
                              `client_in_surplus`,
                              `surplus_amount`,
                              `client_email`,
                              `client_phone`)
                  VALUES('$id_num','$first_name $last_name','0','0','0','0','$email','$phone')";
                  
                
          // insert in database 
          $rs = mysqli_query($con, $sql);
          if($rs)
          {
            $message = "New client created successfully."."<br>"."ID: ".$id_num.", Name:".$first_name." ".$last_name;
          }else
          {
            $message_err = "Somthing went wrong with creating a new client.<br>The data was not saved.<br>Contact support.";
            
          }


          $rs1 =  mysqli_query($con, $sql1);
          if($rs1)
          {
            $message = $message."<br>"."  Paiment balance created successfully.";
          }else
          {
            $message_err = $message_err."<br>"."Somthing went wrong with creating a new Paiment balance.<br>The data was not saved.<br>Contact support.";
            
          }

  }
 

// close connection
mysqli_close($con);



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
            <a class="nav-link active"  href="newClient.php">New client</a>
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



    <div class="container mt-5 border border-primary rounded"  style=" margin-bottom: 10px;">
        
      <div class="row">
        <div class="col-sm">
          <h2>New client</h2>
        </br>

        <form method="post"  action="newClient.php" > <!--  class="was-validated"  -->


            <div class="row" style="margin: 15px">

              <div class="col">
                
                <div class="mb-3 mt-3 border border-danger rounded w-75" style="padding: 10px; ">
                  <p  style="font-family: Tahoma; font-size: 10px; color: crimson;">Mandatory field</p>
                  <label for="id_num" class="form-label">ID number:</label>        
                  <input class="form-control w-85"  type="text" minlength="6" maxlength="9"  id="id_num" 
                    placeholder="Enter a valid id number" name="id_num" pattern="[0-9]{6,9}"title="Valid id number is needed" required>      
                </div>
        
                <div class="mb-3">
                  <label for="first_name" class="form-label">First name:</label>
                  <input class="form-control w-75" type="text" maxlength="45"  id="first_name" 
                    placeholder="First name" name="first_name" pattern="[A-Za-z ]{0,45}"  title="Name should consist of letters only">    
                </div>
        
              
                <div class="mb-3">        
                    <label for="last_name" class="form-label">Last name:</label>
                    <input class="form-control w-75" type="text" maxlength="45"  id="last_name"  placeholder="Last name" name="last_name" 
                      pattern="[A-Za-z ]{0,45}" title="Last name should consist of letters only">        
                </div>
        
                <div class="mb-3">        
                  <label for="age" class="form-label">Age</label>
                  <input class="form-control w-75" type="text" min=0 max=120 maxlength="3"  id="age"  placeholder="Age" name="age" 
                  pattern="[0-9]{0,3}" title="Age is a number between 0 and 119" >        
                </div>

                <div class="mb-3  w-25">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-select" size="2" aria-label="size 2 gender" name="gender" required>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      </select>
                  </div>
              
                <!--
                <div class="mb-3">        
                <label for="gender" class="form-label">Gender</label>
                <input class="form-control w-75" type="text" maxlength="6"  id="gender"  placeholder="Gender" name="gender" 
                pattern="Female|Male" title="The two genders are: Female or Male">        
                </div>
            -->

                <p id="sql_result" style="font-family: Tahoma; font-size: 15px; color: crimson"><?php echo $message_err; ?></p> 
                <p id="sql_result2" style="font-family: Tahoma; font-size: 15px; color: rgb(51, 204, 51)"><?php echo $message; ?></p> 
                <button  name="submit_btn" type="submit" class="btn btn-outline-primary" style="margin-top: 50px">Create new client</button>
              </div>

              <div class="col">

                <div class="mb-3">        
                  <label for="city" class="form-label">City:</label>
                  <input class="form-control w-75" type="text" maxlength="40"  id="city"  placeholder="City" name="city" 
                  pattern="[A-Za-z -]{0,50}" title="Numbers are not allowed in ciy name" >        
                </div>
        
                  <div class="mb-3">
                    <label for="street" class="form-label">Street:</label>
                    <input class="form-control w-75" type="text" maxlength="40" id="street"  placeholder="Street" name="street" 
                    pattern="[A-Za-z0-9 -]{0,50}" >
                  </div>
        
                  <div class="mb-3">
                    <label for="house_number" class="form-label">House number:</label>
                    <input class="form-control w-75" type="text"  maxlength="10" id="house_number" placeholder="House number" name="house_number" 
                    pattern="[A-Za-z0-9 -]{0,10}">
                  </div>
        
                  <div class="mb-3">
                    <label for="apartment_number" class="form-label">Apartment number:</label>
                    <input class="form-control w-75" type="text" maxlength="10" id="apartment_number"   placeholder="Apartment number" name="apartment_number" 
                    pattern="[A-Za-z0-9]{0,10}">
                  </div>
        
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone number:</label>
                    <input class="form-control w-75" type="text"  maxlength="11" id="phone"  placeholder="050-1234567" name="phone" 
                      pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                  </div>
        
        
                  <div class="mb-3">
                    <label for="another_phone" class="form-label">Another phone:</label>
                    <input class="form-control w-75" type="text"  maxlength="11" id="another_phone" placeholder="050-1234567" name="another_phone" 
                      pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                  </div>
        
                  <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input class="form-control w-75" type="text"  maxlength="110" id="email"  placeholder="cat@email.com" name="email" 
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

<?php }else{ ?>

  

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
              

              <div class="container-fluid" role="navigation" style="margin-top: 10px;">
                <ul class="nav nav-tabs"  >  <!--class="nav nav-bar"-->
                  <li class="nav-item">
                    <a class="nav-link active"  href="newClient.php">New client</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="search_client.php">Client search</a>
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

              


            <div class="container mt-5 border border-primary rounded"  style=" margin-bottom: 10px;">
                
              <div class="row">
                <div class="col-sm">
                  <h2>New client</h2>
                </br>

                <form method="post"  action="newClient.php" > <!--  class="was-validated"  -->


                    <div class="row" style="margin: 15px">

                      <div class="col">
                        
                        <div class="mb-3 mt-3 border border-danger rounded w-75" style="padding: 10px; ">
                          <p  style="font-family: Tahoma; font-size: 10px; color: crimson;">Mandatory field</p>
                          <label for="id_num" class="form-label">ID number:</label>        
                          <input class="form-control w-85"  type="text" minlength="6" maxlength="9"  id="id_num" 
                            placeholder="Enter a valid id number" name="id_num" pattern="[0-9]{6,9}" title="Valid id number is needed"  required>      
                        </div>
                
                        <div class="mb-3">
                          <label for="first_name" class="form-label">First name:</label>
                          <input class="form-control w-75" type="text" maxlength="45"  id="first_name" 
                            placeholder="First name" name="first_name" pattern="[A-Za-z ]{0,45}"  title="Name should consist of letters only">    
                        </div>
                
                      
                        <div class="mb-3">        
                            <label for="last_name" class="form-label">Last name:</label>
                            <input class="form-control w-75" type="text" maxlength="45"  id="last_name" placeholder="Last name"  name="last_name" 
                              pattern="[A-Za-z ]{0,45}" title="Last name should consist of letters only">        
                        </div>
                
                        <div class="mb-3">        
                          <label for="age" class="form-label">Age</label>
                          <input class="form-control w-75" type="text" min=0 max=120 maxlength="3"  id="age" placeholder="Age"  name="age" 
                          pattern="[0-9]{0,3}" title="Age is a number between 0 and 119" >        
                        </div>
                      

                        <div class="mb-3  w-25">
                          <label for="gender" class="form-label">Gender</label>
                          <select class="form-select" size="2" aria-label="size 2 gender" name="gender" required>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              </select>
                        </div>
                        <!--
                        <div class="mb-3">        
                        <label for="gender" class="form-label">Gender</label>
                        <input class="form-control w-75" type="text" maxlength="6"  id="gender" placeholder="Gender"  name="gender" 
                        pattern="Female|Male" title="The two genders are: Female or Male">        
                        </div>
                      -->
                        <button  name="submit_btn" type="submit" class="btn btn-outline-primary"  style="margin-top: 30px">Create new client</button>
                      </div>

                      <div class="col">

                        <div class="mb-3">        
                          <label for="city" class="form-label">City:</label>
                          <input class="form-control w-75" type="text" maxlength="40"  id="city" placeholder="City"  name="city" 
                          pattern="[A-Za-z -]{0,50}" title="Numbers are not allowed in ciy name" >        
                        </div>
                
                          <div class="mb-3">
                            <label for="street" class="form-label">Street:</label>
                            <input class="form-control w-75" type="text" maxlength="40" id="street" placeholder="Street"  name="street" 
                            pattern="[A-Za-z0-9 -]{0,50}" >
                          </div>
                
                          <div class="mb-3">
                            <label for="house_number" class="form-label">House number:</label>
                            <input class="form-control w-75" type="text"  maxlength="10" id="house_number" placeholder="House number"  name="house_number" 
                            pattern="[A-Za-z0-9 -]{0,10}">
                          </div>
                
                          <div class="mb-3">
                            <label for="apartment_number" class="form-label">Apartment number:</label>
                            <input class="form-control w-75" type="text" maxlength="10" id="apartment_number" placeholder="Apartment number"   name="apartment_number" 
                            pattern="[A-Za-z0-9]{0,10}">
                          </div>
                
                          <div class="mb-3">
                            <label for="phone" class="form-label">Phone number:</label>
                            <input class="form-control w-75" type="text"  maxlength="11" id="phone" placeholder="050-1234567"  name="phone" 
                              pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                          </div>
                
                
                          <div class="mb-3">
                            <label for="another_phone" class="form-label">Another phone:</label>
                            <input class="form-control w-75" type="text"  maxlength="11" id="another_phone" placeholder="050-1234567"  name="another_phone" 
                              pattern="([0][5,7][0-9][-]?[0-9]{7})?" title="Mobile phone number. including prefix.">
                          </div>
                
                          <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input class="form-control w-75" type="text"  maxlength="110" id="email" placeholder="cat@email.com"  name="email" 
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







<?php
}

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
