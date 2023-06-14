<?php  

include("database_connection.php");

session_start();

if(isset($_SESSION["login"] )){

$upld_message_err ="";
$upld_message = "";






if(isset($_POST["submit_file"]) && !empty($_FILES["file_upload"]["name"])){
    $service_id = $_POST['service_id_num'];

    $fileName = $_FILES["file_upload"]["name"];
    $tempname = $_FILES["file_upload"]["tmp_name"];
    $targetFilePath = "uploads/" . $fileName;    
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($tempname, $targetFilePath)){
            // Insert image file name into database
            chmod($targetFilePath , 0755);

            $sql = " INSERT INTO service_attached_files (
                                                        `file_name`,
                                                        `upload_date`,
                                                        `service_id`)
                    VALUES ('$fileName', now(), '$service_id')
                     ";

            $rs = mysqli_query($con, $sql);

            if($rs)
            {
                 $upld_message = "File uploaded successfully";
            }else
            {
                $upld_message_err = "Somthing went wrong while updating the database.<br>The data was not saved.<br>Contact support.";
            }

        }else{
            $upld_message_err = "Somthing went wrong while uploading the file.<br>The data was not saved.<br>Contact support.";
        }
    }else{
        $upld_message_err = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{

    $service_id = $_POST['service_id_num'];
    $upld_message_err = "To upload a file, you must first choose a file.";

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
         .inline{
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
            <a class="nav-link" href="client_record.php">Client record</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payments_list.php" >Payments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active"   href="service_list.php">Services</a>
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
        if( strcmp($upld_message_err, "") !== 0){
            ?>

            <div class="container mt-5 border border-primary rounded">
                <h2 style="font-family: Tahoma; font-size: 15px; color: crimson; margin-top:10px;"><?php  echo  $upld_message_err; ?></h2>
                <br>
            <a class="btn btn-outline-primary" style="margin-bottom: 15px;" href="service_record.php?service_id=<?php echo $service_id ; ?>" role="button">Back to service record</a>
                
            </div>


    <?php }elseif(  strcmp($upld_message, "") !== 0){

        ?> 

        <div class="container mt-5 border border-primary rounded">
        <h2 style="font-family: Tahoma; font-size: 15px; color: rgb(51, 204, 51); margin-top:10px;"><?php  echo  $upld_message; ?></h2>
        <br>
        <a class="btn btn-outline-primary" style="margin-bottom: 15px;" href="service_record.php?service_id=<?php echo $service_id ; ?>" role="button">Back to service record</a>
        </div>

<?php }?>
      







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
