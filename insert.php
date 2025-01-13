<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email'], $data['thumbnail'], $data['title'], $data['newsLink'], $data['websiteLogo'], $data['websiteName'])) {
    // Prepare and bind statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO saved (email, thumbnail, title, newsLink, websiteLogo, websiteName) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssss", 
        $data['email'], 
        $data['thumbnail'], 
        $data['title'], 
        $data['newsLink'], 
        $data['websiteLogo'], 
        $data['websiteName']
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
