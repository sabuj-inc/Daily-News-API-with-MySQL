<?php
    // Database connection
    $username = "root";
    $password = "";
    $database = "mydatabase";

    // Create connection
    $mysqli = new mysqli("localhost", $username, $password, $database);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    echo "Connected successfully";
?>

<?php
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // SQL query to delete the record
    $sql = "DELETE FROM saved WHERE thumbnail = '$id'";
    $run = mysqli_query($mysqli, $sql);

    if ($run) {
        echo "<h1>Data Deleted</h1>";
        header("Location: index.php");
        exit();
    } else {
        echo "<h1>Data not Deleted</h1>";
    }
}

// Close the database connection
$mysqli->close();
?>