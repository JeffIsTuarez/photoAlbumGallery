<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?><?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/weblayout.css">
		<title> Pics </title>
	</head>
	<body>
	<div id="title"> Snap! </div>
	<ul id="navigation">
			<li class="navigation-element"><a href="index.php">Home</a></li>					
			<li class="navigation-element"><a href="albums.php">Albums</a></li>
			<li class="navigation-element"><a href="albumSearch.php">Album Search</a></li>
			<li class="navigation-element"><a href="pictures.php">Pictures</a></li>
			
			
			<?php 
			if(isset($_SESSION['logged_user']) )
			{
				if(($_SESSION['logged_user'])=="jit8")
				{
					print "<li class='navigation-element'><a href='albumCreate.php'>Create Album</a></li>";
					print "<li class='navigation-element'><a href='allpics.php'>See All Pictures</a></li>";
				}
			print "<li class='navigation-element'><a href='logout.php'>Logout</a></li>";
			}
			else
			{
			print "<li class='navigation-element'><a href='login.php'>Login</a></li>";
			}
			?>
	</ul>
		<h1>Login Form</h1>
		<?php if(isset($_SESSION['logged_user']))
		{
			print "<p class='error'> You have already logged in, why not <a href='logout.php'> log out </a></p>";
		}
		else if ( ! isset( $_POST['username'] ) && ! isset( $_POST['password'] ) ) {
		?>
			<h1 class="pageTitle">Log in</h2>
			<form action="login.php" method="post">
				Username: <input type="text" name="username"> <br>
				Password: <input type="password" name="password"> <br>
				<input type="submit" value="Submit">
			</form>
			
		<?php

	} else {
		/* SQL to create a table that matches the fields used here
		 * username and password are the important fields. Since username
		 * has to be unique, you could use it for a primary key instead of creating
		 * a specific auto number field as I did here.
		 * You'll have to decide whether to have fields for first name, last name and anything else about users
		 *
		CREATE TABLE IF NOT EXISTS `users` (
		  `userID` int(11) NOT NULL AUTO_INCREMENT,
		  `hashpassword` varchar(64) NOT NULL,
		  `username` varchar(50) NOT NULL,
		  `name` varchar(50),
		  PRIMARY KEY (`userID`),
		  UNIQUE KEY `idx_unique_username` (`username`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		*/

		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		//Clean up the post data
		$username = strip_tags( $_POST['username'] );

		//hash the entered password for comparison with the db
		// print the password without hashed (TAKE OUT IMMEDIATELY)
		$password = hash("sha256",$_POST['password']);

		//Check for a record that matches the POSTed credentials
		$query = "SELECT * 
					FROM Users
					WHERE
						username = '$username'
						AND hashpassword = '$password'";

		//Uncomment the next line for debugging
		//echo "<p>$query</p>";

		$result = $mysqli->query($query);


		if ( $result && $result->num_rows == 1) {
			$row = $result->fetch_assoc();

			print("<p> Congratulations, ".$row['username'].". You have now logged in.\n </p><br />\n");
			$_SESSION['logged_user'] = $row['username'];

		} else {
			echo '<p>' . $mysqli->error . '</p>';
			?>
			<p class='error'>Invalid Login</p>
			<p class='error'>Please <a href="login.php">login</a> again.</p>
			<?php
			}
			
			$mysqli->close();
		} //end if isset username and password
		?>
	</body>
</html>
