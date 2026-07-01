<?php
session_start();
require __DIR__ . "/../config.php";
require __DIR__ . "/../auth.php";
require __DIR__ . "/../audit.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$id = intval($_POST['election_id']);

$stmt = $conn->prepare("UPDATE elections SET status='closed' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

logAction($_SESSION['user_id'], "Closed election ID $id");

header("Location: ../../manage-elections.php?msg=closed");
exit;
