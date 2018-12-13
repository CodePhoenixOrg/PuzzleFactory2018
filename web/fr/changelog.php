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

			$sql = "select max(cl_index) from changelog;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$cl_index = $rows[0]+1;
			$cl_title = "";
			$cl_text = "";
			$cl_date=get_sql_date();
			$cl_time=get_short_time();
			$fr_index = "";
			$mbr_index = "";
		break;
		case "Modifier":
			$sql = "select * from changelog where cl_index='$cl_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$cl_index = $rows["cl_index"];
			$cl_title = $rows["cl_title"];
			$cl_text = $rows["cl_text"];
			$cl_date = $rows["cl_date"];
			$cl_time = $rows["cl_time"];
			$fr_index = $rows["fr_index"];
			$mbr_index = $rows["mbr_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		$cl_date=get_sql_date();
		$cl_time=get_sql_time();
		switch ($action) {
		case "Ajouter":
			$sql = "insert into changelog (".
				"cl_index, ".
				"cl_title, ".
				"cl_text, ".
				"cl_date, ".
				"cl_time, ".
				"fr_index, ".
				"mbr_index".
			") values (".
				"'$cl_index', ".
				"'$cl_title', ".
				"'$cl_text', ".
				"'$cl_date', ".
				"'$cl_time', ".
				"'$fr_index', ".
				"'$mbr_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update changelog set ".
				"cl_index='$cl_index', ".
				"cl_title='$cl_title', ".
				"cl_text='$cl_text', ".
				"cl_date='$cl_date', ".
				"cl_time='$cl_time', ".
				"fr_index='$fr_index', ".
				"mbr_index='$mbr_index' ".
			"where cl_index='$cl_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from changelog where cl_index='$cl_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=17&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select cl_index, concat('<b>', cl_title, '</b><br>', cl_text, '<br>') as changements, cl_date as Date from changelog order by cl_date desc, cl_time desc";
		$dbgrid=create_pager_db_grid("changelog", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 500), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("changelog", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='changelogForm' action='page.php?id=17&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='cl_index' value='<?php echo $cl_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table>
<tr><td>Rapport n�</td>
<td><?php echo $cl_index?></td></tr>
<tr><td>Date</td>
<td><?php echo date_mysql_to_french($cl_date)." ".$cl_time ?></td></tr>
<tr><td>Intitul�</td>
<td><input type='text' name='cl_title' value='<?php echo $cl_title?>' size='80'></td></tr>
<tr><td>Description *</td>
<td><textarea name='cl_text' cols='80' rows='5'><?php echo $cl_text?></textarea><br>
* Les tags HTML peuvent �tre utilis�s pour formater le texte.
</td></tr>
<tr><td>Rapport� par</td>
<td><select name='mbr_index'>
<?php
$options=options_concat("mbr_index", " | ", "mbr_nom", "mbr_index", "members", "", "mbr_index", $mbr_index, false);
echo $options;?></select></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("changelogForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("changelogForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php
} ?>
</center>
