<?php
	function LoginBox($curFile)
	{
	  $var = "<div id=\"loginbox\">";
	  $username = $_SESSION['name'];
		$admin = $_SESSION['admin'];
		
		if (!$username || $username=="out")
		{
		  $var .= "<form action=\"http://www.22ndcg.com/login.php\" method=\"post\">";
			$var .= "<input type=\"hidden\" name=\"referer\" value=\"$curFile\"/>";
			$var .= "Username: <input type=\"text\" name=\"name\" size=\"17\"/><br>";
			$var .= "Password: <input type=\"password\" name=\"pw\" size=\"17\"/><br>";
			$var .= "<input type=\"submit\" value=\"Login\" name=\"cmd\"/> or ";
			$var .= "<a href=\"register.php\" style=\"text-align:left\">Register</a>";
			$var .= "</form></div>";
		}
		else if (!$admin)
		{
		  $var .= "Logged in as <a href=\"http://www.22ndcg.com/account.php\"><span class=\"username\">$username</span></a><br>";
			$var .= "<form action=\"http://www.22ndcg.com/login.php\" method=\"post\">";
			$var .= "<input type=\"submit\" value=\"Logout\" name=\"cmd\"/>";
			$var .= "</form></div>";
		}
		else
		{
		  $var .= "Logged in as <i>$username</i><b><a href=\"http://www.22ndcg.com/admin.php\" style=\"text-decoration: none;\">(admin)</a></b><br>";
			$var .= "<form action=\"http://www.22ndcg.com/login.php\" method=\"post\">";
			$var .= "<input type=\"submit\" name=\"cmd\" value=\"Logout\"/>";
			$var .= "</form></div>";
		}
		
		return $var;
	}
?>
