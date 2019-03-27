<!DOCTYPE html>
<html>
<head>
    <title>Generate Link for new tab</title>
    </head>
<body>

<h2>This is Your VIRTUAL INBOX</h2>
<?php
include_once 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $username=$_GET["username"];
        $sq = 'SELECT salt FROM members WHERE username="'.$username.'";';
        $result = $mysqli->query($sq);
        if($row = $result->fetch_assoc()) {
            $secret = $row["salt"];
            $url="ret.php?user_name=".$username."&secret=".$secret."";
            echo 'Hi '.$username.', somebody requested the password reset for your account.<br>';
            echo 'Click on this <a href="'.$url.'">link</a> to generate a new password for '.$username.'.';
        } else {
            echo '<script>alert("User not found in database.");</script>';
        }
    }
?>

</body>
</html>
