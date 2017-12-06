<?php
  $ip = $_GET['serverIp'];
  $cmd = $_GET['cmd'];
	$ver = $_GET['ver'];
	
	if ($cmd=="set")
	{
	  if ($ver=="AdS23$%g6H")
		{
		  $file = fopen("Sip.ipf", "w");
			fwrite($file, $ip);
			fclose($file);
		}
	}
	else if ($cmd=="get")
	{
	  $file = fopen("Sip.ipf", "r");
		$ip = fread($file, 50);
		fclose($file);
		print $ip;
	}
?>