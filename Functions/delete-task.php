<?php 

    include('config/constants.php');
    include('config/db-connections.php');
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    if (!empty($_GET['task_id'])) {
        $task_id = $_GET['task_id'];
        
        $sql = "DELETE FROM tbl_tasks WHERE task_id = $task_id";
        $result = mysqli_query($conn, $sql);
    
        $_SESSION['login_message'] = $result ? "Task Deleted Successfully." : "Failed to Delete Task";
    } else {
        $_SESSION['delete_fail'] = "Invalid Task ID";
        
    }
    
header('Location: ' . SITEURL . '?username=' . $username);
