<?php
include_once "config.php";
session_start();
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
    // Checking users email validation
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // If email is valid
        // Checking if the email is in our db or not!
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) { // if the email exists
            echo "$email - email already in function";
        } else {
            // Checking user update file or not
            if (isset($_FILES["image"])) { // if file is uploaded
                $img_name = $_FILES["image"]["name"]; // getting user uploaded img name
                $img_type = $_FILES["image"]["type"]; // getting user uploaded img type
                $tmp_name = $_FILES["image"]["tmp_name"]; // this is a temporary name used to save/move file in our folder

                // let's explode image and get the last extension
                $img_explode = explode(".", $img_name);
                $img_ext = end($img_explode); // we get the extension of a user uploaded img

                $extensions = ["png", "jpeg", "jpg"]; // valid img extensions for our app that we store in an array
                if (in_array($img_ext, $extensions) === true) { // if the users uploaded img matches our extension array
                    $time = time(); // This will return our current time, we need it bc when we upload user img in our folder, we rename user file with current time,
                                    // so all images will have a unique name
                    // moving the users img to a particular folder, we don't move the file in our db, just the url
                    $new_image_name = $time.$img_name;
                    if (move_uploaded_file($tmp_name, "images/".$new_image_name)) { // if user uploaded img move to our folder successfully
                        $status = "Active now"; // when the users sign in, status will be active
                        $random_id = rand(time(), 10000000); // creating random if for user
                        // inserting user data into the db table
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, firstname, lastname, email, password, img, status)
                                                VALUES ({$random_id}, '{$firstname}', '{$lastname}', '{$email}', '{$password}', 
                                                '{$new_image_name}', '{$status}')");
                        if ($sql2) { // if data inserted
                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if (mysqli_num_rows($sql3) > 0) {
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION["unique_id"] = $row["unique_id"]; // using this session we used in user unique_id in other php files
                                echo "success";
                            }
                        } else {
                            echo "Something went wrong!";
                        }
                    }

                } else {
                    echo "Please select img with the following format - png, jpeg or jpg";
                }

            } else {
                echo "Please select an image";
            }
        }
    } else {
        echo "$email - This is not a valid email!";
    }
} else {
    echo "All input fields are required";
}
