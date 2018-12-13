<?php
	include_once("ipuzzle/pz_style.php");
	include_once("ipuzzle/pz_mysqlconn.php");
	include_once("ipuzzle/pz_misc.php");

	$cs=connection("connect", $userdb);
	if(empty($lg)) $lg='fr';

	$wwwroot=get_www_root();
	$filepath = "$wwwroot/../$userdb/fr/$pa_filename";
	echo "filepath = $filepath<br>";
		
if(empty($valider)) {
	switch($action) {
	case "Ajouter":
		$sql = "select max(me_index) from menus";
		$result=mysql_query($sql, $cs);
		$rows=mysql_fetch_array($result);
		$me_index = $rows[0]+1;

		$sql = "select max(pa_index) from pages";
		$result=mysql_query($sql, $cs);
		$rows=mysql_fetch_array($result);
		$new_pa_index = $rows[0]+1;
		
		$pa_index=0;
		$me_target = "";
		$me_level = "";
		$di_index = "";
		$pa_filename = "";
		$di_fr_short = "";
		$di_fr_long = "";
		$di_en_short = "";
		$di_en_long = "";
	break;
	case "Modifier":
		$sql = "select * from v_menus where me_index = $me_index";
		$result=mysql_query($sql, $cs);
		$rows=mysql_fetch_array($result);
		$me_index = $rows[0];
		$pa_index = $rows[1];
		$me_target = $rows[2];
		$me_level = $rows[3];
		$di_index = $rows[4];
		$pa_filename = $rows[5];
		$di_fr_short = $rows[6];
		$di_fr_long = $rows[7];
		$di_en_short = $rows[8];
		$di_en_long = $rows[9];
	break;	
	}
} else {
	switch($action) {
	case "Ajouter":
		$sql=   "insert into menus " .
			"values($me_index, '$di_index', '$me_level', '$me_target', $pa_index)" ;
		echo "$sql<br>";
		$result=mysql_query($sql, $cs);
		
		$sql=   "insert into pages " .
			"values($new_pa_index, '$di_index', '$pa_filename')" ;
		echo "$sql<br>";
		$result=mysql_query($sql, $cs);
		
		$sql=   "insert into dictionary " .
			"values('$di_index', '$di_fr_short', '$di_fr_long', '$di_en_short', '$di_en_long')" ;
		echo "$sql<br>";
		$result=mysql_query($sql, $cs);

		copy("includes/fichier_vide.php", "fr/$pa_filename");
		copy("includes/fichier_vide.php", "en/$pa_filename");
		
	break;
	case "Modifier":
		$sql=   "update menus set di_index='$di_index', me_level='$me_level', me_target='$me_target', pa_index = $pa_index ".
			"where me_index = $me_index";
		$result=mysql_query($sql, $cs);
		$sql=   "update pages set di_index='$di_index', pa_filename='$pa_filename'".
			"where pa_index = $pa_index";
		$result=mysql_query($sql, $cs);
		$sql=   "update menus set di_fr_short='$di_fr_short', di_fr_long='$di_fr_long', di_en_short='$di_en_short', di_en_long='$di_en_long'".
			"where di_index = $di_index";
		$result=mysql_query($sql, $cs);
	break;
	case "Supprimer":
		$sql = "delete from menus where di_index='$di_index'";
		$result=mysql_query($sql, $cs);
		$sql = "delete from pages where di_index='$di_index'";
		$result=mysql_query($sql, $cs);
		$sql = "delete from dictionary where di_index='$di_index'";
		$result=mysql_query($sql, $cs);
		
		unlink($filepath);
	break;	
	}
	echo "<script language=Javascript>window.location.href='page.php&di=home'</script>";
}
?> 
<form method = "post" action = "<?php echo $PHP_SELF?>">
<table>
<tr><td>Index de menu</td><td><?php echo $me_index ?></td></tr>
  <input type = "hidden" name = "me_index" value = "<?php echo $me_index?>">
  <tr><td>Index de page</td><td><?php echo $new_pa_index ?></td></tr>
  <input type = "hidden" name = "new_pa_index" value = "<?php echo $new_pa_index?>">
  <?php
  	if(empty($pa_index)) $pa_index = $new_pa_index;
  ?>
  <tr><td>R�f�rence � la page</td><td><input type = "text" name = "pa_index" value='<?php echo $pa_index ?>'></td><td>
  Un index de r�f�rence diff�rent de l'index de page permet de placer cette page en sous-menu.<br>Le sous-menu a g�n�ralement un niveau de menu � 2 ou 0 (invisible)
  </td></tr>
  <?php
  	if(empty($me_target)) $me_target = "page";
  ?>
  <tr><td>Cible dans la page</td><td><input type = "text" name = "me_target" value='<?php echo $me_target ?>'></td><td>
  param�tre "page" par d�faut
  </td></tr>
  <?php
  	if(empty($me_level)) $me_level=0;
  ?>
  <tr><td>Niveau de menu </td><td><input type = "text" name = "me_level" value='<?php echo $me_level ?>'></td><td>
  0=hors des menus, 1=menu en haut, 2=menu sur le c�t�
  </td></tr>
  <tr><td>Nom de la page</td><td><input type = "text" name = "pa_filename" value='<?php echo $pa_filename ?>'></td><td>
  ne pas oublier l'extension de la page (ex: .php, .html)
  </td></tr>
  <tr><td>Index du dictionnaire</td><td><input type = "text" name = "di_index" value='<?php echo $di_index ?>'></td><td>
  nom tres r�duit servant d'index, 8 lettres maxi
  </td></tr>
  <tr><td>Libell� fran�ais court</td><td><input type = "text" name = "di_fr_short" value='<?php echo $di_fr_short ?>'></td><td>Obligatoire. Donne un nom lit�ral � la page.<br>Il est prioritairement plac� dans les menus.
  </td></tr>
  <tr><td>Libell� fran�ais long</td><td><input type = "text" name = "di_fr_long" value='<?php echo $di_fr_long ?>'></td><td>Facultatif. Donne un nom explicite � la page situ� entre le contenu de la page et le menu du haut<br>En l'absence de nom long, le nom court est utilis�.
  </td></tr>
  <tr><td>Libell� anglais court</td><td><input type = "text" name = "di_en_short" value='<?php echo $di_en_short ?>'></td><td>Recommend�.
  </td></tr>
  <tr><td>Libell� anglais long</td><td><input type = "text" name = "di_en_long" value='<?php echo $di_en_long ?>'></td><td>Facultatif.
  </td></tr>
  </table>
  <input type = "hidden" name = "valider" value = "OK">
  <input type = "hidden" name = "database" value = "<?php echo $userdb?>">
  <input type = "submit" name = "action" value = "<?php echo $action?>">
  <input type = "submit" name = "action" value = "Supprimer">
  <input type = "submit" name = "annuler" value = "Annuler">
</form>







