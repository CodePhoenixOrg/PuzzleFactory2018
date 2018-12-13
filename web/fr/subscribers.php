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

			$sql = "select max(sub_index) from subscribers;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$sub_index = $rows[0]+1;
			$sub_email = "";
		break;
		case "Modifier":
			$sql = "select * from subscribers where sub_index='$sub_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$sub_index = $rows["sub_index"];
			$sub_email = $rows["sub_email"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into subscribers (".
				"sub_index, ".
				"sub_email".
			") values (".
				"'$sub_index', ".
				"'$sub_email'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update subscribers set ".
				"sub_index='$sub_index', ".
				"sub_email='$sub_email' ".
			"where sub_index='$sub_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from subscribers where sub_index='$sub_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=22&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select sub_index, sub_email from subscribers order by sub_index";
		$dbgrid=create_pager_db_grid("subscribers", $sql, $id, "page.php", "&query=ACTION", "", "sub_email", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("subscribers", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='subscribersForm' action='page.php?id=22&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='sub_index' value='<?php echo $sub_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>sub_index</td>
<td><?php echo $sub_index?></td></tr>
<tr><td>sub_email</td>
<td><input type='text' name='sub_email' value='<?php echo $sub_email?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("subscribersForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("subscribersForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
