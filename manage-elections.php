<?php
require __DIR__ . "/backend/config.php";
require __DIR__ . "/backend/auth.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

/* ===========================
   HANDLE POST ACTIONS
=========================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ADD ELECTION WITH CANDIDATES */
    if ($_POST['action'] === 'add_election') {

        $title = trim($_POST['title']);
        $candidates = $_POST['candidates'];

        if ($title !== "" && count($candidates) > 0) {

            // Create election
            $stmt = $conn->prepare(
                "INSERT INTO elections (title, status) VALUES (?, 'active')"
            );
            $stmt->bind_param("s", $title);
            $stmt->execute();

            $election_id = $stmt->insert_id;

            // Insert candidates
            $stmt = $conn->prepare(
                "INSERT INTO candidates (election_id, name) VALUES (?, ?)"
            );

            foreach ($candidates as $c) {
                $c = trim($c);
                if ($c !== "") {
                    $stmt->bind_param("is", $election_id, $c);
                    $stmt->execute();
                }
            }
        }
    }

    /* TOGGLE ELECTION STATUS */
    if ($_POST['action'] === 'toggle_status') {
        $eid = (int)$_POST['election_id'];
        $conn->query(
            "UPDATE elections 
             SET status = IF(status='active','closed','active') 
             WHERE id=$eid"
        );
    }

    /* DELETE ELECTION */
    if ($_POST['action'] === 'delete_election') {
        $eid = (int)$_POST['election_id'];
        // Must delete child rows first to satisfy foreign key constraints
        $conn->query("DELETE FROM votes WHERE election_id=$eid");
        $conn->query("DELETE FROM candidates WHERE election_id=$eid");
        $conn->query("DELETE FROM elections WHERE id=$eid");
    }
}

/* ===========================
   FETCH ELECTION DATA
=========================== */

$sql = "
SELECT 
    e.id,
    e.title,
    e.status,
    c.name AS candidate,
    COUNT(v.id) AS votes
FROM elections e
LEFT JOIN candidates c ON c.election_id = e.id
LEFT JOIN votes v ON v.candidate_id = c.id
GROUP BY e.id, c.id
ORDER BY e.id DESC
";

$res = $conn->query($sql);
$elections = [];

while ($r = $res->fetch_assoc()) {
    $id = $r['id'];

    if (!isset($elections[$id])) {
        $elections[$id] = [
            'title' => $r['title'],
            'status' => $r['status'],
            'candidates' => []
        ];
    }

    if ($r['candidate']) {
        $elections[$id]['candidates'][] = [
            'name' => $r['candidate'],
            'votes' => $r['votes']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Elections — SecureVote Admin</title>
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
            <h1 class="page-title">Manage Elections</h1>
            <p class="page-subtitle">Create, monitor, and control all elections</p>
        </div>
        <a href="admin-dashboard.php" class="btn btn-ghost">📊 Live Results</a>
    </div>

    <!-- ADD ELECTION FORM -->
    <div class="card">
        <h2 class="card-title">
            <span class="card-title-icon">➕</span>
            New Election
        </h2>

        <form method="POST">
            <input type="hidden" name="action" value="add_election">

            <div class="form-group">
                <label class="form-label">Election title</label>
                <input type="text" name="title" class="form-control"
                       placeholder="e.g. Student Council President 2025" required>
            </div>

            <div class="form-group">
                <label class="form-label">Candidates</label>
                <div class="candidate-inputs">
                    <input type="text" name="candidates[]" class="form-control"
                           placeholder="Candidate 1" required>
                    <input type="text" name="candidates[]" class="form-control"
                           placeholder="Candidate 2" required>
                    <input type="text" name="candidates[]" class="form-control"
                           placeholder="Candidate 3 (optional)">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Election</button>
        </form>
    </div>

    <!-- EXISTING ELECTIONS -->
    <?php if (empty($elections)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">🗳️</div>
            <p class="empty-text">No elections yet. Create your first one above.</p>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($elections as $id => $e): ?>
    <div class="election-card">
        <div class="election-header">
            <span class="election-title"><?= htmlspecialchars($e['title']) ?></span>
            <div style="display:flex; align-items:center; gap:10px;">
                <span class="badge badge-<?= $e['status'] === 'active' ? 'active' : 'closed' ?>">
                    <?= $e['status'] === 'active' ? 'Active' : 'Closed' ?>
                </span>
                <div class="election-actions">
                    <!-- TOGGLE STATUS -->
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="toggle_status">
                        <input type="hidden" name="election_id" value="<?= $id ?>">
                        <button type="submit" class="btn btn-sm <?= $e['status'] === 'active' ? 'btn-warning' : 'btn-success' ?>"
                            style="<?= $e['status'] === 'active' ? 'background:rgba(251,191,36,0.1);color:var(--amber-400);border:1px solid rgba(251,191,36,0.2);' : '' ?>">
                            <?= $e['status'] === 'active' ? '🔒 Close' : '🔓 Reopen' ?>
                        </button>
                    </form>
                    <!-- DELETE -->
                    <form method="POST" style="display:inline"
                          onsubmit="return confirm('Permanently delete this election and all its votes?');">
                        <input type="hidden" name="action" value="delete_election">
                        <input type="hidden" name="election_id" value="<?= $id ?>">
                        <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (empty($e['candidates'])): ?>
            <p style="color:var(--slate-400); font-size:14px;">No candidates added.</p>
        <?php else: ?>
            <ul class="candidate-list">
                <?php foreach ($e['candidates'] as $c): ?>
                <li class="candidate-item">
                    <span><?= htmlspecialchars($c['name']) ?></span>
                    <span class="candidate-vote-count"><?= $c['votes'] ?> vote<?= $c['votes'] !== 1 ? 's' : '' ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

</main>
</body>
</html>
