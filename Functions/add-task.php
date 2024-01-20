<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';

$username = isset($_GET['username']) ? $_GET['username'] : null;

if (isset($_POST['submit'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $user_id = getUserIdByUsername($conn, $username); 
    
    $sql = "INSERT INTO tbl_tasks SET 
        task_name = '$task_name',
        task_description = '$task_description',
        list_id = $list_id,
        priority = '$priority',
        deadline = '$deadline',
        user_id = $user_id
    ";

    $res = mysqli_query($conn, $sql);

    $_SESSION['login_message'] = ($res) ? "Task Added Successfully." : "Failed to Add Task";
    header('location:' . SITEURL . (($res) ? 'home.php?username=' . $username : 'add-task.php?username=' . $username));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>

<br></br>

<div class="card card-body border-0 shadow mb-4">

                    <?php             
                    if (isset($_SESSION['login_message'])) {
                    echo "
                    <div class='alert alert-success' role='alert'>
                    {$_SESSION['login_message']}
                    </div>";
                    unset($_SESSION['login_message']);
                    }
                    ?>
                    
                        <h2 class="h5 mb-4">General information</h2>
                            <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="task_name">Task Name</label>
                                        <input class="form-control" id="task_name" name="task_name" type="text" placeholder="Enter your Task name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="last_name">Task Description</label>
                                        <input class="form-control" id="task_description" name="task_description" type="text" placeholder="Also your last name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-3">
                                    <label for="deadline">Deadline</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                        </span>
                                        <input class="form-control" id="deadline" name="deadline" type="datetime-local" placeholder="dd/mm/yyyy" required>                                               
                                     </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="selectList">Select List</label>
                                    <select name="list_id" class="form-select" id='selectList'>
                                        <?php
                                            $sql = "SELECT * FROM tbl_lists";
                                            $res = mysqli_query($conn, $sql);
                                            $count_rows = mysqli_num_rows($res);

                                            if ($count_rows > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $list_id = $row['list_id'];
                                                    $list_name = $row['list_name'];
                                                    echo "<option value=\"$list_id\">$list_name</option>";
                                                }
                                            } else {
                                                echo "<option value=\"0\">None</option>";
                                            }
                                            
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <select name="priority" class="form-select" id="priority">
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2" name="submit">Submit</button>
                            </div>
                        </form>
</div>

    <?php include 'config/footer.php'; ?>