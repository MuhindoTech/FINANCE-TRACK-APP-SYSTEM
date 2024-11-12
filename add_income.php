<?php
// add_income.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, type, amount, category, date, description) VALUES (?, 'income', ?, ?, ?, ?)");
    $stmt->execute([$user_id, $amount, $category, $date, $description]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Income</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Income</h2>
    <form method="POST">
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Category:</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date:</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Income</button>
    </form>
</div>
</body>
</html>
