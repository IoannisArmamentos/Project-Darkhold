<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {

    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $user = get_user_by_username($link, $username);
    if ($user == null) {
        showAlertDialogMethod("Λανθασμενα στοιχεία");
    } else {
        if ($user->password == md5($password)) {
            showAlertDialogMethod("Επιτυχής σύνδεση");
            $_SESSION['fname'] = $user->name;
            $_SESSION['lname'] = $user->surname;
            $_SESSION['email'] = $user->email;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            $_SESSION['login_state'] = true;
            $_SESSION['user_id'] = $user->id;

            redirect("index.php");
        } else
            showAlertDialogMethod("Λανθασμενα στοιχεία");
    }
}
?>

<form action="#" method="post" enctype="multipart/form-data" class="navbar-form navbar-right">
    <div class="form-group">
        <input type="text" placeholder="Username" name="username" id="username" class="form-control">
    </div>
    <div class="form-group">
        <input type="password" placeholder="Password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" name="login" id="login" class="btn btn-success">Sign in</button>

    <a class="btn btn-primary" href="register.php">Register</a>
</form>