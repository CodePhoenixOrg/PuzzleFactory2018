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

			$sql = "select max(grp_group) from groups;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$grp_group = $rows[0]+1;
			$grp_members_priv = "";
			$grp_menu_priv = "";
			$grp_page_priv = "";
			$grp_news_priv = "";
			$grp_items_priv = "";
			$grp_customers_priv = "";
			$grp_products_priv = "";
			$grp_calendar_priv = "";
			$grp_newsletter_priv = "";
			$grp_forum_priv = "";
		break;
		case "Modifier":
			$sql = "select * from groups where grp_group='$grp_group';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$grp_group = $rows["grp_group"];
			$grp_members_priv = $rows["grp_members_priv"];
			$grp_menu_priv = $rows["grp_menu_priv"];
			$grp_page_priv = $rows["grp_page_priv"];
			$grp_news_priv = $rows["grp_news_priv"];
			$grp_items_priv = $rows["grp_items_priv"];
			$grp_customers_priv = $rows["grp_customers_priv"];
			$grp_products_priv = $rows["grp_products_priv"];
			$grp_calendar_priv = $rows["grp_calendar_priv"];
			$grp_newsletter_priv = $rows["grp_newsletter_priv"];
			$grp_forum_priv = $rows["grp_forum_priv"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into groups (".
				"grp_group, ".
				"grp_members_priv, ".
				"grp_menu_priv, ".
				"grp_page_priv, ".
				"grp_news_priv, ".
				"grp_items_priv, ".
				"grp_customers_priv, ".
				"grp_products_priv, ".
				"grp_calendar_priv, ".
				"grp_newsletter_priv, ".
				"grp_forum_priv".
			") values (".
				"'$grp_group', ".
				"'$grp_members_priv', ".
				"'$grp_menu_priv', ".
				"'$grp_page_priv', ".
				"'$grp_news_priv', ".
				"'$grp_items_priv', ".
				"'$grp_customers_priv', ".
				"'$grp_products_priv', ".
				"'$grp_calendar_priv', ".
				"'$grp_newsletter_priv', ".
				"'$grp_forum_priv'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update groups set ".
				"grp_group='$grp_group', ".
				"grp_members_priv='$grp_members_priv', ".
				"grp_menu_priv='$grp_menu_priv', ".
				"grp_page_priv='$grp_page_priv', ".
				"grp_news_priv='$grp_news_priv', ".
				"grp_items_priv='$grp_items_priv', ".
				"grp_customers_priv='$grp_customers_priv', ".
				"grp_products_priv='$grp_products_priv', ".
				"grp_calendar_priv='$grp_calendar_priv', ".
				"grp_newsletter_priv='$grp_newsletter_priv', ".
				"grp_forum_priv='$grp_forum_priv' ".
			"where grp_group='$grp_group'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from groups where grp_group='$grp_group'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=17&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select grp_group, grp_members_priv from groups order by grp_group";
		$dbgrid=create_pager_db_grid("groups", $sql, $id, "page.php", "&query=ACTION", "", "grp_members_priv", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("groups", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='groupsForm' action='page.php?id=17&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='grp_group' value='<?php echo $grp_group?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>grp_group</td>
<td><?php echo $grp_group?></td></tr>
<tr><td>grp_members_priv</td>
<td><input type='text' name='grp_members_priv' value='<?php echo $grp_members_priv?>'></td></tr>
<tr><td>grp_menu_priv</td>
<td><input type='text' name='grp_menu_priv' value='<?php echo $grp_menu_priv?>'></td></tr>
<tr><td>grp_page_priv</td>
<td><input type='text' name='grp_page_priv' value='<?php echo $grp_page_priv?>'></td></tr>
<tr><td>grp_news_priv</td>
<td><input type='text' name='grp_news_priv' value='<?php echo $grp_news_priv?>'></td></tr>
<tr><td>grp_items_priv</td>
<td><input type='text' name='grp_items_priv' value='<?php echo $grp_items_priv?>'></td></tr>
<tr><td>grp_customers_priv</td>
<td><input type='text' name='grp_customers_priv' value='<?php echo $grp_customers_priv?>'></td></tr>
<tr><td>grp_products_priv</td>
<td><input type='text' name='grp_products_priv' value='<?php echo $grp_products_priv?>'></td></tr>
<tr><td>grp_calendar_priv</td>
<td><input type='text' name='grp_calendar_priv' value='<?php echo $grp_calendar_priv?>'></td></tr>
<tr><td>grp_newsletter_priv</td>
<td><input type='text' name='grp_newsletter_priv' value='<?php echo $grp_newsletter_priv?>'></td></tr>
<tr><td>grp_forum_priv</td>
<td><input type='text' name='grp_forum_priv' value='<?php echo $grp_forum_priv?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("groupsForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("groupsForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
