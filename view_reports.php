<?php
// view_reports.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$user_id = $_SESSION['user_id'];

// Fetch all transactions for the user
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Transaction Reports</h2>

    <!-- Navigation Links -->
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= htmlspecialchars($transaction['date']) ?></td>
                    <td><?= htmlspecialchars($transaction['type']) ?></td>
                    <td><?= htmlspecialchars($transaction['category']) ?></td>
                    <td><?= htmlspecialchars($transaction['amount']) ?></td>
                    <td><?= htmlspecialchars($transaction['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
