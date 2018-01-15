<?php
//while (ob_get_level())
//ob_end_clean();
//header("Content-Encoding: None", true);
//$str = iconv('UTF-8', 'windows-1252', $str);

require('fpdf.php');


$pdf = new FPDF();


$pdf->addPage();
//$pdf->useTemplate($tplIdx, 40, 120, 110);
//$value="                                                                                                     ΟΛΟΚΛΗΡΩΣΗ ΔΙΠΛΩΜΑΤΙΚΉΣ";
$pdf->Ln();
$pdf->SetFont('times','B',10);
$pdf->Cell(80,20,"                                                                                  OLOKLHRWSH DIPLWMATIKHS");

$connect=mysqli_connect('localhost','root','','operationflashpoint');
 
if($connect->connect_error)
{
		die( 'Failed to connect');
}
//else {echo 'connect worked';}
     //   include ('conectmysql.php');
	

	 $_SESSION['id'] = $_GET["value1"];
	   $title = (int) $_SESSION['id'];
		settype($title, "int");
	//$title=intval($_SESSION['title']);

   	  $_SESSION['id_role'] = $_GET["value2"];
	$title2= $_SESSION['id_role'];
	  $_SESSION['image_f'] = $_GET["value3"];
	$image_f= $_SESSION['image_f'];
	//$image = "img/products/image1.jpg";
	//$image_name=$_FILES['file']['name'];
 //$image=$_FILES['file']['tmp_name'];
  //$file_size = $_FILES['file']['size'];
 //$mime = $_FILES['file']['type'];
 //$image_format = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $sql = "SELECT * FROM thesis WHERE id=$title";
$sql2 = "SELECT * FROM user WHERE id=$title2";
			$result2=$connect->query($sql);
$result3=$connect->query($sql2);
if(mysqli_num_rows($result3)){
	while($row1=$result3->fetch_assoc()){

        $id_role_f=$row1['id'];
        $epitheto_f=$row1['lname'];

}}
if(mysqli_num_rows($result2)){
	while($row1=$result2->fetch_assoc()){
		 $title = $row1['title'];

            $id_role = $row1['teacher_id'];
            $perigrafh = $row1['description'];
            $stoxos = $row1['target'];
            $vathmos = $row1['grade'];
			$upografh=$row1['upografh'];
		$pdf->Ln();
$pdf->Cell(30,7,"TITLE:");
 $pdf->Cell(100,7,$title);
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
 $pdf->Cell(30,7,"ABOUT:");
$pdf->Cell(100,7,$perigrafh); 
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
$pdf->Cell(30,7,"ID PROFFESSOR:");
$pdf->Cell(100,7,$id_role);
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
$pdf->Cell(30,7,"ID STUDENT/S:");
$pdf->Cell(100,7,$id_role_f);
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
$pdf->Cell(30,7,"SURNAME");
$pdf->Ln();
$pdf->Cell(30,7,"STUDENT/S:");
$pdf->Cell(100,7,$epitheto_f);
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
$pdf->Cell(30,7,"GRADE:");
$pdf->Cell(100,7,$vathmos); 
  $pdf->Ln();
 $pdf->Cell(30,7,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
  $pdf->Ln();
//$pdf->Cell(10,15,"----------------------------------------------------------------------------------------------------------------------------------------------------------------------");
$pdf->Ln();
$pdf->Cell(30,7,"        Ypografes Kathigitwn");
$pdf->Ln();
//$logo = file_get_contents($upografh);


$pdf->Cell( 40, 40, $pdf->Image($image_f, $pdf->GetX(), $pdf->GetY(), 60.78), 0, 0, 'L', false );
// Load an image into a variable
//$logo = file_get_contents('logo.jpg');



       
            
			
			
          
		//	require('mem_image.php');
//$pdf->AddPage();

			

//$pdf = new PDF_MemImage();
			

    // Place the image in the pdf document
   //$pdf->MemImage($url, 50, 30,$connect);
}}
$pdf->enablefooter = 'footer1';
$pdf->Output();
 $filename=$title.".pdf";
//Output the document
$dir = "C:/xampp/htdocs/project/"; // full path like C:/xampp/htdocs/file/file/
$pdf->Output($dir.$filename,'F');
//ob_end_flush();
?>