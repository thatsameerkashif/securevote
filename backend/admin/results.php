<?php
session_start();
require __DIR__ . "/../config.php";
require __DIR__ . "/../auth.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$query = "
SELECT e.title, c.name, COUNT(v.id) AS votes
FROM elections e
JOIN candidates c ON c.election_id = e.id
LEFT JOIN votes v ON v.candidate_id = c.id
GROUP BY c.id
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results — SecureVote Admin</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<header class="topbar">
    <a href="../../admin-dashboard.php" class="topbar-brand">
        <div class="topbar-icon">🗳️</div>
        <span class="topbar-name">SecureVote</span>
    </a>
    <div class="topbar-spacer"></div>
    <span class="topbar-badge">Admin</span>
    <a href="../../logout.php" class="btn btn-ghost btn-sm" style="margin-left:12px;">Sign out</a>
</header>

<main class="page-content">
    <div class="page-header-row page-header">
        <div>
            <h1 class="page-title">Election Results</h1>
            <p class="page-subtitle">All elections and vote counts</p>
        </div>
        <a href="../../admin-dashboard.php" class="btn btn-ghost">← Dashboard</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Election</th>
                    <th>Candidate</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><span class="candidate-vote-count"><?= $row['votes'] ?></span></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
