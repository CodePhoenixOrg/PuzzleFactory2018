<html>

<body bgcolor="#FFFFFF" text="#000000" link="#888888" vlink="#880000" alink="#FF0000" leftmargin="0" topmargin="0">

<?php
	include("pz_mysqlconn.php");
	$cs=connection(CONNECT, "puzzle");
	if(empty($lg)) $lg="fr";

	/*
	$sql="select lg_index from languages";
	$result=mysql_query($sql, $cs);
	$i=mysql_num_rows($result);
	$offset=0;
	while($rows=mysql_fetch_array($result)) {
		$offset+=135/$i;
		$deg=$offset+135;
		
		$left=225+120*cos(deg2rad($deg))-15;
		$top=230+120*sin(deg2rad($deg))-8;
?>
		<div style="position:absolute;z-index:2;top:<?echo $top?>;left:<?echo $left?>" >
			<img
				id="<?echo $rows[0]?>"
				src="<?echo $img?>/flags/<?echo $rows[0]?>.png"
				height="16" width="30"
				onMouseOut="PZ_IMG.src='<?echo $img?>/flags/<?echo $rows[0]?>.png';"
				onMouseOver="PZ_IMG=document.getElementById('<?echo $rows[0]?>'); PZ_IMG.src='<?echo $img?>/flags/<?echo $rows[0]?>_light.png';"
			><br>
		</div>
<?php
	}
	*/
?>
	<div style="position:absolute;z-index:1;top:150;left:150">
		<img src="<?echo $img?>/big_logo.png" height="173" width="723">
	</div>
<?php
	$sql="select d.di_".$lg."_short, m.me_index from menus m, dictionary d where d.di_index=m.di_index and m.me_level=1";
	$result=mysql_query($sql, $cs);
	$i=mysql_num_rows($result);
	$offset=0;
	while($rows=mysql_fetch_array($result)) {
		$offset+=125/$i;
		$deg=$offset+270;
		
		$left=612+350*sin(deg2rad($deg))-43;
		$top=285+150*cos(deg2rad($deg))-43;
?>
		<div style="position:absolute;z-index:1;top:<?echo $top?>;left:<?echo $left?>" >
			<img
				id="<?echo $rows[0]?>"
				src="<?echo $img?>/pieces_logo.png"
				height="88" width="88"
				onMouseOut="PZ_IMG.src='<?echo $img?>/pieces_logo.png';"
				onMouseOver="PZ_IMG=document.getElementById('<?echo $rows[0]?>'); PZ_IMG.src='<?echo $img?>/pieces_logo_light.png';"
				onClick="document.location.href='page.php?id=<?echo $rows[1]?>&lg=fr';"
			><br>
			<?echo $rows[0]?>
		</div>
<?php					
	}
?>
</body>
</html>
