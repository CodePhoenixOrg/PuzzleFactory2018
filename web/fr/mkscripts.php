<center>
<?php
	include("ipuzzle/pz_mkscripts.php");
	
	if(empty($userdb)) $userdb = "factory";
	if(empty($query)) $query = "MENU";
	$cs=connection(CONNECT, $userdb);
	$tmp_filename = "tmp.php";
	
	$wwwroot=get_www_root();
	$filepath = "$wwwroot/../$userdb/fr/$pa_filename";
		
	if($query== "SCRIPT") {
		echo "<form name='scriptForm' method='POST' action='page.php?id=10&lg = $lg&query=MENU'>\n";

		$dir = "/var/www/html/$userdb/fr";
		//if(!file_exists($dir)) mkdir($dir);
		$siteroot = $dir;
		$http_root=get_http_root();
	
		if(!empty($action)) {
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
			
			$pa_filename = "$siteroot/$catalog_pa_filename";
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
		echo "<input type='hidden' name='pa_filename' value='$pa_filename'>\n";
		echo "<textarea cols='80' rows='20'>$script</textarea><br>\n";
		echo "Le fichier sera copier dans ce r�pertoire : $filepath<br>";
		echo "Voulez-vous enregistrer le script � cet endroit ?<br>\n";
		echo "<input type='submit' name='save' value='Oui'>\n";
		echo "<input type='submit' name='save' value='Non'>\n";
		echo "</form>\n";

	} elseif($query== "MENU") {
		$script = "";
		
		echo "<form method='post' name='myForm' action='page.php?id=10&lg = $lg'>\n";
		echo "<input type='hidden' name='query' value='SCRIPT'>\n";
		echo "<select name='userdb' onChange='document.myForm.query.value=\"MENU\";document.myForm.submit();'>\n";
		
		$liste=options_sql("show databases", $userdb, false);
		echo $liste;
		
		echo "</select>\n";
		echo "<select name='table'>\n";
		
		$liste=options_sql("show tables", $table, false);
		echo $liste;
		
		echo "</select>\n";
		echo "<input type='submit' name='action' value='Make'>\n";
		echo "</form>\n";

		/*
		$sql_file=array();
		$sql_file=file("sql/v_menus_drop.sql");
		$sql = implode ("", $sql_file);
		$drop=mysql_query($sql, $cs) or die(mysql_error());

		if($drop) {
			$sql_file=file("sql/v_menus_create.sql");
			$sql = implode ("", $sql_file);
			$create=mysql_query($sql, $cs) or die(mysql_error());
		}
		
		if($create) {
			$sql_file=file("sql/v_menus_insert.sql");
			$sql = implode ("", $sql_file);
			$insert=mysql_query($sql, $cs) or die(mysql_error());
		}
		
		if($insert) {
			$sql_file=file("sql/v_menus.sql");
			$sql = implode ("", $sql_file);
		}
		
		$sql = 'delete from v_menus;';

		$result=mysql_query($sql, $cs);
		

		echo $sql;
		
		$dbgrid=create_pager_db_grid("menu", $sql, "editor", "page.php", "&me_index=#Menu&userdb = $database", "", false, true, $dialog, array(), 15, $grid_colors, $cs);
		
		$dbgrid=table_shadow("menu", $dbgrid);
		
		echo $dbgrid;
		*/

		if($pa_filename!= "" && $save== "Oui") {
			copy($tmp_filename, $pa_filename);
		}

		$handle=opendir("$siteroot/");
		while ($file = readdir($handle)) {
			$fl=strlen($file);
			if($fl>4 && substr($file, $fl-4, 4)== ".php") {
				$sql = "select me_index from menus, pages ";
				$sql.= "where menus.pa_index=pages.pa_index and pa_filename='$file'";
				$result=mysql_query($sql, $cs);
				$rows=mysql_fetch_array($result);
				echo "<a href='$httproot/$userdb/fr/$file?id = ".$rows[0]."&lg=fr&action=Ajouter' target='_new'>$file</a><br>\n";
			}
		}
		closedir($handle);
	}
?>
</center>
