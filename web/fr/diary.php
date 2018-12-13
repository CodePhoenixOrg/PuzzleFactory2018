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

			$sql = "select max(dy_index) from diary;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$dy_index = $rows[0]+1;
			$dy_date = "";
			$dy_time = "";
			$dy_length = "";
			$dy_object = "";
			$dy_description = "";
			$dy_place = "";
			$dy_document = "";
			$mbr_index = "";
		break;
		case "Modifier":
			$sql = "select * from diary where dy_index='$dy_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$dy_index = $rows["dy_index"];
			$dy_date = $rows["dy_date"];
			$dy_time = $rows["dy_time"];
			$dy_length = $rows["dy_length"];
			$dy_object = $rows["dy_object"];
			$dy_description = $rows["dy_description"];
			$dy_place = $rows["dy_place"];
			$dy_document = $rows["dy_document"];
			$mbr_index = $rows["mbr_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into diary (".
				"dy_index, ".
				"dy_date, ".
				"dy_time, ".
				"dy_length, ".
				"dy_object, ".
				"dy_description, ".
				"dy_place, ".
				"dy_document, ".
				"mbr_index".
			") values (".
				"'$dy_index', ".
				"'$dy_date', ".
				"'$dy_time', ".
				"'$dy_length', ".
				"'$dy_object', ".
				"'$dy_description', ".
				"'$dy_place', ".
				"'$dy_document', ".
				"'$mbr_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update diary set ".
				"dy_index='$dy_index', ".
				"dy_date='$dy_date', ".
				"dy_time='$dy_time', ".
				"dy_length='$dy_length', ".
				"dy_object='$dy_object', ".
				"dy_description='$dy_description', ".
				"dy_place='$dy_place', ".
				"dy_document='$dy_document', ".
				"mbr_index='$mbr_index' ".
			"where dy_index='$dy_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from diary where dy_index='$dy_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=14&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select dy_index, dy_date from diary order by dy_index";
		$dbgrid=create_pager_db_grid("diary", $sql, $id, "page.php", "&query=ACTION", "", "dy_date", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("diary", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='diaryForm' action='page.php?id=14&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='dy_index' value='<?php echo $dy_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>dy_index</td>
<td><?php echo $dy_index?></td></tr>
<tr><td>dy_date</td>
<td><input type='text' name='dy_date' value='<?php echo $dy_date?>'></td></tr>
<tr><td>dy_time</td>
<td><input type='text' name='dy_time' value='<?php echo $dy_time?>'></td></tr>
<tr><td>dy_length</td>
<td><input type='text' name='dy_length' value='<?php echo $dy_length?>'></td></tr>
<tr><td>dy_object</td>
<td><input type='text' name='dy_object' value='<?php echo $dy_object?>'></td></tr>
<tr><td>dy_description</td>
<td><input type='text' name='dy_description' value='<?php echo $dy_description?>'></td></tr>
<tr><td>dy_place</td>
<td><input type='text' name='dy_place' value='<?php echo $dy_place?>'></td></tr>
<tr><td>dy_document</td>
<td><input type='text' name='dy_document' value='<?php echo $dy_document?>'></td></tr>
<tr><td>mbr_index</td>
<td><select name='mbr_index'>
<?php $options=options_concat("mbr_index", " | ", "mbr_nom", "mbr_index", "members", "", "mbr_index", $mbr_index, false);
echo $options;?></select></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("diaryForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("diaryForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
