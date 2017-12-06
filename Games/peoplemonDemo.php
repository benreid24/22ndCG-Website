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
	  <h1 id="title">Download the <a href="../games.php?game=8">Peoplemon Demo</a>!</h1>
		<p id="siteDesc">The Peoplemon Demo now has support for OS X! If you felt left out by the intial Windows-only release this is your chance to cease being a Peoplemon outcast. Simply click on the appropriate system below to download the right version of the demo</p>
		<br><br>

		<div style="margin-left: auto; margin-right: auto;">
		<div style="width: 450px; background: #ccccff; border: 2px solid #0000ff; border-radius: 10px;margin-left: auto; margin-right: auto;">
		<h3><a href="InstallPeoplemon.exe">Windows</a></h3>
		<p style="text-indent: 30pt;">Download this if you're running Windows. Anything later than Windows 7 should work. Smartscreen will probably prevent it from running, but if you click "More Info" there will be an option to run it anyways. The reason this shows up is because the executable isn't signed and we're too poor to afford to sign it (the developer license is $100 per year)</p><br>
		</div>
		<br>
		<!--<div style="width: 450px; background: #ccccff; border: 2px solid #0000ff; border-radius: 10px;margin-left: auto; margin-right: auto;">
		<h3><a href="Peoplemon.tar.gz">Linux</a></h3>
		<p style="text-indent: 30pt;">Peoplemon for our more technical players! As such, support is minimal. Simply extract the archive and run the enclosed binary file to play. You'll need to install openAL to get it to run. There's too many distros for us to support them all, but we'd be happy to help if you can't figure it out</p><br>
		</div>
		<br> -->
		<div style="width: 450px; background: #ccccff; border: 2px solid #0000ff; border-radius: 10px;margin-left: auto; margin-right: auto;">
		<h3><a href="Peoplemon.dmg">OS X</a></h3>
		<p style="text-indent: 30pt;">Peoplemon for our questionably more "refined" players! Simply download and drag Peoplemon into your Applications folder to play. You may have to tell Gatekeeper to allow all apps in order to run. To do this go to System Preferences > Security and Privacy and check the button "Anywhere" under "Allow apps downloaded from:". You'll have to unlock the menu to make the change. The reason you have to do this is because the Apple developer license is $100 per year and we're poor</p><br>
		</div>
		</div>
		
		<br>
		<h2 class="gmName">System Requirements:</h2>
		<p class="siteDesc">None! We're pretty sure Peoplemon could run on a toaster, maybe two toasters glued together. More seriously though, anything with a dual core processor and 2 GB of RAM should do. You'll only need about 60 MB of hard drive space too</p>
		<?php
		  //include ("../Util/datediff.php");
			//$relDate = "2012-03-9";
			
		//	print "<p><span class=\"gmTxt\">Release Date:</span> <span class=\"gmDevStat\">March 9th, 2012</span></p>";
		//  print "<p><span class=\"gmTxt\">Time to release:</span> <span class=\"gmDevStat\" id=\"relTime\">".dateDiff(strtotime($relDate), time())."</span></p>";

		?>
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
