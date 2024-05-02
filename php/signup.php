<?php
include_once "config.php";
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {

} else {
    echo "All input fields are required";
}
