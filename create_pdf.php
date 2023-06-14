<?php 
include("database_connection.php");
//ob_end_clean();
require('fpdf.php');
  

$message = "";
$message_err = "";





$service_id = $_POST['service_id'];



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

                
        class PDF extends FPDF {
                
            // Page header
            function Header() {
                
                // Add logo to page
                $this->Image('images/cat_banner.jpg',10,10,50);
                
                // Set font family to Arial bold 
                $this->SetFont('Arial','B',20);
               
                
            
                
                // Header
            //  $this->Cell(50,10,'Service PDF example',1,0,'C');
                
                // Line break
                $this->Ln(20);
            }

            // Page footer
            function Footer() {
                
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                
                // Arial italic 8
                
                
                // Page number
                $this->Cell(0,10,'Page ' . 
                    $this->PageNo() . '/{nb}',0,0,'C');
            }
        }


                // Instantiation of FPDF class
                $pdf = new PDF();
                
                // Define alias for number of pages
                $pdf->AliasNbPages();
                $pdf->AddPage();
                // Set the font for the text
            
                // Prints a cell with given text 
                
                $pdf->SetFont('Arial','B',20);
                $pdf->Cell(0,10,$data['service_name'],0,0,'C');
                $pdf->Ln(10);
                $pdf->Ln(10);

                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(0,10,'Client details',0,0,'L');

                $pdf->Ln(10);

                $pdf->SetFont('Arial','',11);
                $pdf->MultiCell(0,5,'Id: '.$data['client_id_num']."     Name:".$data['client_first_name']." ".$data['client_last_name']);

                $pdf->Ln(10);
                $pdf->Ln(10);

                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(0,10,'Short description',0,0,'L');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',11);
                $pdf->MultiCell(0,5,$data['service_short_desription']);

                $pdf->Ln(10);


                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(0,10,'Elaborated description',0,0,'L');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',11);
                $pdf->MultiCell(0,5,$data['service_full_description']);

                $pdf->Ln(10);


                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(0,10,'Comments',0,0,'L');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',11);
                $pdf->MultiCell(0,5,$data['comments']);
                $pdf->Ln(10);





                $pdf->Cell(0,10,'__________________________________________________________________',0,0,'L');
                $pdf->Ln(5);
                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(40,10,"Service fee: ".$data['service_fee']."Nis.",0,0,'L');


                $pdf->Ln(10);
                $pdf->Ln(10);
                $pdf->Cell(40,10,'Thank you.',0,0,'L');

                $pdf->Ln(10);
                $pdf->Ln(10);
        // return the generated output
                $pdf->Output();





    }else{
        $message_err ="Can't find service in database. Contact support.";
    }


    

  



?>











<?php 
// close connection
mysqli_close($con);
 ?>