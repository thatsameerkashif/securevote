<?php
require __DIR__ . "/backend/config.php";
require __DIR__ . "/backend/auth.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

/*
  Fetch elections + candidates + vote counts
*/
$sql = "
SELECT 
    e.id AS election_id,
    e.title AS election_title,
    e.status,
    c.name AS candidate_name,
    COUNT(v.id) AS votes
FROM elections e
LEFT JOIN candidates c ON c.election_id = e.id
LEFT JOIN votes v ON v.candidate_id = c.id
GROUP BY e.id, c.id
ORDER BY e.id DESC
";

$result = $conn->query($sql);

$elections = [];

while ($row = $result->fetch_assoc()) {
    $eid = $row['election_id'];

    if (!isset($elections[$eid])) {
        $elections[$eid] = [
            'title' => $row['election_title'],
            'status' => $row['status'],
            'candidates' => []
        ];
    }

    if ($row['candidate_name']) {
        $elections[$eid]['candidates'][] = [
            'name' => $row['candidate_name'],
            'votes' => $row['votes']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Results — SecureVote Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Topbar -->
<header class="topbar">
    <a href="admin-dashboard.php" class="topbar-brand">
        <div class="topbar-icon">🗳️</div>
        <span class="topbar-name">SecureVote</span>
    </a>
    <div class="topbar-spacer"></div>
    <span class="topbar-badge">Admin</span>
    <a href="logout.php" class="btn btn-ghost btn-sm" style="margin-left:12px;">Sign out</a>
</header>

<main class="page-content">

    <div class="page-header-row page-header">
        <div>
            <h1 class="page-title">Live Results</h1>
            <p class="page-subtitle">Real-time vote counts across all elections</p>
        </div>
        <a href="manage-elections.php" class="btn btn-primary">
            ⚙️ Manage Elections
        </a>
    </div>

    <?php if (empty($elections)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">📊</div>
            <p class="empty-text">No elections yet. Create one from the Manage Elections page.</p>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($elections as $id => $e):
        $totalVotes = array_sum(array_column($e['candidates'], 'votes'));
    ?>
    <div class="election-card">
        <div class="election-header">
            <span class="election-title"><?= htmlspecialchars($e['title']) ?></span>
            <span class="badge badge-<?= $e['status'] === 'active' ? 'active' : 'closed' ?>">
                <?= $e['status'] === 'active' ? 'Active' : 'Closed' ?>
            </span>
        </div>

        <?php if (empty($e['candidates'])): ?>
            <p style="color:var(--slate-400); font-size:14px;">No candidates added.</p>
        <?php else: ?>
            <?php foreach ($e['candidates'] as $c):
                $pct = $totalVotes > 0 ? round(($c['votes'] / $totalVotes) * 100) : 0;
            ?>
            <div class="candidate-row">
                <div class="candidate-row-header">
                    <span class="candidate-name"><?= htmlspecialchars($c['name']) ?></span>
                    <span class="candidate-votes">
                        <?= $c['votes'] ?> vote<?= $c['votes'] !== 1 ? 's' : '' ?>
                        &nbsp;·&nbsp; <?= $pct ?>%
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:<?= $pct ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
            <p style="font-size:12px; color:var(--slate-400); margin-top:10px;">
                Total votes cast: <?= $totalVotes ?>
            </p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

</main>
</body>
</html>
