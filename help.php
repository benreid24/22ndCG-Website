<?php
  include("Util/Clean.php");
  include("Util/Config.php");
  session_start();
	$website = mysql_connect("localhost", get_db_username(), get_db_password());
	mysql_select_db("hqlkiaju_Main", $website);
	
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="Styles/help.css" rel="stylesheet" type="text/css">
	<link href="Images/favicon.ico" rel="icon" type="image/bitmap">
</head>

<body> 
  <div id="header">
	  <?php
		  include("Util/loginbox.php");
			print LoginBox($curFile);
		?>
	  <a href="index.php"><img src="Images/headimg.png" alt="22nd Century Games" name="22nd Century Games" class="headimg"/></a>
		<br>
		<div id="links">
		  <a href="index.php" class="link">Home</a>
			<a href="games.php" class="link">Games</a>
			<a href="team.php" class="link">The Team</a>
			<a href="contact.php" class="link">Contact us</a>
			<a href="account.php" class="link">My Account</a>
		</div>
	</div>
	
	<div id="content">
		<h1 id="title">Development Status Descriptions</h1>
		<p id="siteDesc">You know all those crazy sounding words we use and you don't have any idea what they mean? Find out their meanings here.</p>
		  <div class="wrap"><p class="pair"><span class="term">Conceptual:</span>    <span class="deff">The game is nothing more than an idea. Games in this stage may or may not actually go on to become anything.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Early Design:</span>    <span class="deff">This means that we thought the game concept was worth a shot. In this stage, various ideas and concepts are brainstormed for the game. Games in this stage still aren't guaranteed to be finished, as critical design flaws are often discovered at this point.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Mid Design:</span>    <span class="deff">Games in this stage are almost to the production phase. They will probably go on to become actual games, but still have a ways to go.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Late Design:</span>    <span class="deff">The design for games in this stage is practically finished and there may be some test programs to ensure that certain features will actually work. Production for these games will start within a week and they are sure to become actual games.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Early Production:</span>    <span class="deff">Production of various parts of games in this stage has begun. This can include anything from web interfaces, development tools, game engines or servers. Depending on what we started making first, demos may or may not be available.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Mid Production:</span>    <span class="deff">Various parts of the game have been completed by this stage. There are probably at least some demos released, depending on what was finished.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Late Production:</span>    <span class="deff">Most of the components of the game have been completed by this stage. Release of the game will be in a few weeks.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Pre-Release QA:</span>    <span class="deff">The game has been finished by this point and is simply being checked for bugs and errors before being released (QA - Quality Assurance).</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Released (Updated):</span>    <span class="deff">The game has been released and updates are actively being developed/released. If the game has online features, it will update automatically through the server.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Released (Abandoned):</span>    <span class="deff">The game has been released, however it is no longer being updated.</span></p></div><br><br>
			<div class="wrap"><p class="pair"><span class="term">Suspended:</span>    <span class="deff">Development has been temporarily stoppped for some reason. It is possible that it becomes a permanent cancelation.</span></p></div><br><br>
		  <div class="wrap"><p class="pair"><span class="term">Canceled:</span>    <span class="deff">Development has been completely canceled and will most likely never be restarted.</span></p></div><br><br>
		<br>
  </div>
	
	<br>
	<div id="footer">
	  <?php
		  include("Util/Footer.php");
			print Footer($curFile);
		?>
	</div>
</body>
</html>
