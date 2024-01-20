<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';

if (isset($_POST['update_username']) || isset($_POST['update_password'])) {
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    $userId = getUserIdByUsername($conn, $username);

    if ($userId !== null) {
        // Update the username
        if (isset($_POST['update_username'])) {
            $newUsername = $_POST['new_username'];

            if(empty($newUsername))
            {
                $_SESSION['error'] = "Username is Empty";
            }else {
                $updateUsername = updateUsername($conn, $userId, $newUsername);

                if ($updateUsername) {
                    // Update the session with the new username
                    $_SESSION['username'] = $newUsername;
                    $_SESSION['login_message'] = "Username updated successfully.";
    
                    // Redirect to the profile page with the new username
                    header('Location: ' . SITEURL . 'profile.php' . '?username=' . urlencode($newUsername));
                    exit;
                } else {
                    $_SESSION['login_message'] = "Failed to update username.";
                }
            }


        }

        // Update the password
        if (isset($_POST['update_password'])) {
            $newPassword = $_POST['new_password'];

            if(empty($newPassword))
            {
                $_SESSION['error'] = "Password is Empty";
            }else {

            // Validate and sanitize $newPassword as needed

            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updatePassword = updatePassword($conn, $userId, $hashedNewPassword);

            if ($updatePassword) {
                $_SESSION['login_message'] = "Password updated successfully.";
            } else {
                $_SESSION['login_message'] = "Failed to update password.";
            }
            
            }


        }
    } else {
        $errorMessage = "User not found.";
    }
}

?>

<br></br>

<div class="card card-body border-0 shadow mb-4">
    
<?php
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger' role='alert'>{$_SESSION['error']}!
</div>";
    unset($_SESSION['error']);
}
?>

        <?php
if (isset($_SESSION['login_message'])) {
    echo "<div class='alert alert-success' role='alert'>{$_SESSION['login_message']}!
</div>";
    unset($_SESSION['login_message']);
}
?>
        <form method="POST" action="" id="updateUsernameForm">

                <div class="mb-3">
                <label for="newUsername" class="form-label">New Username</label>
                <input type="text" class="form-control" id="newUsername" name="new_username" placeholder="New Username">

                <div class="d-grid mt-2">
                <button type="submit" name="update_username" class="btn btn-success">Update Username</button>
                </div>

            </div>

            <div class="mb-3">
            <label class="form-label">New Password:</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" />
            </div>
            <div class="mb-3">

            <label class="form-label">Confirm New Password:</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" />
                <div class="d-grid mt-2">
                <button type="submit" name="update_password" class="btn btn-success">Update Password</button>
                </div>

            </div>
        </form>

</div>
        <?php include 'config/footer.php'; ?>