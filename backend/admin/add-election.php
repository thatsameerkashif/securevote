<?php
session_start();
require __DIR__ . "/../config.php";
require __DIR__ . "/../auth.php";
require __DIR__ . "/../audit.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$title = trim($_POST['title']);
$candidates = $_POST['candidates'];

if (!$title || count($candidates) < 2) {
    die("Election must have at least 2 candidates");
}


$stmt = $conn->prepare("INSERT INTO elections (title) VALUES (?)");
$stmt->bind_param("s", $title);
$stmt->execute();

$election_id = $conn->insert_id;


$candStmt = $conn->prepare(
    "INSERT INTO candidates (name, election_id) VALUES (?, ?)"
);

foreach ($candidates as $name) {
    $name = trim($name);
    if ($name !== "") {
        $candStmt->bind_param("si", $name, $election_id);
        $candStmt->execute();
    }
}

logAction($_SESSION['user_id'], "Created election '$title' with candidates");

header("Location: ../../manage-elections.php?msg=created");
exit;
