<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';

if (isset($_POST['submit'])) {
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];

    $sql = "INSERT INTO tbl_lists (list_name, list_description) VALUES ('$list_name', '$list_description')";
    $res = mysqli_query($conn, $sql);

    $message = ($res) ? 'List Added Successfully' : 'Failed to Add List';
    $_SESSION['add'] = $message;

    header('location:' . SITEURL . (($res) ? 'manage-list.php' : 'add-list.php'));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="<?= SITEURL ?>css/style.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <h1 class="text-center">Task Manager Application</h1>
                <a class="btn-secondary" href="<?= SITEURL ?>">Home</a>
                <a class="btn-secondary" href="<?= SITEURL ?>manage-list.php">Manage Lists</a>
                <h3>Add List Page</h3>
                <p><?php displaySessionMessage('add_fail'); ?></p>
                <form method="POST">
                    <div class="mb-3">
                        <label for="example" class="form-label">List Name:</label>
                        <input type="text" name="list_name" class="form-control" placeholder="Type list name here" required />
                    </div>
                    <div class="mb-3">
                        <label for="example" class="form-label">List Description</label>
                        <textarea name="list_description" class="form-control" placeholder="Type List Description Here"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</body>
</html>





















