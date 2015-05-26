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
	<h1 class="pageTitle">Search for Pictures within an Album </h1>
	<h3 class="description"></h3>
	<form action="albumSearch.php" method="post">
	<?php 
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	?>
	Album: <input type="text" maxlength="255" name="album" /> <br />
	Caption:  <br /> <textarea name="caption" maxlength="255"></textarea>  <br />
	<input type="submit"  name="submit"  value="Search" />
	</form>
	<?php
 
	if(isset($_POST['submit']))
	{
		$albumName=trim(strip_tags($_POST['album']));
		$caption=trim(strip_tags($_POST['caption']));
		$searchResult= $mysqli->query("SELECT albumTitle, Pictures.photoID, photoSource, caption 
		FROM Albums INNER JOIN Associations ON Albums.albumID =  Associations.albumID
		INNER JOIN Pictures ON Pictures.photoID= Associations.photoID 
		WHERE albumTitle LIKE '%$albumName%' AND caption LIKE '%$caption%'");
		if($searchResult->num_rows==0)
		{
			print "<p class='error'> None Found </p>";
		}
		else
		{
			print("<table><thead><tr><th>Album Title</th><th>Photo ID</th><th>Photo Source</th><th>Caption</th></tr></thead><tbody>");
				while ( $row = $searchResult->fetch_row() ) 
				{
					print( "<tr>" );
					foreach( $row as $value ) 
					{
						if($value==$row[2])
						{
							print ("<td> <img src='Pictures/$value' /> </td>");							
						}
						else
							print( "<td>$value</td>");
					}
					print( "</tr>" );
				}
		}
	}
	?>
	</body>
</html>