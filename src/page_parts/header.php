<?php
session_start();
include_once "utilities/connectWithDB.php";
include_once "utilities/methods.php";
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            if (isset($_SESSION['login_state']) && $_SESSION['login_state'] == true) {
                if (isset($_SESSION['role']) && !empty($_SESSION['role'])) {
                    if ($_SESSION['role'] == 0) {
                        echo '<a class="navbar-brand" href="index.php">Πλατφόρμα Καθηγητή</a>';
                    } else if ($_SESSION['role'] == 1) {
                        echo '<a class="navbar-brand" href="index.php">Πλατφόρμα Μαθητή</a>';
                    }
                } else {
                    echo '<a class="navbar-brand" href="index.php">Πλατφόρμα Διπλωματικών</a>';
                }
            } else {
                echo '<a class="navbar-brand" href="index.php">Πλατφόρμα Διπλωματικών</a>';
            }

            if (isset($_SESSION['login_state']) && !empty($_SESSION['login_state'])) {
                if ($_SESSION['login_state'] == true) {
                    include_once "header_logged_in_user.php";
                } else {
                    include_once "header_login_form.php";
                }
            } else {
                include_once "header_login_form.php";
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION['login_state']) && !empty($_SESSION['login_state'])) {
            if ($_SESSION['login_state'] == true) {
                //showAlertDialogMethod("<" . $_SESSION['role'] . ">");
                $user_role = $_SESSION['role'];
                //if (isset($user_role) && !empty($user_role)) {
                //showAlertDialogMethod(">" . $user_role);
                if ($user_role == 0) {
                    include_once "header_options_teacher.php";
                } else if ($user_role == 1) {
                    include_once "header_options_student.php";
                }
                //  }
            }
        }

        ?>
    </div>
</nav>