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

    <form action="search_thesis.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="keyword">Αναζήτηση δηπλωματικών:</label>
            <input required="required" type="text" class="form-control" id="keyword" name="keyword"
                   placeholder="Όνομα καθηγητή, λέξεις κλειδία χωρισμένα με κενό">
        </div>
        <center>
            <button type="submit" name="search" class="btn btn-primary">Αναζήτηση</button>
        </center>
    </form>
    <br>
    <br>
    <table class="table">
        <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['apply'])) {
            echo"<br> id:".$_SESSION['user_id'];

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            //showAlertDialogMethod("selected thesis id" . $selected_thesis);

            insert_thesis_apply_for_student($link, $selected_thesis, $_SESSION['user_id']);

            change_thesis_state($link, $selected_thesis, 2);



        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['upload'])) {
            echo"<br> id:".$_SESSION['user_id'];

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            //showAlertDialogMethod("selected thesis id" . $selected_thesis);

            insert_thesis_apply_for_student($link, $selected_thesis, $_SESSION['user_id']);

            change_thesis_state($link, $selected_thesis, 2);

            // TODO Teacher id
            $selected_teacher_id = mysqli_real_escape_string($link, $_POST['selected-teacher-id']);

            showAlertDialogMethod($selected_teacher_id);

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
            $thesis= $_POST['selected-thesis'];
            echo'<br>iddd'.$thesis;
        $s="SELECT * FROM thesis WHERE id=$thesis" ;
        $result1=$link->query($s);

        if(mysqli_query($link,$s)) {

            while ($row1 = $result1->fetch_assoc()) {
                $id_t = $row1['teacher_id'];
            }
        }
        echo"<br>nah".$id_t;
            $s="SELECT * FROM user WHERE id=$id_t" ;
            $result1=$link->query($s);

            if(mysqli_query($link,$s)) {

                while ($row1 = $result1->fetch_assoc()) {
                    $email = $row1['email'];
                }
            }
            $address= $email;
        $path=$image_f; 
//        $address= (get_user_by_id($link,$selected_teacher_id))->email;
//        $path=$image_f;
        $message="uparxei aithsh egdhlwshs endiaferontos gia diplwmatikh apo foithth mpeite sto susthma me tis diplwmatikes";
        send_mail_to_user($address,$message,$path);
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {

            
            $keyword = mysqli_real_escape_string($link, $_POST['keyword']);


            $all_thesis = get_thesis_with_keywords($link, $keyword);

            if ($all_thesis == null) {

                echo '<h5>Δεν βρέθηκαν αποτελέσματα</h5>';


            } else {
                echo ' <tr>';
                echo '<td><h4>Τίτλος</h4></td>';
                echo '<td><h4>Περιγραφή</h4></td>';
                echo '<td><h4>Στόχος</h4></td>';
                echo '<td><h4>Αριθμός μαθητών</h4></td>';
                echo '<td><h4>Προαπαιτούμενες γνώσεις</h4></td>';
                echo '<td><h4>Προαπαιτούμενες μαθήματα</h4></td>';
                echo '<td><h4>Καθηγητής</h4></td>';
                echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
                echo '</tr>';
                while ($row = $all_thesis->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['title'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['description'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['target'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['student_number'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['student_knowledge'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . get_lesson_names_as_string_for_thesis($link, $row['id']) . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . get_full_teacher_name_for_thesis($link, $row['id']) . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form action="search_thesis.php" method="post" enctype="multipart/form-data">';
                    echo ' <input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo ' <input type="hidden" id="selected-teacher-id" name="selected-teacher-id" value="' . $row['teacher_id'] . '">';
                    echo '<input type="hidden" name="size" value="1000000" />';
                    echo ' <input type="file" name="image" />';
                    echo '<button type="submit" name="upload" class="btn btn-primary">Upload CV</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
        ?>
    </table>
</div>

</body>
</html>

