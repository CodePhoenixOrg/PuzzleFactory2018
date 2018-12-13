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

			$sql = "select max(me_index) from menus;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$me_index = $rows[0]+1;
			$me_level = "";
			$me_target = "";
			$pa_index = "";
			$bl_index = "";
			$di_index = "";
			$grp_group = "";
		break;
		case "Modifier":
			$sql = "select * from menus where me_index='$me_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$me_index = $rows["me_index"];
			$me_level = $rows["me_level"];
			$me_target = $rows["me_target"];
			$pa_index = $rows["pa_index"];
			$bl_index = $rows["bl_index"];
			$di_index = $rows["di_index"];
			$grp_group = $rows["grp_group"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into menus (".
				"me_index, ".
				"me_level, ".
				"me_target, ".
				"pa_index, ".
				"bl_index, ".
				"di_index, ".
				"grp_group".
			") values (".
				"'$me_index', ".
				"'$me_level', ".
				"'$me_target', ".
				"'$pa_index', ".
				"'$bl_index', ".
				"'$di_index', ".
				"'$grp_group'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update menus set ".
				"me_index='$me_index', ".
				"me_level='$me_level', ".
				"me_target='$me_target', ".
				"pa_index='$pa_index', ".
				"bl_index='$bl_index', ".
				"di_index='$di_index', ".
				"grp_group='$grp_group' ".
			"where me_index='$me_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from menus where me_index='$me_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=11&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select me_index, me_level from menus order by me_index";
		$dbgrid=create_pager_db_grid("menus", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("menus", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='menusForm' action='page.php?id=11&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='me_index' value='<?php echo $me_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table><tr><td>me_index</td>
<td><?php echo $me_index?></td></tr>
<tr><td>me_level</td>
<td><input type='text' name='me_level' value='<?php echo $me_level?>'></td></tr>
<tr><td>me_target</td>
<td><input type='text' name='me_target' value='<?php echo $me_target?>'></td></tr>
<tr><td>pa_index</td>
<td><select name='pa_index'>
<?php $options=options_concat("pa_index", " | ", "di_index", "pa_index", "pages", "", "pa_index", $pa_index, false);
echo $options;?></select></td></tr>
<tr><td>bl_index</td>
<td><select name='bl_index'>
<?php $options=options_concat("bl_index", " | ", "bl_column", "bl_index", "blocks", "", "bl_index", $bl_index, false);
echo $options;?></select></td></tr>
<tr><td>di_index</td>
<td><select name='di_index'>
<?php $options=options_concat("di_index", " | ", "di_fr_short", "di_index", "dictionary", "", "di_index", $di_index, false);
echo $options;?></select></td></tr>
<tr><td>grp_group</td>
<td><input type='text' name='grp_group' value='<?php echo $grp_group?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("menusForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("menusForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
