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
	<h3 class="description"> Click on an Album to display all photos within that album! </h3>
<?php
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	$result = $mysqli->query("SELECT * FROM Albums ");
	print("<table><thead><tr><th>Album ID</th><th>Album Title</th><th>Date Created</th><th>Date Modified</th></tr></thead><tbody>");
	while ( $row = $result->fetch_row() ) 
	{
		print( "<tr>" );
		foreach( $row as $value ) 
		{
			if($value==$row[1])
			{
				print ("<td> <a href='albums.php?name=$value'> $value </a></td>");
				// Placeholder, gonna do something with this later, I think I have something...
			}
			else
				print( "<td>$value</td>");
		}
		if(isset($_SESSION['logged_user']))
		{
			if($_SESSION['logged_user']=="jit8")
			{
				print "<td> <a href='editAlbum.php?id=$row[0]&name=$row[1]'> Edit </a></td>";
				print "<td> <a href='deleteAlbum.php?id=$row[0]&name=$row[1]'>Delete </a></td>";
			}
		}
		print( "</tr>" );
	}
?>
<?php
	if(isset($_GET['name']))
	{		
		$name= $_GET['name'];
		$searchresult = $mysqli->query("SELECT albumTitle, Albums.albumID, Pictures.photoID, photoSource, dateTaken, caption 
		FROM Albums 
		INNER JOIN Associations ON Albums.albumID = Associations.albumID
		INNER JOIN Pictures ON Associations.photoID= Pictures.photoID
		WHERE albumTitle='$name'");
		if($searchresult->num_rows==0)
		{
		print "<p class='error'> No Pictures Found </p>";
		}
		else
		{
			print("<table><thead><tr><th>Album Title</th><th>Album ID</th><th>Photo ID</th><th>Photo</th><th>Date Taken </th><th> Caption </th></tr></thead><tbody>");
			while ( $row = $searchresult->fetch_row() ) 
			{
				print( "<tr>" );
				foreach( $row as $value ) 
				{
					if($value==$row[3])
					{
						print ("<td> <img src='Pictures/$value' /> </td>");
					}
					else
					{			
						print( "<td>$value</td>");
					}
				}
				print( "</tr>" );
			}
		}
	}
?>

	</body>
</html>
