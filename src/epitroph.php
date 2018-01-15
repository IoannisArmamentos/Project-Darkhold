<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>
</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>




<div class="page_content">
<form action="epitroph.php" method="post">
<br>
    <input type="submit" id="submit6" name="submit6" value="Στείλε αίτηση αποδοχής ένταξης στην τριμελή επιτροπή">
	
</form>





<?php
$connect=new mysqli('localhost','root','','project');
 
if($connect->connect_error)
{
		die( 'Failed to connect');
}
else 
	echo 'connect worked ';


	$id_role= $_SESSION['user_id'];
	echo'id: '.$id_role;
if (isset($_POST['name1']) && isset($_POST['name2'])&&isset($_POST['name3'])) {
	//	$adress='icsd16164@icsd.aegean.gr';//einai ths grammateias
	
	$token=$id_role;
	$adress=$_POST['name1'];
$send="O kathigiths me id :".$id_role. " kanei aithsh apodoxhs sthn epitroph .Apanthste edw: http://localhost/project/link.php?%20token=$token";
echo"<br>To μηνυμα που θα σταλεί είναι το εξής: '".$send."'";
echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
  	$adress=$_POST['name2'];
echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
 	$adress=$_POST['name3'];

echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Αποστολή του link για την αποδοχή στο Πρώτο μέλος </a>";
 
	echo "<p><a href='kathigitis.php?  value1=$id_role'Αρχική </a>";
  }
if(isset($_POST['submit6']))
{   
 ?>

 <form role="form" action="" method="POST" enctype="multipart/form-data">


        <br>
      
        Mail Πρώτου Μέλους:
        <input type="text" name="name1">
        <br>
     
           Mail Δεύτερου Μέλους:
        <input type="text" name="name2">
        <br>
	   
           Mail Τρίτου Μέλους:
        <input type="text" name="name3">
        <br>
 <input type="submit" id="submit" name="submit" value="Αποθήκευση">
 </form>  
<?php
 }  
 ?>
</div>
</body>
</html>
