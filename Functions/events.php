<?php
session_start();

$userId = $_SESSION['user_id'];

$pdo = new PDO('mysql:host=localhost;dbname=task_manager', 'root', '');

$stmt = $pdo->prepare("SELECT * FROM tbl_tasks where user_id = :user_id");

$stmt->bindParam(':user_id', $userId);

$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$formattedEvents = [];
foreach ($events as $event) {
    $formattedEvents[] = [
        'id' => $event['task_id'],
        'title' => $event['task_name'],
        'start' => date('Y-m-d\TH:i:s', strtotime($event['deadline'])),
    ];
}

header('Content-Type: application/json');
echo json_encode($formattedEvents);

