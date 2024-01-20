<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';

// Get parameters from the URL
$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;
$username = isset($_GET['username']) ? $_GET['username'] : null;

    $status = 'Game Break!'; // Default to 'To Do' for user ID 1

?>

<p></p>
<div class="card border-0 shadow">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="fs-5 fw-bold mb-0"><?php echo ucfirst($status); ?></h2>
            </div>
            
        </div>
    </div>
    <div><script src="https://cdn.htmlgames.com/embed.js?game=PinballBreakout&amp;bgcolor=white"></script></div>
</div>
<?php include 'config/footer.php'; ?>