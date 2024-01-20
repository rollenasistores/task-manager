<?php
include('config/constants.php');
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
    $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $task_name = $row['task_name'];
        $task_description = $row['task_description'];
        $list_id = $row['list_id'];
        $priority = $row['priority'];
        $deadline = $row['deadline'];
    } else {
        header('location:' . SITEURL);
    }
} else {
    header('location:' . SITEURL);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>
<body>

<br></br>

<div class="card card-body border-0 shadow mb-4">
<?php
                    if (isset($_SESSION['update_fail'])) {
                        echo $_SESSION['update_fail'];
                        unset($_SESSION['update_fail']);
                    }
                    ?>
                    
                    <h2 class="h5 mb-4">General information</h2>
                            <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="task_name">Task Name</label>
                                        <input class="form-control" id="task_name" name="task_name" type="text" placeholder="Enter your Task name" value="<?=$task_name?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="last_name">Task Description</label>
                                        <input class="form-control" id="task_description" name="task_description" type="text"  value="<?=$task_description?>" placeholder="Also your last name" required>
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
                                        <input class="form-control" id="deadline" name="deadline" type="datetime-local" value="<?=$deadline?>" required>                                               
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
                                        <select name="priority" class="form-select" id="priority" value="<?=$priority?>">
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
                        <?php
if (isset($_POST['submit'])) {
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());
    $sql3 = "UPDATE tbl_tasks SET 
        task_name = '$task_name',
        task_description = '$task_description',
        list_id = '$list_id',
        priority = '$priority',
        deadline = '$deadline'
        WHERE 
        task_id = $task_id
        ";
    $res3 = mysqli_query($conn3, $sql3);

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($res3) {
        $_SESSION['login_message'] = "Task Updated Successfully.";
        header('location:' . SITEURL . "?username=$username&user_id=$user_id");
    } else {
        $_SESSION['login_message'] = "Failed to Update Task";
        header('location:' . SITEURL . 'update-task.php?task_id=' . $task_id . "&username=$username&user_id=$user_id");
    }
}

include 'config/footer.php';

?>






































