<?php
include_once('connection.php');
?>

<?php
if (isset($_GET['deleteid'])) {
    $email = $_GET['deleteid'];

    // SQL query to delete the record
    $sql = "DELETE FROM feedback WHERE email = '$email'";
    $run = mysqli_query($mysqli, $sql);

    if ($run) {
        echo "<h1>Data Deleted</h1>";
        header("Location: control.php");
        exit();
    } else {
        echo "<h1>Data not Deleted</h1>";
    }
}

// Close the database connection
$mysqli->close();
?>