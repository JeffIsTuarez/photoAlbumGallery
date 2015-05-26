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
	if(!(isset($_GET['id'])))
	{
		print "<p class='error'> Please Select a <a href='pictures.php'> Picture </a></p>";
	}
	else
	{
?>
		<h1 class="pageTitle">Edit Picture</h1>
			<form action="editPic.php" method="post">
			Caption:  <br /> <textarea name="caption" maxlength="255"></textarea>  <br />
			<?php $maid=$_GET['id'];
			print "<input type='hidden' name='photoID' value='$maid' />"; ?>
			<input type="submit" name="submit" value="Edit" />
		</form>
<?php } ?>
    <?php
 
	if(isset($_POST['submit']))
	{
		$caption = trim(strip_tags($_POST['caption']));
		$photoID=$_POST['photoID'];
		if(!isset($caption) || empty($caption))
		{
			print "<p class='error'>The Caption field is not filled out, please fill it out.</p>";			
		}
		else
		{
			
			require_once 'config.php';
			$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
			$mysqli->query("UPDATE Pictures SET caption='$caption' WHERE photoID= '$photoID'");
			print "<p> Successfully Edited. </p>";
		}
	}
	?>
	
	</body>
</html>