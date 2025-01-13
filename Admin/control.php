<!DOCTYPE html>

<head>
	<link rel="stylesheet" href="control_style.css"/>
	<title>Admin Panel</title>
	
	
	<style>
	*{
		font-family: sans-serif;
	}

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
	
	  .loginButton {
		padding: 0px 20px;
		background-color: blue;
		color: #ffffff;
		border: none;
		border-radius: 5px;
		cursor: pointer;
  }
	</style>
</head>

<body>

<?php
include_once('connection.php');
?>
<a href="http://localhost/project/index.php">Home</a>


    <div class="addFollowing">

	
			<h3>Top Newspaper</h3>

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
			<a href='top_news_delete.php?deleteid=$website_url'><img src='deleteicon.png' alt='Delete' class='delete-btn'/></a>
		</div>";

		
		
		
    }
    echo "</div>";
} else {
    echo "<p>No websites found.</p>";
}
?>
			
<br><br>
	
		<!-- login form -->
		<form action="" method="post">
			<input type="text" name="website_name" class="item" placeholder="Website Name">
			<p class="error"></p>
			<input type="text" name="website_url" class="item" placeholder="Website URL">
			<p class="error"></p>
			<input type="submit" name="submit" class="clkbtn">
		</form>

		<?php

		if (isset($_POST['submit'])) {
			if (!empty($_POST['website_name']) && !empty($_POST['website_url'])) {
				$website_name = $mysqli->real_escape_string($_POST['website_name']);
				$website_url = $mysqli->real_escape_string($_POST['website_url']);

				$sql = "INSERT INTO topweb (website_name, website_url) VALUES (?, ?)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ss", $website_name, $website_url);

				if ($stmt->execute()) {
					// Redirect to the same page after successful registration
					header("Location: " . $_SERVER['PHP_SELF']);
					exit; // Ensure no further code is executed after the redirect
				} else {
					echo "<script>document.querySelector('.error').textContent = 'Error: " . $stmt->error . "';</script>";
				}
			} else {
				echo "<script>document.querySelector('.error').textContent = 'All fields are required.';</script>";
			}
		}
		?>
	</div>

    <div class="feedback">
<h3>User Feedback</h3>

			<?php
		// SQL query
		$sql = "SELECT * FROM feedback";

		echo '<table id="customers">
		<tr>
			<th>Name</th>
			<th>Email Id</th>
			<th>Message</th>
			<th>Delete</th>
		</tr>';

		if ($result = $mysqli->query($sql)) {
			while ($row = $result->fetch_assoc()) {
				$user_name = $row["user_name"];
				$user_email = $row["email"];
				$message = $row["message"];
				echo '<tr>
				<td>' . $user_name . '</td>
				<td>' . $user_email . '</td>
				<td>' . $message . '</td>

				<td>
						<a href="single_delete.php?deleteid=' . $user_email . '" class="btn btn-primary" style="text-decoration: none;">Delete</a>
					</td>

				</tr>';
			}
			$result->free();
		}
		$mysqli->close();
		?>
    </div>



</body>

</html>