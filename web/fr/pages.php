<center>
<script language = "JavaScript" src = "js/pz_form_events.js"></script>
<?php
	include_once("ipuzzle/pz_mysqlconn.php");
	include_once("ipuzzle/pz_db_controls.php");
	include_once("ipuzzle/pz_controls.php");
	if(empty($userdb)) $userdb = "factory";
	if(empty($query)) $query = "SELECT";
	if(empty($event)) $event = "onLoad";
	if(empty($action)) $action = "Ajouter";
	
	$cs=connection(CONNECT, $userdb);

	$tmp_filename = "tmp.php";
	$wwwroot=get_www_root();
	$filepath = "$wwwroot/../$userdb/fr/$pa_filename";
	$filedir = "$wwwroot/../$userdb/fr/";
		
	echo "<br>";
	
	if($event== "onLoad" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql = "select max(pa_index) from pages;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$pa_index = $rows[0]+1;
			$di_index = "";
			$pa_filename = "";
		break;
		case "Modifier":
			$sql = "select * from pages where pa_index='$pa_index';";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$pa_index = $rows["pa_index"];
			$di_index = $rows["di_index"];
			$pa_filename = $rows["pa_filename"];
		break;
		}
	} else if($event== "onRun" && $query== "ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql = "insert into pages (".
				"pa_index, ".
				"di_index, ".
				"pa_filename".
			") values (".
				"'$pa_index', ".
				"'$di_index', ".
				"'$pa_filename'".
			")";
			$result = mysql_query($sql, $cs);
		break;
		case "Modifier":
			$sql = "update pages set ".
				"pa_index='$pa_index', ".
				"di_index='$di_index', ".
				"pa_filename='$pa_filename' ".
			"where pa_index='$pa_index'";
			$result = mysql_query($sql, $cs);
		break;
		case "Supprimer":
			$sql = "delete from pages where pa_index='$pa_index'";
			$result = mysql_query($sql, $cs);
		break;
		}
		$query = "SELECT";
	} else if($event== "onUnload" && $query== "ACTION") {
		$cs=connection("disconnect","factory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=12&lg=fr'</script>";
	}
if($query== "SELECT") {
		$sql = "select p.pa_index, p.pa_index as 'N° de page', d.di_fr_short as 'entr&eacute;e du menu', p.pa_filename as 'nom du fichier' from pages as p, dictionary as d where p.di_index=d.di_index order by pa_index";
		$dbgrid=create_pager_db_grid("pages", $sql, $id, "page.php", "&query=ACTION", "", false, true, array(), array(0, 66, 133,133), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("pages", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query== "ACTION") {
?>
<form method='POST' name='pagesForm' action='page.php?id=12&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>

<?php
if($action== "Ajouter") {
	if($pa_filename!= "" && $save== "Oui") {
		copy($tmp_filename, $pa_filename);
	}
	$script = "";
	if($basedir== "") $basedir = "/$userdb/fr";
	$srvdir=create_server_directory_selector("srvdir", "myTabForm", $basedir, "");
	$srvfiles=create_server_file_selector("srvfiles", "myTabForm", $basedir, "php", 5, "srvdir", "");
	$database_list=create_options_from_query("show databases", 0, 0, $userdb, false, $cs);
	$table_list=create_options_from_query("show tables", 0, 0, $table, false, $cs);
	
	//Options de l'auto-g�n�ration
	$rad_autogen=(array) null;
	if(!isset($autogen)) $autogen=0;
	$rad_autogen[$autogen] = " checked"; 
	
	//Options de menu
	$rad_menu=(array) null;
	if(!isset($menu)) $menu=0;
	$rad_menu[$menu] = " checked"; 
	
	//Options de menu
	$rad_menu2=(array) null;
	if(!isset($menu2)) $menu2=0;
	$rad_menu2[$menu2] = " checked"; 
	
	//Options de script
	$rad_props=(array) null;
	if(!isset($props)) $props=0;
	$rad_props[$props] = " checked"; 
	
	//Options de filtre
	$chk_filter = ""; 
	if(isset($filter)) $chk_filter = " checked"; 
?>
	<div id='tab_Scripts' style='width:370px;display:inline;visibility:visible;'>
	<fieldset>
	<legend>Cr�er un script � partir d'une table</legend>
	<table border='0' bordercolor='0' width='100%' valign='top' style='display:hidden;'>
	<tr><td><b>Base de donn�e</b></td><td><b>Table</b></td><td></td></tr>
	<tr><td>
	<select name='userdb' onChange='document.pagesForm.query.value=\"MENU\";document.pagesForm.submit();'>
	<?php echo $database_list?>
	</select>
	</td><td>
	<select name='table'>
	<?php echo $table_list?>
	</select>
	</td><td>
	</td></tr>
	<tr><td colspan='3'>
	<b>Type d'auto-g�n�ration :</b>
	</td></tr>
	<tr><td>
	<label><input type='radio'<?php echo $rad_autogen[0]?> name='autogen' value='0'>Script+Menu</label>
	</td><td>
	<label><input type='radio'<?php echo $rad_autogen[1]?> name='autogen' value='1'>Script seul</label>
	</td><td>
	<label><input type='radio'<?php echo $rad_autogen[2]?> name='autogen' value='2'>Menu seul</label>
	</td></tr>
	<tr><td colspan='3'>
	<b>Index de menu :</b>
	</td></tr>
	<tr><td>
	<label><input type='radio'<?php echo $rad_menu2[0]?> name='menu2' value='0'>Auto-incr�ment�</label>
	</td><td>
	<label><input type='radio'<?php echo $rad_menu2[1]?> name='menu2' value='1'>Choisi</label>&nbsp;
	<input type='text' name='me_index' value='<?php echo $me_index?>' size=3>
	</td><td>&nbsp;
	</td></tr>
	<tr><td colspan='3'>
	<b>Propri�t�s du script :</b>
	</td></tr>
	<tr><td>
	<label><input type='radio'<?php echo $rad_props[0]?> name='props' value='0'>DB Grid seul</label>
	</td><td>
	<label><input type='radio'<?php echo $rad_props[1]?> name='props' value='1'>DB Grid + Fiche</label>
	</td><td>
	<label><input type='checkbox'<?php echo $chk_filter?> name='filter' value='0'>+ Filtre</label>
	</td></tr>
	<tr><td colspan='3'>
	<b>R�pertoire du script :</b>
	</td></tr>
	<tr><td colspan='3'>
	<?php echo $srvdir?>
	</td></tr>
	<tr><td colspan='3' align='center'>
	<br><input type='submit' name='action' value='Suivant' onClick='document.pagesForm.query.value=\"SCRIPT\";document.pagesForm.basedir.value=\"<?php echo $basedir?>\"'>
	</td></tr>
	</table>
	</fieldset>
	</div>
<?php } elseif($action== "Modifier") {?>
<input type='hidden' name='pa_index' value='<?php echo $pa_index?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table><tr><td>pa_index</td>
<td><?php echo $pa_index?></td></tr>
<tr><td>di_index</td>
<td><select name='di_index'>
<?php
	$sql = "select di_index, di_fr_short from dictionary";
	$options=create_options_from_query($sql, 0, 1, $di_index, false, $cs);
	echo $options;
?>
</select></td></tr>
<tr><td>pa_filename</td>
<td><input type='text' name='pa_filename' value='<?php echo $pa_filename?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm("pagesForm");'>
<?php	if($action!= "Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("pagesForm");'>
<?php	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value = "Retour" onClick = "history.go(-1);">
<?php }?>
</td></tr></table>
</td></tr></table>
</form>
<?php 
	} elseif($query== "SCRIPT") {
		echo "<form name='scriptForm' method='POST' action='page.php?id=10&lg = $lg'>\n";

		$dir = "/var/www/html/$userdb/fr";
		//if(!file_exists($dir)) mkdir($dir);
		$siteroot = $filedir;
		$http_root=get_http_root();
	
		if($action = "Cr�er") {
			$formname = "fiche_$table";
			$sql = "show fields from $table;";
	
			$L_sqlFields = "";
			$A_sqlFields=Array();
			
			$result = mysql_query($sql, $cs);
			while($rows=mysql_fetch_array($result)) {
				$L_sqlFields .= $rows[0].",";
			}
			$L_sqlFields=substr($L_sqlFields, 0, strlen($L_sqlFields)-1);
			$A_sqlFields=explode(",", $L_sqlFields);
			$indexfield = $A_sqlFields[0];
			$secondfield = $A_sqlFields[1];
			
			$catalog_pa_filename = "$table.php";
			$catalog=get_menu_index($userdb, $catalog_pa_filename);
		
			echo "catalog='$catalog'<br>";
	
			$me_index = "";
			$me_level = "1";
			$new_pa_index = "";
			//$pa_filename = $catalog_pa_filename;
			$di_index = $table;
			$di_fr_short=strtoupper(substr($table,0,1)).substr($table, 1, strlen($table)-1);
			$di_fr_long = "Liste des $table";
	
			if($catalog==0) {
				$catalog=add_menu(
					$userdb,
					$me_index, $di_index, $me_level, $me_target,
					$pa_index, $new_pa_index, $catalog_pa_filename,
					$di_fr_short, $di_fr_long, $di_en_short, $di_en_long
				);
			}
			
			$sql = "drop table v_menus;";
			mysql_query($sql, $cs);
			
			//$pa_filename = "$siteroot/$catalog_pa_filename";
			$pa_filename = "$basedir$table.php";
			$script=make_script($userdb, $table, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
	
			$file=fopen($tmp_filename, "w");
			fwrite($file, $script);
			fclose($file);
		}

		//echo "<input type='hidden' name='script' value='$script'>\n";
		/*
		echo "<input type='hidden' name='userdb' value='$userdb'>\n";
		echo "<input type='hidden' name='table' value='$table'>\n";
		echo "<input type='hidden' name='catalog' value='$catalog'>\n";
		echo "<input type='hidden' name='indexfield' value='$indexfield'>\n";
		echo "<input type='hidden' name='secondfield' value='$secondfield'>\n";
		echo "<input type='hidden' name='A_sqlFields' value='$A_sqlFields'>\n";
		*/

		echo "<input type='hidden' name='basedir' value='$basedir'>\n";
		echo "<input type='hidden' name='query' value='$query'>\n";
		echo "<input type='hidden' name='pa_filename' value='$pa_filename'>\n";
		if($script== "") {
			$script_file = file($tmp_filename);
			$script = implode ("", $script_file);
			$script_file = null;
		}
		echo "<textarea cols='80' rows='20'>$script</textarea><br>\n";
		echo "Le fichier sera copi� dans ce r�pertoire\n";
		if(!isset($basedir)) $basedir = $filedir;
		$onChange = "document.scriptForm.query.value=\"SCRIPT\";";
		$dir_selector=create_server_directory_selector("srvdirs", "scriptForm",$basedir, $onChange);
		echo $dir_selector."<br>\n";

		echo "$pa_filename<br>";
		if(file_exists($pa_filename)) {
			echo "Attention ! Un fichier portant ce nom existe d�j� !<br>";
			echo "Voulez-vous �craser le script actuel sachant que toutes les modifications effectu�es seront perdues ?<br>\n";
		} else
			echo "Voulez-vous enregistrer le script ?<br>\n";
		echo "<input type='submit' name='save' value='Oui'>\n";
		echo "<input type='submit' name='save' value='Non' onClick='document.scriptForm.query.value=\"MENU\"'>\n";
		echo "</form>\n";
	}
?>
</center>
