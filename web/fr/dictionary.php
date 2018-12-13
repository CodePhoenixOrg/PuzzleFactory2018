<center>
<script language = "JavaScript" src = "js/pz_form_events.js"></script>
<?php
	include_once("ipuzzle/pz_mysqlconn.php");
	include_once("ipuzzle/pz_db_controls.php");
	$cs=connection("connect","factory");
	if(empty($query)) $query = "SELECT";
	if(empty($event)) $event = "onLoad";
	if(empty($action)) $action = "Ajouter";
	if($event== "onLoad" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql = "select max(di_index) from dictionary;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$di_index = $rows[0]+1;
			$di_fr_short = "";
			$di_fr_long = "";
			$di_en_short = "";
			$di_en_long = "";
			$di_ru_short = "";
			$di_ru_long = "";
		break;
		case "Modifier":
			$sql = "select * from dictionary where di_index='$di_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$di_index = $rows["di_index"];
			$di_fr_short = $rows["di_fr_short"];
			$di_fr_long = $rows["di_fr_long"];
			$di_en_short = $rows["di_en_short"];
			$di_en_long = $rows["di_en_long"];
			$di_ru_short = $rows["di_ru_short"];
			$di_ru_long = $rows["di_ru_long"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into dictionary (".
				"di_index, ".
				"di_fr_short, ".
				"di_fr_long, ".
				"di_en_short, ".
				"di_en_long, ".
				"di_ru_short, ".
				"di_ru_long".
			") values (".
				"'$di_index', ".
				"'$di_fr_short', ".
				"'$di_fr_long', ".
				"'$di_en_short', ".
				"'$di_en_long', ".
				"'$di_ru_short', ".
				"'$di_ru_long'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update dictionary set ".
				"di_index='$di_index', ".
				"di_fr_short='$di_fr_short', ".
				"di_fr_long='$di_fr_long', ".
				"di_en_short='$di_en_short', ".
				"di_en_long='$di_en_long', ".
				"di_ru_short='$di_ru_short', ".
				"di_ru_long='$di_ru_long' ".
			"where di_index='$di_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from dictionary where di_index='$di_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=14&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select di_index, di_fr_short from dictionary order by di_index";
		$dbgrid=create_pager_db_grid("dictionary", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("dictionary", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='dictionaryForm' action='page.php?id=14&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='di_index' value='<?php echo $di_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>di_index</td>
<td><?php echo $di_index?></td></tr>
<tr><td>di_fr_short</td>
<td><input type='text' name='di_fr_short' value='<?php echo $di_fr_short?>'></td></tr>
<tr><td>di_fr_long</td>
<td><input type='text' name='di_fr_long' value='<?php echo $di_fr_long?>'></td></tr>
<tr><td>di_en_short</td>
<td><input type='text' name='di_en_short' value='<?php echo $di_en_short?>'></td></tr>
<tr><td>di_en_long</td>
<td><input type='text' name='di_en_long' value='<?php echo $di_en_long?>'></td></tr>
<tr><td>di_ru_short</td>
<td><input type='text' name='di_ru_short' value='<?php echo $di_ru_short?>'></td></tr>
<tr><td>di_ru_long</td>
<td><input type='text' name='di_ru_long' value='<?php echo $di_ru_long?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("dictionaryForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("dictionaryForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
