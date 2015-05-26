<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }	
	if (isset($_SESSION['logged_user'])) {
		$olduser = $_SESSION['logged_user'];
		unset($_SESSION['logged_user']);
		
		// or this
		//session_destroy();
	} else {
		$olduser = false;
	}
?>

<?php
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

		<h1>Goodbye!</h1>

		<?php
			if ( $olduser ) {
				print("<p> Thanks for using our page, $olduser! You are now logged out\n </p>");
				print("<p> Return to our <a href='login.php'>login page</a>\n</p>");
			} else {
				print("<p class='error'> You haven't logged in.\n</p>");
				print("<p class='error'> Go to our <a href='login.php'>login page</a>\n</p>");
			}
		?>
	</body>
</html>