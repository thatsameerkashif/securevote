<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — SecureVote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-glow"></div>
    <div class="auth-card">

        <div class="auth-logo">
            <div class="auth-logo-icon">🗳️</div>
            <span class="auth-logo-text">SecureVote</span>
        </div>

        <h1 class="auth-title">Create an account</h1>
        <p class="auth-subtitle">Register as a voter to participate in elections</p>

        <form action="backend/signup.php" method="POST">

            <div class="form-group">
                <label class="form-label" for="name">Full name</label>
                <input type="text" name="name" id="name"
                       class="form-control" placeholder="Jane Smith" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email"
                       class="form-control" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password"
                       class="form-control" placeholder="Choose a strong password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px;">
                Create account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</div>
</body>
</html>
