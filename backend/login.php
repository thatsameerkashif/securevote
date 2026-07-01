<?php
require "config.php";

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role=?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    require __DIR__ . "/audit.php";
    logAction($user['id'], "User Logged In");

    if ($role === "admin") {
        header("Location: ../admin-dashboard.php");
    } else {
        header("Location: voter/vote.php");
    }
}
else {
    echo "Invalid credentials";
}
?>
