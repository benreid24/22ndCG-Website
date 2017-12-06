<?php
  function Footer($curFile)
	{
    $var = "<p><a href=\"Util/error.php?ref=$curFile\">Spotted an error?</a><br>";	
	  $var .= "Copyright &copy; 2011 ";
		if (date("Y")!=2011)
		$var .= "- ".date("Y")." ";
		$var .= "<a href=\"index.php\">22nd Century Games</a>";
		$var .= "<br><i>All Rights Reserved</i></p>";
		return $var;
	}
?>