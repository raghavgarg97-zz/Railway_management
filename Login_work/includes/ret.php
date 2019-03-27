<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <script type="text/JavaScript" src="../js/sha512.js"></script>
    <script type="text/JavaScript" src="../js/forms.js"></script>
</head>
<body>
<?php

include_once 'db_connect.php';
include_once 'ret.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $username = $_GET["user_name"];
    $secret = $_GET["secret"];
    if ($username == "" || $secret == "") {
        echo "<script>alert('Both username and secret value has to be supplied as GET parameters.');</script>";
        exit();
    }
    $sq = 'SELECT salt, email FROM members WHERE username="'.$username.'";';
    $result = $mysqli->query($sq);
    if ($row = $result->fetch_assoc()) {
        if ($row["salt"] != $secret) {
            echo "<script>alert('Invalid secret value.');</script>";
            exit();
        }
        $email = $row["email"];
    }
}
/*
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username= $_GET['user_name'];
    $secret = $_GET['secret'];
    $sq = 'SELECT salt FROM members WHERE username="'.$username.'";';
    $result = $mysqli->query($sq);
    if ($row = $result->fetch_assoc()) {
        if ($row["salt"] != $secret) {
            echo "<script>alert('Invalid secret value.');</script>";
            exit();
        }
    }

    echo $username;
    echo "<br>";
    echo $secret;
    echo "<br>";
    echo $_POST["username"];
    echo "<br>";
    echo $_POST["email"];
    echo "<br>";
    echo $_POST["p"];
}
*/



?>
<h2>WELCOME TO PASSWORD RETREIVAL SERVICE</h2>
<form action="" method="post" name="registration_form">
            New Password: <input type="password"
                               name="password"
                               id="password"/><br>
            Confirm New password: <input type="password"
                               name="confirmpwd"
                               id="confirmpwd" /><br>
            <input type="hidden" name="username" id="username" value=<?php echo $username ?> />
            <input type="hidden" name="email" id="email" value=<?php echo $email?> />

            <input type="button"
                    value="Change Password"
                    onclick="return regformhash(this.form,
                            this.form.username,
                            this.form.email,
                            this.form.password,
                            this.form.confirmpwd);" />

        </form>
</body>
</html>
