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

<?php
include_once "page_parts/login_checker.php";
?>
<div class="page_content">
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['upload'])) {
    echo"<br> id:".$_SESSION['user_id'];


    // TODO send mail to teacher
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
    $image_name = addslashes($_FILES['image']['name']);
    $mime = mysqli_real_escape_string($link, $_FILES['image']['type']);

    echo "<br> name:" . $image_name;


    $target_dir = "C:/Users/User/Desktop/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
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


    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir. $_FILES['image']['name']);
    $image_f = $target_dir. $_FILES['image']['name'];
    echo"<br>path file : ".$image_f  ;
    $_SESSION['path']=$image_f;
    echo ' <input type="hidden" id="path" name="path" value=".$path.">';
}
    if (isset($_POST['message']) &&isset($_POST['name1']) && isset($_POST['name2'])&&isset($_POST['name3'])) {



        $path=  $_SESSION['path'];

        $send="O foithths me id :".$_SESSION['user_id']. ",stelnei to ekshs: <br> ";
        $message=$send." ".$_POST['message'];
        echo"<br>To μηνυμα που θα σταλεί είναι το εξής: '". $message."'";
        $adress=$_POST['name1'];
        echo "<p><a href='mail.php?value1=$adress&value2=$message&value3=$path'>Αποστολή του αρχειου στον καθγητή </a>";
        $adress=$_POST['name2'];
        echo "<p><a href='mail.php?value1=$adress&value2=$message&value3=$path'>Αποστολή στον πρωτο συμφοιτητή </a>";
        $adress=$_POST['name3'];

        echo "<p><a href='mail.php?value1=$adress&value2=$message&value3=$path'>Αποστολή στον δεύτερο συμφοιτητή </a>";



    }
   ?>



    <?php
    echo '<form action="" method="post" enctype="multipart/form-data">';

    echo '<input type="hidden" name="size" value="1000000" />';
    echo ' <input type="file" name="image" />';
    echo '<button type="submit" name="upload" class="btn btn-primary">Upload FILE</button>';

    echo '</form>';


echo'<form role="form" action="student_send_files.php" method="POST" enctype="multipart/form-data">';
        echo'Γράψε το μήνυμα που θέλεις να στείλεις :';
        echo' <input type="longtext" name="message">';
        echo' <br>';

        echo'Mail Καθηγητή:';
        echo'<input type="text" name="name1">';
        echo'<br>';

        echo'Mail Συμφοιτητή:';
        echo'<input type="text" name="name2">';
        echo'<br>';

        echo'Mail Συμφοιτητή:';
        echo'<input type="text" name="name3">';
        echo'<br>';
        echo' <input type="submit" id="submit" name="msg" value="Αποθήκευση">';

echo'</form>';
?>

</div>

</body>
</html>