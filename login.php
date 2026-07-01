<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — SecureVote</title>
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

        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-subtitle">Sign in to your account to continue</p>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registered'): ?>
        <div class="alert alert-success">✅ Account created — you can now sign in.</div>
        <?php endif; ?>

        <form action="backend/login.php" method="POST">

            <div class="form-group">
                <label class="form-label" for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">Select your role…</option>
                    <option value="admin">Administrator</option>
                    <option value="voter">Voter</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email"
                       class="form-control" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password"
                       class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px;">
                Sign in
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="signup.php">Create one</a>
        </div>
    </div>
</div>
</body>
</html>
