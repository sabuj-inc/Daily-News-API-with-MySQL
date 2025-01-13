<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily News</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	
		<link rel="stylesheet" href="css/ionicons.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="styles.css">
		
		<style>
		
		
    .website-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .website-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 0;
        border-bottom: 1px solid #ddd;
    }

    .website-item img {
        width: 24px;
        height: 24px;
        border-radius: 5px;
        object-fit: contain;
    }

    .website-item a {
        text-decoration: none;
        font-size: 16px;
        color: #333;
        font-weight: bold;
    }

    .website-item a:hover {
        color: #007bff;
    }
	
.topNews {
  width: 90%;
  background-color: #efefef;
  padding:15px;
  border-radius: 15px;
  margin: 10px auto; /* Center horizontally */
}
	.topNews span{
		font-size:10px;
	}
		</style>

</head>

<body>

    <header>
        <a href="index.php"><div class="head">
            <div class="logo">
                <h1><span style="background-color: blue;color: wheat;padding: 10px;border-radius: 5px;">Daily</span>
                    News</h1>
            </div>
        </a>
            <?php
session_start();
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
	
?>

<div class="login_section">
    <?php if (isset($_SESSION['user_email'])): ?>
        <!-- Profile Dropdown for Logged-In Users -->
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="image/profile.png" alt="Dropdown Icon" style="width: 30px; height: 30px;">
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#" id="user_name">
                <?php echo htmlspecialchars($_SESSION['user_email']); ?>
            </a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    <?php else: ?>
        <!-- Login Button for Guests -->
        <button class="btn btn-secondary" id="loginbutton" onclick="window.location.href='login/login.php';">Login</button>
    <?php endif; ?>
</div>

<br>
<br>
<br>


            </div>
        </div>



        <a class="weatherwidget-io" href="https://forecast7.com/en/23d8190d41/dhaka/" data-label_1="DHAKA"
            data-label_2="WEATHER" data-theme="original">DHAKA WEATHER</a>
        <script>
        ! function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://weatherwidget.io/js/widget.min.js';
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, 'script', 'weatherwidget-io-js');
        </script>

        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search for topics, locations & sources">
            <button id="search-btn">🔍</button>
        </div>

        <nav>
            <ul id="category-nav">
                <li data-category="general">Home</li>
				<li data-category="Saved">Saved</li>
                <li data-category="business">Business</li>
                <li data-category="entertainment">Entertainment</li>
                <li data-category="health">Health</li>
                <li data-category="science">Science</li>
                <li data-category="sports">Sports</li>
                <li data-category="technology">Technology</li>
                
            </ul>
        </nav>

    </header>



  <div class="topNews" id="topNews">
	
	
	
			<h3>Top Newspaper <span onClick="hideTopNews()">Hide<span></h3>

		<?php	
		$sql = "SELECT website_name, website_url FROM topweb";
$result = $mysqli->query($sql);

// Display data
if ($result->num_rows > 0) {
    echo "<div class='website-list'>";
    while ($row = $result->fetch_assoc()) {
        $website_name = htmlspecialchars($row['website_name']);
        $website_url = htmlspecialchars($row['website_url']);
        $favicon_url = "https://logo.clearbit.com/" . parse_url($website_url, PHP_URL_HOST);

        echo "
        <div class='website-item'>
            <img src='$favicon_url' alt='Favicon'>
            <a href='$website_url' target='_blank'>$website_name</a>
        </div>";
    }
    echo "</div>";
} else {
    echo "<p>No websites found.</p>";
}
?>

</div>


<div id="dataListContainer"></div>
    <main id="news-container">

        <div id="loading" style="display: none;">Loading...</div>
		
		
    </main>
	
	
	<br>
	<br>
	<br><br>
    		<footer class="footer-02">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-10 col-lg-6">
						<div class="subscribe mb-5">
							<form action="#" class="subscribe-form">
                <div class="form-group d-flex">
                  <input type="text" class="form-control rounded-left" placeholder="Enter email address">
                  <input type="submit" value="Subscribe" class="form-control submit px-3">
                </div>
              </form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-lg-5">
					<h3 class="mb-0">Feedback</h3>
<div class="row">
    <form action="" method="post">
        <input type="text" class="form-control rounded-left" name="user_name" placeholder="Enter Your Name" required>
        <p></p>
        <input type="email" class="form-control rounded-left" name="user_email" placeholder="Enter Your Email" required>
        <p></p>
        <textarea class="form-control rounded-left" name="message" placeholder="Your Message" rows="4" required></textarea>
        <p></p>
        <input type="submit" class="form-control submit px-3" value="Submit">
    </form>

    <?php
        // Database connection details
        $username = "root";
        $password = "";
        $database = "mydatabase";

        // Create connection
        $mysqli = new mysqli("localhost", $username, $password, $database);

        // Check connection
        if ($mysqli->connect_error) {
            die("<h1>Connection failed: " . $mysqli->connect_error . "</h1>");
        }

        // Form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = trim(htmlspecialchars($_POST['user_name']));
            $user_email = trim(htmlspecialchars($_POST['user_email']));
            $message = trim(htmlspecialchars($_POST['message']));

            // Validate form inputs
            if (!empty($user_name) && !empty($user_email) && !empty($message)) {
                if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) { // Validate email
                    $user_name = $mysqli->real_escape_string($user_name);
                    $user_email = $mysqli->real_escape_string($user_email);
                    $message = $mysqli->real_escape_string($message);

                    // SQL query
                    $sql = "INSERT INTO feedback (user_name, email, message) VALUES ('$user_name', '$user_email', '$message')";

                    // Execute query
                    if ($mysqli->query($sql)) {
                        echo "<script>alert('Submitted Successfully!');</script>";
                    } else {
                        echo "<h1>Error: " . $mysqli->error . "</h1>";
                    }
                } else {
                    echo "<h2>Invalid email address.</h2>";
                }
            } else {
                echo "<h2>All fields are required.</h2>";
            }
        }
        $mysqli->close(); // Close the database connection
    ?>
</div>



					</div>
					<div class="col-md-8 col-lg-7">
						<div class="row">
							<div class="col-md-3 mb-md-0 mb-4 border-left">
								<h2 class="footer-heading">Discover</h2>
								<ul class="list-unstyled">
		              <li><a href="#" class="py-1 d-block">Merchant</a></li>
		              <li><a href="#" class="py-1 d-block">Giving back</a></li>
		              <li><a href="#" class="py-1 d-block">Help &amp; Support</a></li>
		            </ul>
							</div>
							<div class="col-md-3 mb-md-0 mb-4 border-left">
								<h2 class="footer-heading">About</h2>
								<ul class="list-unstyled">
		              <li><a href="#" class="py-1 d-block">Staff</a></li>
		              <li><a href="#" class="py-1 d-block">Team</a></li>
		              <li><a href="#" class="py-1 d-block">Careers</a></li>
		              <li><a href="#" class="py-1 d-block">Blog</a></li>
		            </ul>
							</div>
							<div class="col-md-3 mb-md-0 mb-4 border-left">
								<h2 class="footer-heading">Resources</h2>
								<ul class="list-unstyled">
		              <li><a href="#" class="py-1 d-block">Security</a></li>
		              <li><a href="#" class="py-1 d-block">Global</a></li>
		              <li><a href="#" class="py-1 d-block">Charts</a></li>
		              <li><a href="#" class="py-1 d-block">Privacy</a></li>
		            </ul>
							</div>
							<div class="col-md-3 mb-md-0 mb-4 border-left">
								<h2 class="footer-heading">Social</h2>
								<ul class="list-unstyled">
		              <li><a href="#" class="py-1 d-block">Facebook</a></li>
		              <li><a href="#" class="py-1 d-block">Twitter</a></li>
		              <li><a href="#" class="py-1 d-block">Instagram</a></li>
		              <li><a href="#" class="py-1 d-block">Googleplus</a></li>
		            </ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row partner-wrap mt-5">
					<div class="col-md-12">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="mb-0">Our Partner:</h3>
							</div>
							<div class="col-md-9">
								<p class="partner-name mb-0">
									<a href="#"><span class="ion-logo-ionic mr-2"></span>The Daily Star</a>
									<a href="#"><span class="ion-logo-ionic mr-2"></span>Dhaka Tribune</a>
									<a href="#"><span class="ion-logo-ionic mr-2"></span>Daily Sun</a>
									<a href="#"><span class="ion-logo-ionic mr-2"></span>The Financial Express</a>
									<a href="#"><span class="ion-logo-ionic mr-2"></span>The Independent</a>
									<a href="#"><span class="ion-logo-ionic mr-2"></span>Jugantor</a>
								</p>
							</div>
							<div class="col text-md-right">
								<p class="mb-0"><a href="#" class="btn-custom">See All <span class="ion-ios-arrow-round-forward"></span></a></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-5">
          <div class="col-md-6 col-lg-8">

            <p class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved  by Daily News</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
          <div class="col-md-6 col-lg-4 text-md-right">
          	<p class="mb-0 list-unstyled">
          		<a class="mr-md-3" href="#">Terms</a>
          		<a class="mr-md-3" href="#">Privacy</a>
          		<a class="mr-md-3" href="#">Compliances</a>
          	</p>
          </div>
        </div>
			</div>
		</footer>
    

	<script src="myscript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script>
	function hideTopNews(){
		document.getElementById("topNews").style.display = "none"; // Hide "dataListContainer"

}
	</script>
	
	
	
</body>

</html>