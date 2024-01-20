<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';
// Get all users from the database
$users = getAllUsers($conn);



$username = isset($_GET['username']) ? $_GET['username'] : null;

$pdo = new PDO('mysql:host=localhost;dbname=task_manager', 'root', '');

$stmt = $pdo->prepare("SELECT * FROM users where username = :username");

$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user['user_role'] != 1)
{

    $_SESSION['message'] = "You are not allowed to access!";
    header('Location: home.php?username=' . $username);
}

$userID = $user['user_id'];

?>
<br/>
    <?php if(isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    }
    unset($_SESSION['error']);
    ?>
        <?php if(isset($_SESSION['message'])) {
        echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
    }
    unset($_SESSION['message']);
    ?>
<div class="card border-0 shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h2 class="fs-5 fw-bold mb-0">Admin Panel</h2>
                                        </div>

                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="border-bottom" scope="col">#</th>
                                            <th class="border-bottom" scope="col">Username</th>
                                            <th class="border-bottom" scope="col">Email</th>
                                            <th class="border-bottom" scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td><?= $user['user_id']; ?></td>
                                                <td><?= $user['Username']; ?></td>
                                                <td><?= $user['Email']; ?></td>
                                                <td>
                                                    <a href="admin.php?username=<?=$username?>&action=delete&user_id=<?= $user['user_id']; ?>" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
</div>

    <?php
        // Handle user deletion
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
            $deleteUserId = $_GET['user_id'];

            if($deleteUserId == $userID) {
                $_SESSION['error'] = "Failed to delete user.";
               header('Location: admin.php?username=' . $username);
            }else {

                $result = deleteUser($conn, $deleteUserId);

                if ($result) {
                    $_SESSION['message'] = "User deleted successfully.";
                    header('Location: admin.php?username=' . $username);
                } else {
                    $_SESSION['error'] = "Failed to delete user.";
                    header('Location: admin.php?username=' . $username);
                }
            }


        }
        ?>


<?php include('config/footer.php'); ?>

</body>
</html>