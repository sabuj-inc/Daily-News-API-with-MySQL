<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, 
                         initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" 
          href="style.css">
</head>

<body>
    <header>
        <h1 class="heading">Admin</h1>
        <p class="error"></p>
    </header>

    <!-- container div -->
    <div class="container">
        <div class="btn">
            <button class="clkbtn">Login</button>
        </div>

        <!-- Form section that contains the
             login and the signup form -->
        <div class="form-section">

            <!-- login form -->
            <form action="" method="post">
                <div class="login-box">
                    <input type="email" name="user_email" class="email ele" placeholder="youremail@email.com">
                    <input type="password" name="user_password" class="password ele" placeholder="password">
                    <input type="submit" name="login" class="clkbtn">
                </div>
            </form>


        </div>
    </div>

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

	if (isset($_POST['login'])) {
        if (!empty($_POST['user_email']) && !empty($_POST['user_password'])) {
            $user_email = $mysqli->real_escape_string($_POST['user_email']);
            $user_password = $mysqli->real_escape_string($_POST['user_password']);
    
            $sql = "SELECT user_password FROM registration WHERE user_email = '$user_email'";
            $result = $mysqli->query($sql);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
    
                if ($user_password === $row['user_password']) {
                    session_start();
                    $_SESSION['user_email'] = $user_email;
                    header("Location: control.php");
                    exit();
                } else {
                    echo "<script>document.querySelector('.error').textContent = 'Invalid password. Please try again.';</script>";
                }
            } else {
                echo "<script>document.querySelector('.error').textContent = 'Email not found. Please register.';</script>";
            }
        } else {
            echo "<script>document.querySelector('.error').textContent = 'All fields are required.';</script>";
        }
    }
?>


</body>
</html>