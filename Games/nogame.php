<?php
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="../Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="../Images/favicon.ico" rel="icon" type="image/bitmap">
</head>

<body> 
  <div id="header">
	  <?php
		  include("../Util/loginbox.php");
			print LoginBox($curFile);
		?>
	  <a href="../index.php"><img src="../Images/headimg.png" alt="22nd Century Games" name="22nd Century Games" class="headimg"/></a>
		<br>
		<div id="links">
		  <a href="../index.php" class="link">Home</a>
			<a href="../games.php" class="link">Games</a>
			<a href="../team.php" class="link">The Team</a>
			<a href="../contact.php" class="link">Contact us</a>
			<a href="../account.php" class="link">My Account</a>
		</div>
	</div>
	
	<div id="content">
		<h1 id="title">Not Released</h1>
		<p id="siteDesc">This game has not been released yet. Check out the "Development Updates" section for the game to see when it will be released.</p>
		<br>
  </div>
	
	<br>
	<div id="footer">
	  <?php
		  print "<p>Copyright &copy; 2011 ";
			if (date("Y")!=2011)
			print "- ".date("Y")." ";
			print "<a href=\"../index.php\">22nd Century Games</a><br>";
		?>
		<i>All rights reserved</i></p>
	</div>
</body>
</html>
