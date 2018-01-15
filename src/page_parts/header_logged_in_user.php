<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    redirect("index.php");
}
?>

<form action="#" method="post" enctype="multipart/form-data" class="navbar-form navbar-right">
    <div class="form-group">
        <input type="text" value="<?php echo $_SESSION['fname'] ?>" disabled="disabled" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" value="<?php echo $_SESSION['lname'] ?>" disabled="disabled" class="form-control">
    </div>
    <button type="submit" name="logout" id="logout" class="btn btn-danger">Log out</button>
</form>