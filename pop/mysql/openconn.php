<?php
function dbconnection($a="") { 
	$host="localhost";
	$user="leela";
	$passwd="25643152";
	if($a=="connect") {
		$myconn=mysql_pconnect($host, $user, $passwd);
		if($myconn) {
			echo "succeeded\n";
		}
		else
			echo "failed\n";
	}
	else if($a=="disconnect") {
		$myconn=mysql_pconnect($host, $user, $passwd);
		mysql_close($myconn);
	}
}
?>
		