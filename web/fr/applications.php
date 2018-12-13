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

			$sql = "select max(app_index) from applications;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$app_index = $rows[0]+1;
			$app_link = "";
			$di_index = "";
		break;
		case "Modifier":
			$sql = "select * from applications where app_index='$app_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$app_index = $rows["app_index"];
			$app_link = $rows["app_link"];
			$di_index = $rows["di_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into applications (".
				"app_index, ".
				"app_link, ".
				"di_index".
			") values (".
				"'$app_index', ".
				"'$app_link', ".
				"'$di_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update applications set ".
				"app_index='$app_index', ".
				"app_link='$app_link', ".
				"di_index='$di_index' ".
			"where app_index='$app_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from applications where app_index='$app_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=15&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select app_index, app_link from applications order by app_index";
		$dbgrid=create_pager_db_grid("applications", $sql, $id, "page.php", "&query=ACTION", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("applications", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='applicationsForm' action='page.php?id=15&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='app_index' value='<?php echo $app_index?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'><table><tr><td>app_index</td>
<td><?php echo $app_index?></td></tr>
<tr><td>app_link</td>
<td><input type='text' name='app_link' value='<?php echo $app_link?>'></td></tr>
<tr><td>di_index</td>
<td><select name='di_index'>
<?php $sql='select di_index, di_fr_short from dictionary order by di_fr_short';$options=create_options_from_query($sql, 0, 1, array(), $di_index, false, $cs);
echo $options["list"];?></select></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("applicationsForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("applicationsForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type='submit' name='action' value='Retour' onClick='return runForm("applicationsForm");'>
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
