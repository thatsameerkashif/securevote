<?php
session_start();
require __DIR__ . "/../config.php";
require __DIR__ . "/../auth.php";
require __DIR__ . "/../audit.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$id = intval($_POST['election_id']);


$conn->prepare("DELETE FROM votes WHERE election_id=?")
      ->bind_param("i", $id)
      ->execute();


$conn->prepare("DELETE FROM candidates WHERE election_id=?")
      ->bind_param("i", $id)
      ->execute();


$stmt = $conn->prepare("DELETE FROM elections WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

logAction($_SESSION['user_id'], "Deleted Election ID: $id");

header("Location: ../../manage-elections.php?msg=deleted");
exit;
