<?php

/*
 * Copyright (C) 2013 peter
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = $_POST['username'];
    $email = $_POST['email'];
    $secret = $_GET['secret'];

    $sq = 'SELECT salt, email FROM members WHERE username="'.$username.'";';
    $result = $mysqli->query($sq);
    if ($row = $result->fetch_assoc()) {
        if ($row["salt"] != $secret) {
            echo "<script>alert('Invalid secret value.');</script>";
            exit();
        }
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }


    // Create a random salt
    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

    // Create salted password
        $password = hash('sha512', $password . $random_salt);

        $email = '"'.$email.'"';
        $password = '"'.$password.'"';
        $random_salt = '"'.$random_salt.'"';

        $qr = "UPDATE members SET password = ".$password.", salt = ".$random_salt." WHERE email = ".$email."";
        $update_stmt = $mysqli->prepare($qr);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password reset successful.');</script>";
        } else {
            echo "<script>alert('Password reset failed.');</script>";
        }

        echo "<script type='text/javascript'>document.location.href='../index.php';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=../index.php">';
        exit();
}
