<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signed Out — SecureVote</title>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-glow"></div>
    <div class="auth-card logout-card">
        <div class="logout-icon">👋</div>
        <h1 class="auth-title">You're signed out</h1>
        <p class="auth-subtitle" style="margin-bottom:24px;">
            Thanks for using SecureVote. Redirecting you to the sign-in page…
        </p>
        <a href="login.php" class="btn btn-primary btn-block">Back to Sign In</a>
    </div>
</div>
</body>
</html>
