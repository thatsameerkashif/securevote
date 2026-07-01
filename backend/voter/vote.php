<?php
require __DIR__ . "/../config.php";
require __DIR__ . "/../auth.php";
require __DIR__ . "/../audit.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'voter') {
    header("Location: ../../login.php");
    exit;
}

$voter_id = $_SESSION['user_id'];

/* =========================
   HANDLE VOTE SUBMISSION
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['election_id']) || empty($_POST['candidate_id'])) {
        header("Location: vote.php?msg=invalid");
        exit;
    }

    $election_id  = (int) $_POST['election_id'];
    $candidate_id = (int) $_POST['candidate_id'];

    // Check election is active
    $stmt = $conn->prepare(
        "SELECT id FROM elections WHERE id = ? AND status = 'active'"
    );
    $stmt->bind_param("i", $election_id);
    $stmt->execute();

    if ($stmt->get_result()->num_rows === 0) {
        header("Location: vote.php?msg=closed");
        exit;
    }

    // Check candidate belongs to election
    $stmt = $conn->prepare(
        "SELECT id FROM candidates WHERE id = ? AND election_id = ?"
    );
    $stmt->bind_param("ii", $candidate_id, $election_id);
    $stmt->execute();

    if ($stmt->get_result()->num_rows === 0) {
        header("Location: vote.php?msg=invalid");
        exit;
    }

    // Prevent double voting
    $stmt = $conn->prepare(
        "SELECT id FROM votes WHERE voter_id = ? AND election_id = ?"
    );
    $stmt->bind_param("ii", $voter_id, $election_id);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        header("Location: vote.php?msg=already_voted");
        exit;
    }

    // Insert vote
    $stmt = $conn->prepare(
        "INSERT INTO votes (voter_id, election_id, candidate_id)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("iii", $voter_id, $election_id, $candidate_id);
    $stmt->execute();

    logAction($voter_id, "Voted in election ID: $election_id");

    header("Location: vote.php?msg=success");
    exit;
}

/* =========================
   FETCH AVAILABLE ELECTIONS
   ========================= */

$sql = "
SELECT e.id AS election_id, e.title, c.id AS candidate_id, c.name
FROM elections e
JOIN candidates c ON c.election_id = e.id
WHERE e.status = 'active'
AND NOT EXISTS (
    SELECT 1 FROM votes v
    WHERE v.voter_id = ?
    AND v.election_id = e.id
)
ORDER BY e.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $voter_id);
$stmt->execute();
$res = $stmt->get_result();

$elections = [];
while ($row = $res->fetch_assoc()) {
    $elections[$row['election_id']]['title'] = $row['title'];
    $elections[$row['election_id']]['candidates'][] = [
        'id' => $row['candidate_id'],
        'name' => $row['name']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Your Vote — SecureVote</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<!-- Topbar -->
<header class="topbar">
    <a href="vote.php" class="topbar-brand">
        <div class="topbar-icon">🗳️</div>
        <span class="topbar-name">SecureVote</span>
    </a>
    <div class="topbar-spacer"></div>
    <span class="topbar-badge">Voter</span>
    <a href="../../logout.php" class="btn btn-ghost btn-sm" style="margin-left:12px;">Sign out</a>
</header>

<main class="page-content">

    <div class="page-header">
        <h1 class="page-title">Cast Your Vote</h1>
        <p class="page-subtitle">Select a candidate for each active election below</p>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'success'): ?>
            <div class="alert alert-success">✅ Your vote has been recorded successfully.</div>
        <?php elseif ($_GET['msg'] === 'already_voted'): ?>
            <div class="alert alert-warning">⚠️ You have already voted in this election.</div>
        <?php elseif ($_GET['msg'] === 'invalid'): ?>
            <div class="alert alert-error">❌ Invalid request. Please try again.</div>
        <?php elseif ($_GET['msg'] === 'closed'): ?>
            <div class="alert alert-error">❌ This election is closed and no longer accepting votes.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($elections)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <p class="empty-text">You're all caught up — no active elections available right now.</p>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($elections as $eid => $e): ?>
    <div class="vote-election-card">
        <h2 class="vote-election-title"><?= htmlspecialchars($e['title']) ?></h2>

        <form method="POST">
            <input type="hidden" name="election_id" value="<?= $eid ?>">

            <?php foreach ($e['candidates'] as $c): ?>
            <div class="vote-option">
                <input type="radio" name="candidate_id"
                       id="c<?= $c['id'] ?>" value="<?= $c['id'] ?>" required>
                <label for="c<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></label>
            </div>
            <?php endforeach; ?>

            <div class="vote-submit-row">
                <button type="submit" class="btn btn-primary">Submit Vote</button>
            </div>
        </form>
    </div>
    <?php endforeach; ?>

</main>
</body>
</html>
