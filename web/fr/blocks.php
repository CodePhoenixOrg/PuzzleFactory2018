<center>
<script language = "JavaScript" src = "js/pz_form_events.js"></script>
<?php
	include_once("ipuzzle/pz_mysqlconn.php");
	include_once("ipuzzle/pz_db_controls.php");
	$cs=connection(CONNECT,$database);
	if(empty($query)) $query = "SELECT";
	if(empty($event)) $event = "onLoad";
	if(empty($action)) $action = "Ajouter";
	if($event== "onLoad" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql = "select max(bl_index) from blocks;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$bl_index = $rows[0]+1;
			$bl_column = "";
			$bl_type = "";
			$di_index = "";
		break;
		case "Modifier":
			$sql = "select * from blocks where bl_index='$bl_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$bl_index = $rows["bl_index"];
			$bl_column = $rows["bl_column"];
			$bl_type = $rows["bl_type"];
			$di_index = $rows["di_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into blocks (".
				"bl_index, ".
				"bl_column, ".
				"bl_type, ".
				"di_index".
			") values (".
				"'$bl_index', ".
				"'$bl_column', ".
				"'$bl_type', ".
				"'$di_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update blocks set ".
				"bl_index='$bl_index', ".
				"bl_column='$bl_column', ".
				"bl_type='$bl_type', ".
				"di_index='$di_index' ".
			"where bl_index='$bl_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from blocks where bl_index='$bl_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=13&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select bl_index, bl_column from blocks order by bl_index";
		$dbgrid=create_pager_db_grid("blocks", $sql, $id, "page.php", "&query=ACTION", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("blocks", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='blocksForm' action='page.php?id=13&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='bl_index' value='<?php echo $bl_index?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'><table><tr><td>bl_index</td>
<td><?php echo $bl_index?></td></tr>
<tr><td>bl_column</td>
<td><input type='text' name='bl_column' value='<?php echo $bl_column?>'></td></tr>
<tr><td>bl_type</td>
<td><input type='text' name='bl_type' value='<?php echo $bl_type?>'></td></tr>
<tr><td>di_index</td>
<td><select name='di_index'>
<?php
$sql='select di_index, di_fr_short from dictionary order by di_fr_short';
$options=create_options_from_query($sql, 0, 1, array(), $di_index, false, $cs);
echo $options["list"];
?>
</select></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("blocksForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("blocksForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type='submit' name='action' value='Retour' onClick='return runForm("blocksForm");'>
</td></tr></table>
</td></tr></table>
</form>
<?php
} ?>
</center>
