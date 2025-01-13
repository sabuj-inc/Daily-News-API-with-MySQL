<?php
include_once('connection.php');
?>

<?php
if (isset($_GET['deleteid'])) {
    $website_url = $_GET['deleteid'];

    // SQL query to delete the record
    $sql = "DELETE FROM topweb WHERE website_url = '$website_url'";
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