<?php
// Define database connection parameters
$serverName = "DESKTOP-EQ55Q8H\SQLEXPRESS01"; // Replace with your server name
$connectionOptions = array(
    "Database" => "BooksTracker3", // Your database name
    "Uid" => "projekti", // Replace with your SQL Server username
    "PWD" => "projekt123" // Replace with your SQL Server password
);

// Establishes the connection
$conn = sqlsrv_connect( $serverName, $connectionOptions );

// Check if the connection was successful
if( !$conn ) {
    die( print_r(sqlsrv_errors(), true));
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    // Get the form values
    $bookTitle = $_POST['book-title'];
    $author = $_POST['author'];
    $readDate = $_POST['read-date'];
    
    // Prepare SQL query to insert data into Books table
    $sql = "INSERT INTO Books (UserID, Title, Author, ReadDate) VALUES (?, ?, ?, ?)";
    
    // Bind parameters to the SQL query
    $params = array(1, $bookTitle, $author, $readDate);  // Use '1' as UserID for now (you can dynamically get it from the session)
    
    // Execute the query
    $stmt = sqlsrv_query( $conn, $sql, $params );
    
    // Check if the query was successful
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Book added successfully!";
    }
}

// Close the connection
sqlsrv_close($conn);
?>
