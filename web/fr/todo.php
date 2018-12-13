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

			$sql = "select max(td_index) from todo;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$td_index = $rows[0]+1;
			$td_title = "";
			$td_text = "";
			$td_priority = "";
			$td_expiry = "";
			$td_status = "";
			$td_date = "";
			$td_time = "";
			$mbr_index = "";
		break;
		case "Modifier":
			$sql = "select * from todo where td_index='$td_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$td_index = $rows["td_index"];
			$td_title = $rows["td_title"];
			$td_text = $rows["td_text"];
			$td_priority = $rows["td_priority"];
			$td_expiry = $rows["td_expiry"];
			$td_status = $rows["td_status"];
			$td_date = $rows["td_date"];
			$td_time = $rows["td_time"];
			$mbr_index = $rows["mbr_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into todo (".
				"td_index, ".
				"td_title, ".
				"td_text, ".
				"td_priority, ".
				"td_expiry, ".
				"td_status, ".
				"td_date, ".
				"td_time, ".
				"mbr_index".
			") values (".
				"'$td_index', ".
				"'$td_title', ".
				"'$td_text', ".
				"'$td_priority', ".
				"'$td_expiry', ".
				"'$td_status', ".
				"'$td_date', ".
				"'$td_time', ".
				"'$mbr_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update todo set ".
				"td_index='$td_index', ".
				"td_title='$td_title', ".
				"td_text='$td_text', ".
				"td_priority='$td_priority', ".
				"td_expiry='$td_expiry', ".
				"td_status='$td_status', ".
				"td_date='$td_date', ".
				"td_time='$td_time', ".
				"mbr_index='$mbr_index' ".
			"where td_index='$td_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from todo where td_index='$td_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=18&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select td_index, td_title from todo order by td_index";
		$dbgrid=create_pager_db_grid("todo", $sql, $id, "page.php", "&query=ACTION", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("todo", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='todoForm' action='page.php?id=18&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='td_index' value='<?php echo $td_index?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'><table><tr><td>td_index</td>
<td><?php echo $td_index?></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("todoForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("todoForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type='submit' name='action' value='Retour' onClick='return runForm("todoForm");'>
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
