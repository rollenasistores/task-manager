<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Notifications</title>
    <style>
        .notification {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .high-priority {
            background-color: #ffaaaa;
        }

        .medium-priority {
            background-color: #ffffaa; 
        }

        .low-priority {
            background-color: #aaffaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Task Notifications</h2>

        <?php foreach ($tasks as $task) : ?>
            <?php
            // Calculate time remaining until the deadline
            $now = new DateTime('now');
            $deadline = new DateTime($task['deadline']);
            $interval = $now->diff($deadline);

            // Get the remaining days, hours, and minutes
            $daysRemaining = $interval->format('%a');
            $hoursRemaining = $interval->format('%h');
            $minutesRemaining = $interval->format('%i');
            ?>

            <div class="notification <?= getPriorityClass($task['priority']); ?>">
                <h3><?= $task['task_name']; ?></h3>
                <p><?= $task['task_description']; ?></p>
                <p>Priority: <?= $task['priority']; ?></p>
                <p>Deadline: <?= $task['deadline']; ?> (<?= $daysRemaining; ?> days, <?=$hoursRemaining ?> hours, and <?=$minutesRemaining?> Minutes)</p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>