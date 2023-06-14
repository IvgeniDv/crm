<?php 
include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$sql = "SELECT
            `id_num`,
            `client_name`,
            CASE
                WHEN STRCMP(client_owes, '0') = 0 THEN 'No'
                ELSE 'Yes'
            END AS `client_owes`,
            `debt_amount`,
            CASE
                WHEN STRCMP(client_in_surplus, '0') = 0 THEN 'No'
                ELSE 'Yes'
            END AS `client_in_surplus`,   
            `surplus_amount`,
            `client_email`,
            `client_phone`
        FROM `client_payment_balance`
        ORDER BY `debt_amount` desc ";



$result = mysqli_query($con, $sql);
$message_err ="Couldn't find clients in databse.<br>Contact support.";



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
            <a class="nav-link" href="client_record.php">Client record</a>
          </li>
      <li class="nav-item">
        <a class="nav-link active" href="#" >Payments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"   href="service_list.php">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"   href="existing _client.php">Client list</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="archive_list.php">Archive</a>
      </li>
    </ul>
  </div>



<div class="container mt-5 mb-5 border border-primary rounded ">
    
            <h2>Payment status</h2>
            </br>
        
            <table class="table table-striped table-hover">
                
                
                <thead class="table-primary">
                <tr>
                    <th>Id number</th>
                    <th>Name</th>
                    <th>Active Debt</th>
                    <th>Debt amount</th>
                    <th>Active surplus</th>
                    <th>Surplus amount</th>
                    <th>Contact info</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                      if (mysqli_num_rows($result) > 0) {
                        $sn=1;
                        while($data = mysqli_fetch_assoc($result)) {
                       ?>
                           <tr >   <!-- turn each row into a link: onclick="window.location='client_record.php'"-->
                                <td>                      
                                <a href="client_record.php?id_num=<?php echo $data['id_num'] ?>"> <?php echo $data['id_num']??''; ?> </a>
                                </td>
                                <td>
                                    <?php echo $data['client_name']??'';  ?> 
                                </td>
                                <td><?php echo $data['client_owes']??''; ?></td>
                                <td><?php echo $data['debt_amount']??''; ?></td>
                                <td><?php echo $data['client_in_surplus']??''; ?></td>
                                <td><?php echo $data['surplus_amount']??''; ?></td>
                                <td>
                                    <?php
                                        echo $data['client_email']??'';
                                        echo " ";
                                        echo $data['client_phone']??'';
                                    ?>
                                </td>
                            </tr>

                    <?php
                         $sn++;}} else { 
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
