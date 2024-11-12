<?php
// dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';  // Include the database config file

$user_id = $_SESSION['user_id'];

// Calculate total income, expenses, and cash on hand
$income_stmt = $pdo->prepare("SELECT SUM(amount) AS total_income FROM transactions WHERE user_id = ? AND type = 'income'");
$income_stmt->execute([$user_id]);
$total_income = $income_stmt->fetchColumn() ?? 0;

$expense_stmt = $pdo->prepare("SELECT SUM(amount) AS total_expenses FROM transactions WHERE user_id = ? AND type = 'expense'");
$expense_stmt->execute([$user_id]);
$total_expenses = $expense_stmt->fetchColumn() ?? 0;

$cash_on_hand = $total_income - $total_expenses;

// Fetch recent transactions
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC LIMIT 5");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Finance Dashboard</h2>
    
    <!-- Navigation Links -->
    <a href="add_income.php" class="btn btn-success mb-3">Add Income</a>
    <a href="add_expense.php" class="btn btn-danger mb-3">Add Expense</a>
    <a href="view_reports.php" class="btn btn-info mb-3">View Reports</a>
    <a href="logout.php" class="btn btn-secondary mb-3">Logout</a>

    <h4>Summary</h4>
    <div class="card mt-3">
        <div class="card-body">
            <h5>Total Income: $<?= number_format($total_income, 2) ?></h5>
            <h5>Total Expenses: $<?= number_format($total_expenses, 2) ?></h5>
            <h5>Cash on Hand: $<?= number_format($cash_on_hand, 2) ?></h5>
        </div>
    </div>

    <h4>Recent Transactions</h4>
    <table class="table mt-3">
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
