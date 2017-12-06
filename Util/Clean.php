<?php
  function clean($str)
	{
	  $str = str_replace("'","`",$str);
		return $str;
	}
?>