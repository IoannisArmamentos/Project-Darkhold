<?php
if (isset($_SESSION['login_state']) && !empty($_SESSION['login_state'])) {
    if ($_SESSION['login_state'] == false) {
        session_destroy();
        redirect("error_page.php");
    }
} else {
    session_destroy();
    redirect("error_page.php");
}
?>