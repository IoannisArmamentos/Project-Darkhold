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
    <h3>Αιτήσεις φοιτητών</h3>
    <br>
    <table class="table">
        <?php


        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['present'])) {

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            $selected_student = mysqli_real_escape_string($link, $_POST['user-id']);

            // TODO change this to alter thesis state to 4 presnt
            // TODO ADD DATES GOD DAMN IT!!!!!!!!!

            update_thesis_application_state($link, 2, $selected_thesis, $selected_student);
            change_thesis_state($link, $selected_thesis, 4);


        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['grade'])) {

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            $selected_student = mysqli_real_escape_string($link, $_POST['user-id']);
            $selected_grade = mysqli_real_escape_string($link, $_POST['grade-value']);

            // TODO change this to alter thesis state to 5 complete
            // TODO ADD DATES GOD DAMN IT!!!!!!!!!
            update_thesis_application_state($link, 3, $selected_thesis, $selected_student);
            change_thesis_state($link, $selected_thesis, 5);
            set_grade_to_thesis($link, $selected_thesis, $selected_grade);

            //TODO PDF UPDATE


            if (isset($_POST['namep']) && isset($_POST['path'])) {
                $adress = 'icsd16164@icsd.aegean.gr';//einai ths grammateias
                $send = $_POST['namep'];
                $path = $_POST['path'];

                echo "<p><a href='mail.php?  value1=$adress&value2=$send&value3=$path'>Αποστολή του pdf στην γρμματεία </a>";


            }


            if (isset($_POST['upload'])) {

                $title = $selected_thesis;
                $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
                $image_name = addslashes($_FILES['image']['name']);
                $mime = mysqli_real_escape_string($connect, $_FILES['image']['type']);
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
                //$number = mysqli_real_escape_string($connect, $_POST['textfield']);
                if (substr($mime, 0, 5) == 'image') {
                    if (mysqli_query($connect, ("UPDATE operationflashpoint SET upografh='$image' WHERE id=$title"))) ;
                    {
                        //  $adress="icsd16164@icsd.aegean.gr";
                        // echo "<img src="data:image/png;base64,'.base64_encode($row['image']).'">"
                        echo '<br>Η Εικόνα ανέβηκε στην βάση!<br>';

                        echo "<p><a href='create_pdf.php?  value1=$title&value2=$user_id&value3=$image_f'>Δημιουργία pdf με τα στοιχεια της διπλωματικής και τις υπογραφές για αποστολή(δεξι κλικ) </a>";
                        echo "<br>Κατέβασε το pdf και δώσε το ονομα(π.χ. test.php) και το path(π.χ.C:/xampp/htdocs/project/test.pdf) που το αποθηκευσες";
                        ?>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">


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
                        echo "<br>" . $msg;
                    }
                } else {
                    echo 'its not an image<br>';
                }
            }

            ?>

            <?php


        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['apply'])) {

            $selected_thesis = mysqli_real_escape_string($link, $_POST['selected-thesis']);
            $selected_student = mysqli_real_escape_string($link, $_POST['user-id']);

            // TODO number of student = ατομα τα οποια εχει αναθεσει ο καθηγητης σε μια συγκεκριμένη διπλωματικη
            // TODO thesis_number_of_student = μεγιστο αριθμο ατόμων για μια  συγκεκριμενη διπλωματικη

            $thesis_number_of_student = get_approved_users_for_thesis($link, $selected_thesis);
            $number_of_student = get_thesis_applicants($link, $selected_thesis);

            // showAlertDialogMethod("i am in");
            if ($number_of_student < $thesis_number_of_student) {
                //showAlertDialogMethod("i am in");
                $full_thesis = get_thesis_by_id($link, $selected_thesis);

                update_thesis_application_state($link, 1, $selected_thesis, $selected_student);
                change_thesis_state($link, $selected_thesis, 3);
                $user = get_user_by_id($link, $selected_student);
                while ($row = $full_thesis->fetch_assoc()) {
                    // send_mail_to_user($user->email, "Η αίτηση σας για " . $row['title'] . " έγινε αποδεκτή ");
                }
            } else {
                showAlertDialogMethod("Δεν μπορεις να αναθέσεις την διπλωματική σε παραπάνω άτομα");
            }
        }

        $all_thesis = get_thesis_for_teacher_that_students_applied_for($link, $_SESSION['user_id']);
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
            echo '<td><h4>Ημερομηνία δημοσίευσης</h4></td>';
            echo '<td><h4>Φοιτητής</h4></td>';
            echo '<td><h4>Ανάθεση</h4></td>';
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
                echo '<h5 id="align_start" style="">' . $row['publication_date'] . '</h5>';
                //showAlertDialogMethod($row['publication_date'] . "//");
                echo '</td>';
                echo '<td>';
                echo '<h5 id="align_start" style="">' . get_full_student_name_for_thesis($link, $row['user_id']) . '</h5>';
                echo '</td>';
                if ($row['state'] == 2) {
                    echo '<td>';
                    echo '<form action="view_thesis_applies.php" method="post" enctype="multipart/form-data">';
                    echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo '<input type="hidden" id="user-id" name="user-id" value="' . $row['user_id'] . '">';
                    echo '<button type="submit" name="apply" class="btn btn-primary">Ανάθεση</button>';
                    echo '</form>';
                    echo '</td>';
                    // showAlertDialogMethod( $row['title'] ." I am 2");
                } else if ($row['state'] == 3) {
                    echo '<td>';
                    echo '<form action="view_thesis_applies.php" method="post" enctype="multipart/form-data">';
                    echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo '<input type="hidden" id="user-id" name="user-id" value="' . $row['user_id'] . '">';
                    echo '<button type="submit" name="present" class="btn btn-warning">Παρουσίαση</button>';
                    echo '</form>';
                    echo '</td>';
                } else if ($row['state'] == 4) {
                    echo '<td>';
                    echo '<form action="view_thesis_applies.php" method="post" enctype="multipart/form-data">';
                    echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo '<input type="hidden" id="user-id" name="user-id" value="' . $row['user_id'] . '">';
                    echo '<label for="grade-value">Bαθμός</label>';
                    echo '<input required="required" type="number" id="grade-value" name="grade-value" value="">';
                    echo '<button type="submit" name="grade" class="btn btn-danger">Ολοκλήρωση</button>';
                    echo '</form>';
                    echo '</td>';
                } else if ($row['state'] == 5) {
                    echo '<td>';
                    echo '<form action="view_thesis_applies.php" method="post" enctype="multipart/form-data">';
                    echo '<input type="hidden" id="selected-thesis" name="selected-thesis" value="' . $row['id'] . '">';
                    echo '<input type="hidden" id="user-id" name="user-id" value="' . $row['user_id'] . '">';
                    echo '<label for="grade-value">Ανέβασε τις υπογραφές των καθηγητών:</label>';
                    echo '<input type="file" name="image"/>';
                    echo '<button type="submit" name="upload" class="btn btn-danger">Send PDF</button>';
                    echo '</form>';
                    echo '</td>';
                }
                echo '</tr>';
            }

        }
        ?>
    </table>
</div>

</body>
</html>