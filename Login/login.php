<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, 
                         initial-scale=1.0">
    <title>Daily News</title>
    <link rel="stylesheet" 
          href="style.css">
</head>

<body>
    <header>
        <h1 class="heading">Daily News</h1>
        <p class="error"></p>
    </header>

    <!-- container div -->
    <div class="container">

        <!-- upper button section to select
             the login or signup form -->
        <div class="slider"></div>
        <div class="btn">
            <button class="login">Login</button>
            <button class="signup">Signup</button>
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
            <!-- signup form -->

            <form action="" method="post">
                <div class="signup-box">
                    <input type="text" name="user_name" class="name ele" placeholder="Enter your name">
                    <input type="email" name="user_email" class="email ele" placeholder="youremail@email.com">
                    <input type="password" name="user_password" class="password ele" placeholder="password">
                    <input type="password" name="repassword" class="password ele" placeholder="Confirm password">
                    <input type="submit" name="register" value="Register" class="clkbtn">
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

    if (isset($_POST['register'])) {
        // Registration logic
        if (!empty($_POST['user_name']) && 
            !empty($_POST['user_email']) && 
            !empty($_POST['user_password']) && 
            $_POST['user_password'] === $_POST['repassword']) {
            
            $user_name = $mysqli->real_escape_string($_POST['user_name']);
            $user_email = $mysqli->real_escape_string($_POST['user_email']);
            $user_password = $mysqli->real_escape_string($_POST['user_password']); // Plain text password
    
            $sql = "INSERT INTO registration (user_name, user_email, user_password) 
                    VALUES ('$user_name', '$user_email', '$user_password')";
    
            if ($mysqli->query($sql)) {
                echo "<script>document.querySelector('.error').textContent = 'Registration Successful.';</script>";
            } else {
                echo "<script>document.querySelector('.error').textContent = 'Error: " . $mysqli->error . "';</script>";
            }
        } else {
            echo "<script>document.querySelector('.error').textContent = 'All fields are required and passwords must match.';</script>";
        }
    } elseif (isset($_POST['login'])) {
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
                    header("Location: http://localhost/project/index.php");
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


    <script>
        let signup = document.querySelector(".signup");
        let login = document.querySelector(".login");
        let slider = document.querySelector(".slider");
        let formSection = document.querySelector(".form-section");

        signup.addEventListener("click", () => {
            slider.classList.add("moveslider");
            formSection.classList.add("form-section-move");
        });

        login.addEventListener("click", () => {
            slider.classList.remove("moveslider");
            formSection.classList.remove("form-section-move");
        });

    </script>
</body>
</html>