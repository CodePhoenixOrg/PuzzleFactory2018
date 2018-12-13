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

			$sql = "select max(br_index) from bugreport;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$br_index = $rows[0]+1;
			$br_title = "";
			$br_text = "";
			$br_importance = "";
			$br_status = "";
			$br_date=get_sql_date();
			$br_time=get_short_time();
			$mbr_index = "";
		break;
		case "Modifier":
			$sql = "select * from bugreport where br_index='$br_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$br_index = $rows["br_index"];
			$br_title = $rows["br_title"];
			$br_text = $rows["br_text"];
			$br_importance = $rows["br_importance"];
			$br_status = $rows["br_status"];
			$br_date = $rows["br_date"];
			$br_time = $rows["br_time"];
			$mbr_index = $rows["mbr_index"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		$br_date=get_sql_date();
		$br_time=get_sql_time();
		switch ($action) {
		case "Ajouter":
			$sql = "insert into bugreport (".
				"br_index, ".
				"br_title, ".
				"br_text, ".
				"br_importance, ".
				"br_status, ".
				"br_date, ".
				"br_time, ".
				"mbr_index".
			") values (".
				"'$br_index', ".
				"'$br_title', ".
				"'$br_text', ".
				"'$br_importance', ".
				"'$br_status', ".
				"'$br_date', ".
				"'$br_time', ".
				"'$mbr_index'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update bugreport set ".
				"br_index='$br_index', ".
				"br_title='$br_title', ".
				"br_text='$br_text', ".
				"br_importance='$br_importance', ".
				"br_status='$br_status', ".
				"br_date='$br_date', ".
				"br_time='$br_time', ".
				"mbr_index='$mbr_index' ".
			"where br_index='$br_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from bugreport where br_index='$br_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=19&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select br_index, concat('<b>', br_title, '</b><br>', br_text, '<br>') as `bugs trouv�s`, br_importance as 'importance', br_status as 'etat' from bugreport order by br_status, br_importance desc";
		$dbgrid=create_pager_db_grid("bugreport", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("bugreport", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
	$importance=array(1,2,3);
	if(empty($br_importance)) $br_importance=1;
	$status=array("à fixer", "en test","fixé");
	if(empty($br_status)) $br_status = "à fixer";
?>
<form method='POST' name='bugreportForm' action='page.php?id=19&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='br_index' value='<?php echo $br_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table>
<tr><td>Bug n°</td>
<td><?php echo $br_index?></td></tr>
<tr><td>Date</td>
<td><?php echo date_mysql_to_french($br_date)." ".$br_time ?></td></tr>
<tr><td>Rapporté par</td>
<td><select name='mbr_index'>
<?php
	$options=options_concat("mbr_index", " | ", "mbr_nom", "mbr_index", "members", "", "mbr_index", $mbr_index, false);
	echo $options;
?>
</select></td></tr>
<tr><td>Intitulé</td>
<td><input type='text' name='br_title' value='<?php echo $br_title?>' size='80'></td></tr>
<tr><td>Description*</td>
<td><textarea name='br_text' cols='80' rows='5'><?php echo $br_text?></textarea><br>
* Les tags HTML peuvent être utilisés pour formater le texte.</td></tr>
<tr><td>Importance</td>
<td>
<select name='br_importance'>
	<?php
		echo "<option selected value='$br_importance'>$br_importance</option>";
		foreach($importance as $level) {
			if($level<>$br_importance) echo "<option value='$level'>$level</option>";
		}
	?>
</select>&nbsp;&nbsp;Plus le chiffre est grand, plus le bug est important.
</td></tr>
<tr><td>Etat</td>
<td>
<select name='br_status'>
	<?php
		echo "<option selected value='$br_status'>$br_status</option>";
		foreach($status as $astatus) {
			if($astatus<>$br_status) echo "<option value='$astatus'>$astatus</option>";
		}
	?>
</select>
</td></tr>
<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("bugreportForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("bugreportForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php
} ?>
</center>
