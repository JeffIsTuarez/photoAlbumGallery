<?php require 'header.php'
?>
<?php
	require_once 'config.php';
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	$result = $mysqli->query("SELECT albumTitle, Albums.albumID, Pictures.photoID, photoSource, caption 
	FROM Albums 
	INNER JOIN Associations ON Albums.albumID = Associations.albumID
	INNER JOIN Pictures ON Associations.photoID= Pictures.photoID");
	print("<table><thead><tr><th>Album Title</th><th>Album ID</th><th>Photo ID</th><th>Photo</th><th> Caption </th></tr></thead><tbody>");
	while ( $row = $result->fetch_row() ) 
	{
		print( "<tr>" );
		foreach( $row as $value ) 
		{
			if($value==$row[3])
			{
				print ("<td> <img src='Pictures/$value' /> </td>");
			}
			else
				print( "<td>$value</td>");
		}
		if(isset($_SESSION['logged_user']))
		{
			if($_SESSION['logged_user']=="jit8")
			{
				print "<td> <a href='editPic.php?id=$row[2]'> Edit </a></td>";
				print "<td> <a href='deletePic.php?id=$row[2]'>Delete </a></td>";
				print "<td> <a href='assocPic.php?id=$row[2]'> Add Association </a></td>";
				print "<td> <a href='delassocPic.php?id=$row[2]'> Remove Association </a></td>";
			}
		}
		print( "</tr>" );
	}
?>
<?php require 'footer.php'
?>
