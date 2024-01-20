<?php
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

$db_select = mysqli_select_db($conn, DB_NAME);
