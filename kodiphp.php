<?php
// Connection to SQL Server
$serverName = "DESKTOP-EQ55Q8H\SQLEXPRESS01";
$connectionInfo = array("Database" => "BooksTracker3", "UID" => "projekti", "PWD" => "projekt123");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Handle Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $params = array($username, $password);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_fetch_array($stmt)) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password!";
    }
}

// Handle Add Expense
if (isset($_POST['add_expense'])) {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $userId = 1; // Replace with actual user ID after login.

    $query = "INSERT INTO expenses (user_id, description, amount) VALUES (?, ?, ?)";
    $params = array($userId, $description, $amount);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Expense added successfully!";
    }
}

sqlsrv_close($conn);
?>
