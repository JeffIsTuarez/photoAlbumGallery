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
  <h1 class="pageTitle">Make an Album </h1>
  <form action="albumCreate.php" method="post">
  Name of Album: <input type="text" maxlength="255" name="name"/>
  <input type="submit" name="submit" value="Create" />
  </form>
  
  <?php
 
	if(isset($_POST['submit']))
	{
		$name = trim(strip_tags($_POST['name']));
		if(!isset($name) || empty($name))
		{
			print "<p class='error'>The Name field is not filled out, please fill it out.</p>";
		}
		else
		{
			require_once 'config.php';
			$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
			$mysqli->query("INSERT INTO Albums(albumTitle, date_created) VALUES ('$name', NOW())");
			print "<p> Successfully Added </p>";
		}
	}
	?>
	</body>
</html>