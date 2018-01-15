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
   <b> ΣΤΕΙΛΕ ΤΟ PDF ΤΗΣ ΔΙΠΛΩΜΑΤΙΚΗΣ ΣΤΗΝ ΓΡΑΜΜΑΤΕΙΑ</b>
<?php
if (isset($_POST['namep']) && isset($_POST['path'])) {
    $adress='icsd16164@icsd.aegean.gr';//einai ths grammateias
    $send=$_POST['namep'];
    $path=$_POST['path'];

    echo "<p><a href='mail.php?  value1=$adress&value2=$send&value3=$path'>Αποστολή του pdf στην γραμματεία </a>";


}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['upload'])) {


    $selected_thesis =$_POST['selected-thesis'];
    $title=$selected_thesis;
    $user_id =$_POST['user_id'];
    $user_id=$user_id;
    echo"<br>user_id:". $user_id."id thesis: ".$title;
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
    $image_name = addslashes($_FILES['image']['name']);
    $mime = mysqli_real_escape_string($link, $_FILES['image']['type']);
    //getimagesize($_FILES["fileToUpload"]["tmp_name"]
    echo "<br> name:" . $image_name;
    //$image_dir='C:/xampp/htdocs/project/';

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $_FILES['image']['name']);
    $image_f = $target_dir . $_FILES['image']['name'];
    echo "<br>path file : " . $image_f;
    //$number = mysqli_real_escape_string($link, $_POST['textfield']);
    if (substr($mime, 0, 5) == 'image') {


        //  $adress="icsd16164@icsd.aegean.gr";
        // echo "<img src="data:image/png;base64,'.base64_encode($row['image']).'">"
        echo '<br>Η Εικόνα ανέβηκε στην βάση!<br>';

        echo "<p><a href='create_pdf.php?  value1=$title&value2=$user_id&value3=$image_f'>Δημιουργία pdf με τα στοιχεια της διπλωματικής και τις υπογραφές για αποστολή(δεξι κλικ) </a>";
        echo "<br>Κατέβασε το pdf και δώσε το ονομα(π.χ. test.pdf) και το path(π.χ.C:/xampp/htdocs/project/test.pdf) που το αποθηκευσες";
    }
    else {
        echo 'its not an image<br>';
    }

    ?>
    <form role="form" action="grammateia.php" method="POST" enctype="multipart/form-data">


        <br>

        Όνομα PDF:
        <input type="text" name="namep">
        <br>

        Path :
        <input type="text" name="path">
        <br>

        <input type="submit" id="submit" name="submit" value="Αποθήκευση">

    </form>
    <?php
}

if (isset($_POST['list'])) {

    $user_id=$_SESSION['user_id'];
   // echo"id:user :".$user_id;
    $s="SELECT * FROM thesis WHERE teacher_id=$user_id AND state=5" ;
    $result1=$link->query($s);
    echo "<table  border='3' width='70%'>";
     //   echo "<tr><th>Έγκριση/Επεξεργασία</th> <th>Τίτλος </th>  <th> Στόχος </th> <th> Επιβλέπων Καθηγητής </th> <th> Περιγραφή </th> <th> Προαπαιτούμενα Μαθήματα </th> <th> Αριθμός Φοιτητών </th> <th> Απαραίτητες Γνώσεις </th> <th> icsd φοιτητή </th> <th> Βαθμός </th> </tr>" ;
        if(mysqli_query($link,$s)){

            while($row1=$result1->fetch_assoc()){
                $title=$row1['id'];

                echo "<tr><th>Τίτλος </th>  <th> Περιγραφή </th>  <th> Βαθμός </th> <th> Στάδιο Κατάστασης</th> </tr>" ;
                echo "<tr><td>" .$row1['title']. "</td><td>" . $row1['description'] . "</td><td>". $row1['grade'] . "</td><td>" . $row1['state'] . "</td>";
echo'<p> <form action="grammateia.php" method="post" enctype="multipart/form-data">';
                echo'<input type="hidden" id="selected-thesis" name="selected-thesis" value='.$title.'>';

                   echo'<td><button type="submit" name="thesisi" class="btn btn-danger">Στείλε στην Γραμματεία!</button></td></tr>';
              echo'</form>';




            }

        }



        }

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['thesisi'])) {

$selected_thesis =$_POST['selected-thesis'];
   // $_SESSION['title'] = $_GET["value"];

//$_SESSION['title']  = $_POST['thesis_id'];
$title=$selected_thesis;
    echo "<br>id thesis :" . $title;
?>


    <br>
    Ανέβασε τις υπογραφές των καθηγητών:
    <div id="content">
        <form method="post" action="grammateia.php" enctype="multipart/form-data">
            <?php
            echo'<input type="hidden" name="size" value="1000000"/>';
            echo'<div>';
            echo'<input type="file" name="image"/>';
            echo'</div>';


               $user_id=$_SESSION['user_id'];

                echo'<input type="hidden" id="user_id" name="user_id" value='.$user_id.';>';
                echo'<input type="hidden" id="selected-thesis" name="selected-thesis" value='.$title.';>';
                echo'<input type="submit" name="upload" value="upload image">';
            echo'</div>';
            ?>
        </form>
        <?php
        }
      ?>
        <form method="post" action="grammateia.php">
        <input type="submit" name="list" value="Ολoκληρωμένες Διπλωματικές" >
        </form>
</div>

</body>
</html>