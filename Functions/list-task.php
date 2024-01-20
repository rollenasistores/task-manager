<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';

// Get parameters from the URL
$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;
$username = isset($_GET['username']) ? $_GET['username'] : null;

if ($listId == 1) {
$status = 'To Do'; // Default to 'To Do' for user ID 1
} elseif ($listId == 2) {
$status = 'In Progress'; // Default to 'In Progress' for user ID 2
} elseif ($listId == 3) {
$status = 'Completed'; // Default to 'Completed' for user ID 3
}
?>
<p>
            </p>
<div class="card border-0 shadow">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="fs-5 fw-bold mb-0"><?php echo ucfirst($status); ?></h2> 
            </div>
            <div class="col text-end">
        <a href="<?=SITEURL?>add-task.php?username=<?=$username?>" class="btn btn-sm btn-success">Add new Task</a>
            </div>
        </div>
    </div>
        <?php
        echo '<div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
                <th class="border-bottom" scope="col">#</th>
                <th class="border-bottom" scope="col">Task List</th>
                <th class="border-bottom" scope="col">Task Name</th>
                <th class="border-bottom" scope="col">Task Deadline</th>
                <th class="border-bottom" scope="col">Task Priority</th>
                <th class="border-bottom" scope="col">Task Action</th>
            </tr>
            </thead>
            <tbody>
            ';
        // Pass both listId and username to displayTasksByList
        displayTasksByList($conn, $listId, $username);
        echo '</tbody>
        </table>
    </div>';
        ?>
</div>
<?php include 'config/footer.php'; ?>