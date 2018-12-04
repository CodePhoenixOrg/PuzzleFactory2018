<script language='JavaScript' src='js/pz_form_events.js'></script>
<?php
	include_once("pz_db.php");
	include_once("pz_mysqlconn.php");
	$cs=connection(CONNECT,$database);

	if(!isset($event)) $event="onLoad";
	if(!isset($action)) $action="Modifier";

	$mbr_index=$_SESSION["ses_index"];
?>
	<form method='POST' name='profileForm' action='page.php?id=15&lg=fr'>
<?
	if($event=="onLoad") {
		$sql="select * from members where mbr_index=$mbr_index;";
		$result = mysql_query($sql, $cs);
		$rows = mysql_fetch_array($result);
		$mbr_index=$rows["mbr_index"];
		$mbr_nom=$rows["mbr_nom"];
		$mbr_email=$rows["mbr_email"];
		$mbr_ident=$rows["mbr_ident"];
		$mbr_mpasse=$rows["mbr_mpasse"];
	} else if($event=="onRun") {
		$cs=connection("disconnect","puzzle");
		echo "<script language='JavaScript'>window.location.assign('page.php?id=16&lg=fr&action=Modifier&mbr_index=$mbr_index')</script>";
	} else if($event=="onUnload") {
		$cs=connection("disconnect","puzzle");
		echo "<script language='JavaScript'>window.location.assign('page.php?id=1&lg=fr')</script>";
	}

	if($event=="onLoad") {
?>
<center>
	Voici les informations que vous avez entré.<br><br>
	
	<table border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="right">
			NOM Prénom
		</td>
		<td>
			<?echo $mbr_nom?>
		</td>
	</tr>
	<tr>
		<td align="right">
			Adresse e-mail
		</td>
		<td>
			<?echo $mbr_email?>
		</td>
	</tr>
	<tr>
		<td align="right">
			Login
		</td>
		<td>
			<?echo $mbr_ident?>
		</td>
	</tr>
	<tr>
		<td align="right">
			Mot de passe
		</td>
		<td>
			<?echo $mbr_mpasse?>
		</td>
	</tr>
		<td align='center' colspan='2'>
			<input type='hidden' name='event' value=''>
			<input type='hidden' name='mbr_index' value='<?echo $mbr_index?>'>
			<input type='submit' name='action' value='<?echo $action?>' onClick='return runForm("profileForm");'>
			<input type='submit' name='action' value='Fermer' onClick='return unloadForm("profileForm");'>
		</td>
	</tr>
	</table>
</center>

</form>
<?
}
?>		
