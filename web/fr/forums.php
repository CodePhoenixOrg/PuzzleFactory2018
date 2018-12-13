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

			$sql = "select max(fr_index) from forums;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$fr_index = $rows[0]+1;
			$fr_title = "";
			$fr_description = "";
			$fr_date = "";
			$fr_table_name = "";
			$me_index = "";
		break;
		case "Modifier":
			$sql = "select * from forums where fr_index='$fr_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$fr_index = $rows["fr_index"];
			$fr_title = $rows["fr_title"];
			$fr_description = $rows["fr_description"];
			$fr_date = $rows["fr_date"];
			$fr_table_name = $rows["fr_table_name"];
			$me_index = $rows["me_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into forums (".
				"fr_index, ".
				"fr_title, ".
				"fr_description, ".
				"fr_date, ".
				"fr_table_name, ".
				"me_index".
			") values (".
				"'$fr_index', ".
				"'$fr_title', ".
				"'$fr_description', ".
				"'$fr_date', ".
				"'$fr_table_name', ".
				"'$me_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update forums set ".
				"fr_index='$fr_index', ".
				"fr_title='$fr_title', ".
				"fr_description='$fr_description', ".
				"fr_date='$fr_date', ".
				"fr_table_name='$fr_table_name', ".
				"me_index='$me_index' ".
			"where fr_index='$fr_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from forums where fr_index='$fr_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=16&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select fr_index, fr_title from forums order by fr_index";
		$dbgrid=create_pager_db_grid("forums", $sql, $id, "page.php", "&query=ACTION", "", "fr_title", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("forums", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='forumsForm' action='page.php?id=16&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='fr_index' value='<?php echo $fr_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>fr_index</td>
<td><?php echo $fr_index?></td></tr>
<tr><td>fr_title</td>
<td><input type='text' name='fr_title' value='<?php echo $fr_title?>'></td></tr>
<tr><td>fr_description</td>
<td><input type='text' name='fr_description' value='<?php echo $fr_description?>'></td></tr>
<tr><td>fr_date</td>
<td><input type='text' name='fr_date' value='<?php echo $fr_date?>'></td></tr>
<tr><td>fr_table_name</td>
<td><input type='text' name='fr_table_name' value='<?php echo $fr_table_name?>'></td></tr>
<tr><td>me_index</td>
<td><select name='me_index'>
<?php $options=options_concat("me_index", " | ", "me_level", "me_index", "menus", "", "me_index", $me_index, false);
echo $options;?></select></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("forumsForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("forumsForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
