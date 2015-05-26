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
<?php
	if((!isset($_SESSION)||($_SESSION['logged_user']!='jit8')))
	{
		print "<p class='error'> Don't be sneaky, you can't edit using hax or you aren't me, gtfo. </p>";
	}
	if(!(isset($_GET['name']) && isset($_GET['id'])))
	{
		print "<p class='error'> Please Select an <a href='albums.php'> Album </a></p>";
	}
	else
	{
?>
		<h1 class="pageTitle">Edit Album : <?php print $_GET['name'] ?></h1>
			<form action="editAlbum.php" method="post">
			Name of Album: <input type="text" maxlength="255" name="name" />
			<?php $maid=$_GET['id'];
			print "<input type='hidden' name='albumID' value='$maid' />"; ?>
			<input type="submit" name="submit" value="Create" />
		</form>
<?php } ?>
    <?php
 
	if(isset($_POST['submit']))
	{
		$name = trim(strip_tags($_POST['name']));
		$albumID=$_POST['albumID'];
		if(!isset($name) || empty($name))
		{
			print "<p class='error'>The Name field is not filled out, please fill it out.</p>";			
		}
		else
		{
			
			require_once 'config.php';
			$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
			$mysqli->query("UPDATE Albums SET albumTitle='$name', date_modified= NOW() WHERE albumID= '$albumID'");
			print "<p> Successfully Edited. </p>";
		}
	}
	?>
	
	</body>
</html>