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
  <h1 class="pageTitle">Insert Pics </h1>
  <h3 class="description">Upload a Picture</h3>
  <?php 
  if((!isset($_SESSION['logged_user']) || ($_SESSION['logged_user']!='jit8')))
	{
	print "<p class='error'> You need an admin's permission, nudge nudge wink wink. </p>";
	}
	else
	{
  ?>
  <form action="index.php" method="post" enctype="multipart/form-data">
	Upload a Photo: <input type="file" name="newphoto" /> <br />
	<?php 
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	$result= $mysqli->query("SELECT * FROM Albums");?>
	Album 
	<select name="albums">
		<?php
		if(empty($result))
		{
			print "<option value='null'> No Album detected, Make a new one </option>";
		}
		else
		{
			while ( $row = $result->fetch_assoc() ) 
			{
				$albumName=$row['albumTitle'];
				print "<option value='$albumName'> $albumName </option>";
			}
		}
		?>
	</select>
	<a href="albumCreate.php" > Make an Album </a><br />
	Date Taken: <input type="datetime-local" name="bdaytime" /> <br />
	Caption:  <br /> <textarea name="caption" maxlength="255"></textarea>  <br />
	<input type="submit"  name="submit"  value="Upload photo" />
  </form>
  <?php } ?>
  <?php
 
	if(isset($_POST['submit']))
	{
		$numoferror=0;
		if($_FILES['newphoto']['error']!=0)
		{
			print "<p class='error'> Please Upload a file </p>";
			$numoferror++;
		}
		else
		{
			$caption= trim(strip_tags($_POST['caption']));
			if(empty($caption))
			{
				print "<p class='error'> Please Insert a Caption </p>";
				$numoferror++;
			}
			if($_POST['albums']=="null")
			{
				print "<p class='error'> Make a new album </p>";
				$numoferror++;
			}
			if($numoferror==0)
			{
				$photo = $_FILES['newphoto'];		
				$originalName = $photo['name'];
				$tempName = $photo['tmp_name'];
				$size_in_bytes = $photo[ 'size' ];
				$type = $photo['type'];
				$error = $photo['error'];
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $originalName);
				$extension = end($temp);
				if ((($type == "image/gif")
						|| ($type == "image/jpeg")
						|| ($type == "image/jpg")
						|| ($type == "image/pjpeg")
						|| ($type == "image/x-png")
						|| ($type == "image/png"))
						//&& ($_FILES["file"]["size"] < 20000)
						&& in_array($extension, $allowedExts))
				{
					if (file_exists("Pictures/" . $originalName))
					{
						print "<p class='error'> $originalName already exists. </p>";
					}
					else
					{
						print "<p class='error'> Success </p>";
						$albums= $_POST['albums'];
						$caption= trim(strip_tags($_POST['caption']));
						$time=$_POST['bdaytime'];
						$timepieces= explode("T", $time);
						$correctedTime=$timepieces[0]." ".$timepieces[1].":00";
						
						$specificResult= $mysqli->query("SELECT * FROM Albums WHERE albumTitle='$albums'");
						$specificRow = $specificResult->fetch_assoc();
						$albumID=$specificRow['albumID'];
						
						move_uploaded_file($tempName,"Pictures/$originalName");
							print "<p class='error'> Stored in: Pictures/$originalName </p>";
						$mysqli->query("INSERT INTO Pictures(photoSource, caption, dateTaken) VALUES ('$originalName', '$caption', '$correctedTime')");
						$mysqli->query("INSERT INTO Associations(albumID, photoID) VALUES ('$albumID', (SELECT photoID FROM Pictures WHERE photoSource='$originalName'))"); 
						$mysqli->query("UPDATE Albums SET date_modified = now() WHERE albumName='$albums'");
					}
				}
				else
				{
					print "<p class='error'> Wrong File Format </p>";
					$numoferror++;
				}
			}
			else
			{
				print "<p class='error'> Please fix your fields before we consider reading the file </p>";
			}
		}
	}
	?>
	</body>
</html>