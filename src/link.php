<?php
$connect=new mysqli('localhost','root','','operationflashpoint');

if($connect->connect_error)
{
		die( 'Failed to connect');
}
else 
	echo 'connect worked ';

session_start();
  $_SESSION['token'] = $_GET["token"];
	$id_role= $_SESSION['token'];
?>

<html>

 <head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<div class="container">
<form name="myLetters" action="" method="POST">
Επέλεξε την απόφασή σου:
<br>
<input type="radio" name="letter" value="Έγκριση" />  Έγκριση
<br>
<input type="radio" name="letter" value="Απόρριψη" /> Απόρριψη
<br>

<input type="submit" name="submit2" value="Αποθήκευση!" />
</form>
<br>

<body>
</body>
</html>
<?php
$id_role= $_SESSION['token'];
if (isset($_POST['submit2'])) {
    $leksh = $_POST['letter'];
    echo "<br>id καθηγητή: $id_role";
    echo "<br> Κατάσταση  : $leksh";
    if (strpos("x" . $leksh, 'Έγκριση') == true) {

        $send = "Egkrithike h aithsh sthn epitroph apo to ena melos";
    } else {
        $send = "DEN Egkrithike h aithsh sthn epitroph apo to ena melos";}
        $s = "SELECT * FROM user WHERE id=$id_role";
        $resul = $connect->query($s);

        if (mysqli_query($connect, $s)) {

            while ($row1 = $resul->fetch_assoc()) {
                $adress = $row1['email'];
                echo "<br>  διεύθυνση καθηγητή :" . $adress;

                echo "<p><a href='mail.php?  value1=$adress&value2=$send'>Στείλε το mail με την απόφασή σου στον ενδιαφερόμενο καθηγητή </a>";
            }
        }


}
?>