<?php
session_start();

$conn = new mysqli("localhost", "root", "", "voting_system");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
