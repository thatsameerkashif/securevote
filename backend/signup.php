<?php
require "config.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'voter')"
);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    header("Location: ../login.php?msg=registered");
}
?>
