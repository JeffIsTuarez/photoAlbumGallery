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