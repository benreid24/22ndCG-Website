<?php
	$curFile = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
  <title>22nd Century Games</title>
  <link href="../Styles/styles.css" rel="stylesheet" type="text/css">
	<link href="../Styles/games.css" rel="stylesheet" type="text/css">
	<link href="../Images/favicon.ico" rel="icon" type="image/bitmap">
	<script language="JavaScript" type="text/javascript" src="../Util/Timer.js"></script>
</head>

<body onload="UpdateRelTime('relTime')">
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
	  <h1 id="title">Download <a href="../games.php?game=8">Peoplemon</a></h1>
		<p id="siteDesc">Sorry! Peoplemon has not yet been released. Be sure to check back here often for demos and the actual release.</p>
		<br><br>
		<!--
		<div style="margin-left: auto; margin-right: auto;">
		<div style="width: 450px; background: #ccccff; border: 2px solid #0000ff; border-radius: 10px;margin-left: auto; margin-right: auto;">
		<h3><a href="PeopleMon Demo 2.14.9.34.rar">Demo 2.14.9.34</a> (rar format)</h3>
		<p style="text-indent: 30pt;">This demo has added features such as shading and physics, as well as several bug fixes. Download size is 21.2MB.</p><br>
		</div>
		<br>
		<div style="width: 450px; background: #ccccff; border: 2px solid #0000ff; border-radius: 10px;margin-left: auto; margin-right: auto;">
		<h3><a href="PeopleMon Demo 1.6.9.87.rar">Demo 1.6.9.87</a> (rar format)</h3>
		<p style="text-indent: 30pt;">Here is a basic demo, without much implemented but walking and running. Download size is 17.4Mb.</p><br>
		</div>
		</div>
		
		<br><h2 class="gmName">Release Info:</h2>
		<?php
		  //include ("../Util/datediff.php");
			//$relDate = "2012-03-9";
			
		//	print "<p><span class=\"gmTxt\">Release Date:</span> <span class=\"gmDevStat\">March 9th, 2012</span></p>";
		//  print "<p><span class=\"gmTxt\">Time to release:</span> <span class=\"gmDevStat\" id=\"relTime\">".dateDiff(strtotime($relDate), time())."</span></p>";

		?> -->
  </div>
	
	<br>
	<div id="footer">
	  <?php
		  include("../Util/Footer.php");
			print Footer($curFile);
		?>
	</div>
</body>
</html>
