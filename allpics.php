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
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	$result = $mysqli->query("SELECT * FROM Pictures");
	print("<table><thead><tr><th>PhotoID</th><th>Photo Source</th><th>Caption</th><th>Last Taken</th></tr></thead><tbody>");
	while ( $row = $result->fetch_row() ) 
	{
		print( "<tr>" );
		foreach( $row as $value ) 
		{
				print( "<td>$value</td>");
		}
		if(isset($_SESSION['logged_user']))
		{
			if($_SESSION['logged_user']=="jit8")
			{
				print "<td> <a href='editPic.php?id=$row[0]'> Edit </a></td>";
				print "<td> <a href='deletePic.php?id=$row[0]'>Delete </a></td>";
				print "<td> <a href='assocPic.php?id=$row[0]'> Add Association </a></td>";
				print "<td> <a href='delassocPic.php?id=$row[0]'> Remove Association </a></td>";
			}
		}
		print( "</tr>" );
	}
?>
	</body>
</html>
