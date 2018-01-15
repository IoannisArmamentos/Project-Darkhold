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

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {

    $randomPassword = $_SESSION['confirmation_code'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    //showAlertDialogMethod($fname . $lname . "<");

    $emailPass = mysqli_real_escape_string($link, $_POST['emailPass']);
    $role = mysqli_real_escape_string($link, $_POST['role']);
    $math = mysqli_real_escape_string($link, $_POST['math']);
    //showAlertDialogMethod($emailPass . "< " . $role . " " . $math . "-" . intval($math) . "-" . $_SESSION['math_eval']);
    if (empty($emailPass) || empty($math)) {
        showAlertDialogMethod("Συμπληρωστε όλα τα πεδία");
    }

    if (isset($_SESSION['confirmation_code']) && !empty($_SESSION['confirmation_code'])) {
        if ($emailPass == $_SESSION['confirmation_code'] && intval($math) == $_SESSION['math_eval']) {
            // TODO Insert user role on database
            $result = add_user($link, $fname, $lname, $email, $username, $password, $role);

            // TODO check if successful
            if ($result) {
                session_destroy();
                redirect("index.php");
            }
        } else {
            showAlertDialogMethod("Συμπληρωστε σωστά τα πεδία");
        }
    } else {
        showAlertDialogMethod("Συμπληρωστε σωστά τα πεδία");
    }
}
?>

<div class="page_content">
    <form action="post_register.php" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="emailPass">Κωδικός επιβεβαίωσης με email:</label>
            <input required="required" type="text" class="form-control" id="emailPass" name="emailPass"
                   placeholder="Email password">
        </div>

        <div class="form-group">
            <label for="id_role">Ρόλος:</label>
            <select class="form-control" type="text" id="role" name="role">
                <option value="0">Καθηγητής</option>
                <option value="1" selected>Φοιτητής</option>
            </select>
        </div>

        <div class="form-group">
            <label for="math"><?php echo createRandomMathFormula() ?></label>
            <input required="required" type="number" class="form-control" id="math" name="math" placeholder="Total">
        </div>


        <button type="submit" name="register" class="btn btn-primary">Ολοκλήρωση εγγραφής</button>
    </form>
</div>
</body>
</html>