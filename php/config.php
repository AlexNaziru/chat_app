<!-- Connecting to the database -->
<?php
$conn = mysqli_connect("localhost", "alex", "alexandru", "chat");
if ($conn) {
    echo "Database connected!" . mysqli_connect_error();
}
