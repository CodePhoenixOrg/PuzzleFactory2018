<script language='JavaScript' src='js/pz_form_events.js'></script>
<?php
	include_once("pz_mysqlconn.php");
	$cs=connection(CONNECT,$database);
	if(!isset($event)) $event="onLoad";
	if(!isset($action)) $action="Modifier";

	$status=$_SESSION["ses_status"];
	$mbr_index=$_SESSION["ses_index"];
	if($status==MEMBER_LOGGED_OUT && $action=="Modifier") $event="onAccessDenied";
	
	if($event=="onLoad") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(mbr_index) from members;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$mbr_index=$rows[0]+1;
			$mbr_nom="";
			$mbr_adr1="";
			$mbr_adr2="";
			$cp_index="";
			$mbr_email="";
			$mbr_ident="";
			$mbr_mpasse="";
			
			$description="Pour devenir membre, vous devez vous inscire en remplissant le formulaire suivant.<br><br>";
		break;
		case "Modifier":
			$sql="select * from members where mbr_index=$mbr_index;";
			$result = mysql_query($sql, $cs);
			$rows = mysql_fetch_array($result);
			$mbr_index=$rows["mbr_index"];
			$mbr_nom=$rows["mbr_nom"];
			$mbr_adr1=$rows["mbr_adr1"];
			$mbr_adr2=$rows["mbr_adr2"];
			$cp_index=$rows["cp_index"];
			$mbr_email=$rows["mbr_email"];
			$mbr_ident=$rows["mbr_ident"];
			$mbr_mpasse=$rows["mbr_mpasse"];
			
			$description="<br><br>";
		break;
		}
	} else if($event=="onRun") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into members (".
				"mbr_index, ".
				"mbr_nom, ".
				"mbr_adr1, ".
				"mbr_adr2, ".
				"cp_index, ".
				"mbr_email, ".
				"mbr_ident, ".
				"mbr_mpasse".
			") values (".
				"'$mbr_index', ".
				"'$mbr_nom', ".
				"'$mbr_adr1', ".
				"'$mbr_adr2', ".
				"'$cp_index', ".
				"'$mbr_email', ".
				"'$mbr_ident', ".
				"'$mbr_mpasse'".
			")";
			$result = mysql_query($sql, $cs);
			$js="<script language='JavaScript'>window.location.assign('page.php?id=1&lg=$lg')</script>";
		break;
		case "Modifier":
			$sql="update members set ".
				"mbr_index='$mbr_index', ".
				"mbr_nom='$mbr_nom', ".
				"mbr_adr1='$mbr_adr1', ".
				"mbr_adr2='$mbr_adr2', ".
				"cp_index='$cp_index', ".
				"mbr_email='$mbr_email', ".
				"mbr_ident='$mbr_ident', ".
				"mbr_mpasse='$mbr_mpasse' ".
			"where mbr_index='$mbr_index'";
			$result = mysql_query($sql, $cs);
			$js="<script language='JavaScript'>window.location.assign('page.php?id=1&lg=$lg')</script>";
		break;
		case "Supprimer":
			$sql="delete from members where mbr_index='$mbr_index'";
			$result = mysql_query($sql, $cs);
			$js="<script language='JavaScript'>window.location.assign('page.php?id=1&lg=$lg&logout=1')</script>";
		break;
		}
		echo $js;
	} else if($event=="onUnload") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.assign('page.php?id=1&lg=fr')</script>";
	}

	if($event=="onLoad") {
?>
<form method='POST' name='subscribeForm' action='page.php?id=16&lg=fr'>
<input type='hidden' name='event' value=''>
<center>
	<?echo $description?>
	
	<table border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="right">
			NOM Prénom
		</td>
		<td>
			<input type="text" size="25" name="mbr_nom" value="<?echo $mbr_nom?>">
		</td>
	</tr>
	<tr>
		<td align="right">
			Adresse e-mail
		</td>
		<td>
			<input type="text" size="25" name="mbr_email" value="<?echo $mbr_email?>">
		</td>
	</tr>
	<tr>
		<td align="right">
			Login
		</td>
		<td>
			<input type="text" size="25" name="mbr_ident" value="<?echo $mbr_ident?>">
		</td>
	</tr>
	<tr>
		<td align="right">
			Mot de passe
		</td>
		<td>
			<input type="password" size="25" name="mbr_mpasse" value="<?echo $mbr_mpasse?>">
		</td>
	</tr>
	<tr>
		<td align="right">
			Confirmation
		</td>
		<td>
			<input type="password" size="25" name="mbr_confirm" value="<?echo $mbr_confirm?>">
		</td>
	</tr>
	<tr>
		<td align='center' colspan='2'>
		<input type='submit' name='action' value='<?echo $action?>' onClick='return runForm("subscribeForm");'>
		<? 
			if($action=="Modifier")
				echo "<input type='submit' name='action' value='Supprimer' onClick='return runForm(\"subscribeForm\");'>";
		?>
		<input type='reset' name='action' value='Annuler'>
		<input type='submit' name='action' value='Fermer' onClick='return unloadForm("subscribeForm");'>
		</td>
	</tr>
	</table>
</center>

</form>
<?
	} else if($event=="onAccessDenied") {
		echo "Accès refusé. Vous devez vous identifier pour accéder à cette page<br>";
	}
?>
