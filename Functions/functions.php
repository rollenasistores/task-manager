<?php
function displaySessionMessage($sessionKey)
{
    if (isset($_SESSION[$sessionKey])) {
        echo $_SESSION[$sessionKey];
        unset($_SESSION[$sessionKey]);
    }
}

function getUserIdByUsername($conn, $username)
{
    $sql = "SELECT user_id FROM users WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId);

        if (mysqli_stmt_fetch($stmt)) {
            mysqli_stmt_close($stmt);
            return $userId;
        }
    }

    return null;
}

function displayCountonAllList($conn, $userId, $username, $list_id) {

    $sql = "SELECT * FROM tbl_tasks WHERE list_id = $list_id AND user_id = $userId";

    if ($result=mysqli_query($conn,$sql))
      {
      // Return the number of rows in result set
      $rowcount=mysqli_num_rows($result);
      printf($rowcount, "Tasks");
      // Free result set
      mysqli_free_result($result);

      
      }

}

function displayAllTasks($conn, $userId, $username)
{
    $sql = "SELECT * FROM tbl_tasks WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $sn = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $taskId = $row['task_id'];
            $list_id = $row['list_id'];
            $taskName = $row['task_name'];
            $taskDescription = $row['task_description'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];

            if ($list_id == 1)
            {
                $list_id = "<span class='badge badge-sm bg-secondary ms-1 text-gray-800'>To do</span>";
            } else if ($list_id == 2) {

                $list_id = "<span class='badge badge-sm bg-primary ms-1 text-white-800'>In Progress</span>";
            } else if ($list_id == 3) {
                $list_id = "<span class='badge badge-sm bg-success ms-1 text-white-800'>Completed</span>";
            }

            ?>

                                                    <tr>
                                            <th class="text-gray-900" scope="row">
                                                <?=$sn++?>.
                                            </th>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$list_id?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$taskName?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$taskDescription?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$deadline?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                             <?=$priority?>
                                            </td>
                                            <td>
                                            <a href="<?=SITEURL?>update-task.php?task_id=<?=$taskId?> &username=<?=$username?> "><button class="btn btn-success btn-sm">Edit</button></a>
                                            <a href="<?=SITEURL?>delete-task.php?task_id=<?=$taskId?> &username=<?=$username?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                                        </td>
                                        </tr>
            <?php
}

        mysqli_stmt_close($stmt);
    } else {
        die("Prepared statement failed: " . mysqli_error($conn));
    }
}

function displayTaskReport($conn, $listId, $username)
{
    $sql = "SELECT t.* FROM tbl_tasks t
            JOIN tbl_lists l ON t.list_id = l.list_id
            JOIN users u ON t.user_id = u.user_id
            WHERE t.list_id IN (2, 3) AND u.Username = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $sn = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $taskId = $row['task_id'];
            $taskName = $row['task_name'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];

            if ($list_id == 1)
            {
                $list_id = "<span class='badge badge-sm bg-secondary ms-1 text-gray-800'>0%</span>";
            } else if ($list_id == 2) {

                $list_id = "<span class='badge badge-sm bg-primary ms-1 text-white-800'>50%</span>";
            } else if ($list_id == 3) {
                $list_id = "<span class='badge badge-sm bg-success ms-1 text-white-800'>100%</span>";
            }


            ?>
            <tr>
                <td><?=$sn++?>.</td>
                <td><?=$taskName?></td>
                <td><?=$priority?></td>
                <td><?=$list_id?></td>
                <td><?=$deadline?></td>
                <td>
                    <a href="<?=SITEURL?>update-task.php?task_id=<?=$taskId?> &username=<?=$username?>"><button class="btn btn-success btn-sm">Edit</button></a>
                    <a href="<?=SITEURL?>delete-task.php?task_id=<?=$taskId?> &username=<?=$username?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                </td>
            </tr>
            <?php
}

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Output the error
        die("Prepared statement failed: " . mysqli_error($conn));
    }
}

function displayTasksByList($conn, $listId, $username)
{
    $sql = "SELECT t.* FROM tbl_tasks t
            JOIN tbl_lists l ON t.list_id = l.list_id
            JOIN users u ON t.user_id = u.user_id
            WHERE t.list_id = ? AND u.Username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "is", $listId, $username);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $sn = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $taskId = $row['task_id'];
            $taskName = $row['task_name'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];
            
            if ($list_id == 1)
            {
                $list_id = "<span class='badge badge-sm bg-secondary ms-1 text-gray-800'>To do</span>";
            } else if ($list_id == 2) {

                $list_id = "<span class='badge badge-sm bg-primary ms-1 text-white-800'>In Progress</span>";
            } else if ($list_id == 3) {
                $list_id = "<span class='badge badge-sm bg-success ms-1 text-white-800'>Completed</span>";
            }

            ?>
                                                    <tr>
                                            <th class="text-gray-900" scope="row">
                                                <?=$sn++?>.
                                            </th>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$list_id?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$taskName?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                            <?=$deadline?>
                                            </td>
                                            <td class="fw-bolder text-gray-500">
                                             <?=$priority?>
                                            </td>
                                            <td>
                                            <a href="<?=SITEURL?>update-task.php?task_id=<?=$taskId?> &username=<?=$username?> "><button class="btn btn-success btn-sm">Edit</button></a>
                                            <a href="<?=SITEURL?>delete-task.php?task_id=<?=$taskId?> &username=<?=$username?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                                        </td>
                                        </tr>
            <?php
}

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Output the error
        die("Prepared statement failed: " . mysqli_error($conn));
    }
}

function updateUsername($conn, $userId, $newUsername)
{
    $sql = "UPDATE users SET Username = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $newUsername, $userId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    return false;
}

function updatePassword($conn, $userId, $hashedNewPassword)
{
    $sql = "UPDATE users SET Password = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $hashedNewPassword, $userId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    return false;
}

// Get all users from the database
function getAllUsers($conn)
{
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    return $users;
}

// Delete user by user_id
function deleteUser($conn, $userId)
{
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    return false;
}

function getTasks($conn, $userID)
{
    $tasks = [];

    $sql = "SELECT * FROM tbl_tasks WHERE user_id = $userID";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
    }

    return $tasks;
}

function getPriorityClass($priority)
{
    switch ($priority) {
        case 'High':
            return 'high-priority';
        case 'Medium':
            return 'medium-priority';
        case 'Low':
            return 'low-priority';
        default:
            return '';
    }
}