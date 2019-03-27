<?php
/**
* Copyright (C) 2013 peredur.net
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
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Secure Login: Registration Form</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/JavaScript" src="js/sha512.js"></script>
  <script type="text/JavaScript" src="js/forms.js"></script>
  <script type="text/JavaScript" src="js/password_strength.js"></script>
  <link rel="stylesheet" href="styles/main.css" />
</head>
<body style="background-color:#cfdcf7;">
  <!-- Registration form to be output if the POST variables are not
  set or if the registration script caused an error. -->
  <h1>Register with us</h1>
  <?php
  if (!empty($error_msg)) {
    echo $error_msg;
  }
  if(count($suggestions)>0)
  {
    echo '<span style="color:green;">You may try these Usernames :</span>';
    echo "<ol>";
    for($i=0; $i<count($suggestions); $i++)
    {
      echo '<li><span style="color:green;">'.$suggestions[$i]."</span></li>";
    }
    echo "</ol>";
  }
  ?>
  Passwords must contain
  <ul>
    <li>At least one upper case letter (A..Z)</li>
    <li>At least one lower case letter (a..z)</li>
    <li>At least one number (0..9)</li>
  </ul>
  <form method="post" name="registration_form" class="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
    <table>
      <tr>
        <th>Username: </th> <td> <input type='text' name='username' id='username' /></td>
        <td> Usernames may contain only digits, upper and lower case letters and underscores </td>
      </tr>
      <tr>
        <th>Email: </th> <td> <input type="text" name="email" id="email" /></td>
        <td> Emails must have a valid email format </td>
      </tr>
      <tr>
        <th>Password: </th> <td><input type="password"
          name="password"
          id="password"/>
          <div id="strength_bar" style="padding-top:5%;"></div>
        </td>
        <td> Passwords must be at least 6 characters long</td>
      </tr>
      <tr>
        <th>Confirm password: </th> <td><input type="password"
          name="confirmpwd"
          id="confirmpwd" /></td>
          <td> Your password and confirmation must match exactly </td>
        </tr>
      </table>
      <input type="button" id="register_button"
      value="Register"
      onclick="return regformhash(this.form,
      this.form.username,
      this.form.email,
      this.form.password,
      this.form.confirmpwd);" />
    </form>
    <p>Return to the <a href="index.php">login page</a>.</p>
  </body>
  </html>

