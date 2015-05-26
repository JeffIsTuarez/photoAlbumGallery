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
	<h1 class="pageTitle">Delete Association</h1>
	<h3 class="description">Photo associated with another Album?</h3>
  
  <form action="delassocPic.php" method="post">
	<?php 
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	$maid= $_GET['id'];
	$result= $mysqli->query("SELECT * FROM Albums");
	$pictureResult= $mysqli->query("SELECT albumTitle, Albums.albumID, Pictures.photoID, photoSource, caption 
	FROM Albums 
	INNER JOIN Associations ON Albums.albumID = Associations.albumID
	INNER JOIN Pictures ON Associations.photoID= Pictures.photoID
	WHERE Pictures.photoID='$maid'");?>
	Album 
	<select name="albums">
		<?php
		if(empty($result))
		{
			print "<option value='null'> No Album detected, Make a new one </option>";
		}
		else
		{
			while ( $pictureRow=$pictureResult->fetch_assoc() ) 
			{
				$albumName=$pictureRow['albumTitle'];
				$albumID=$pictureRow['albumID'];
				print "<option value='$albumID'> $albumName </option>";
			}
		}
		?>
	</select>
	<?php print "<input type='hidden' name='photoID' value='$maid' />"; ?>
	<input type="submit"  name="submit"  value="Update" />
  </form>
  <?php } ?>
	<?php
	if(isset($_POST['submit']))
	{
	
		if($_POST['albums']=="null")
			{
					print "<p class='error'> Its associated to All </p>";
			}
		else
			{
				$albumID= $_POST['albums'];
				$photoID= $_POST['photoID'];
				require_once 'config.php';
				$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
				$result= $mysqli->query("DELETE FROM Associations WHERE albumID='$albumID' AND photoID='$photoID'");
				print "<p> Deleted Successfully </p>";
			}
	}
	?>
	</body>
</html>