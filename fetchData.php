<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use prepared statements to prevent SQL injection
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM saved WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email); // Bind parameter
$stmt->execute();
$result = $stmt->get_result();

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data); // Return data as JSON
} else {
    echo json_encode([]); // Return empty array if no data found
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
