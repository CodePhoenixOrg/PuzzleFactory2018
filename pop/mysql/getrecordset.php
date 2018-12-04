<html><body><pre>
<?php
	require "openconn.php";
	dbconnection("connect");
	mysql_select_db($d);
 	$sql=urldecode($q);
	$result=mysql_query($sql);
	if($result) {
		$i=mysql_num_fields($result);
		$k=0;

		// Get recordset field names
		$line="";
		for($j=0; $j<$i; $j++)
		{
			$fieldname=mysql_field_name($result, $j);
			if (strpos($fieldname, " ")==0)
				$line=$line . $fieldname . ",";
			else
				$line=$line . "\"" . $fieldname . "\"" . ",";
		}
		$line=substr($line, 0, strlen($line)-1);
		echo $line . "\n";

		// Get recordset field types
		$line="";
		for($j=0; $j<$i; $j++)
			$line=$line . mysql_field_type($result, $j) . ",";
		$line=substr($line, 0, strlen($line)-1);
		echo $line . "\n";

		// Get recordset data rows
		while($rows=mysql_fetch_array($result))
		{
			echo $k . "=";
			$line="";
			for($j=0; $j<$i; $j++)
			{
				if (strpos($rows[$j], " ")==0)
					$line=$line . $rows[$j] . ",";
				else
					$line=$line . "\"" . $rows[$j] . "\"" . ",";
			}
			$line=substr($line, 0, strlen($line)-1);
			echo $line . "\n";
			$k++;
		}
		mysql_free_result($result);
	}
?>
</pre></body></html>
