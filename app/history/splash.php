<html>
<body bgcolor="#FFFFFF" text="#000000" link="#888888" vlink="#880000" alink="#FF0000" leftmargin="0" topmargin="0">
<?php
	define('CUSTOM_NAMESPACE', 'Puzzle');

	$img="images";
?>
	<div style="position:absolute;z-index:1;top:150;left:150">
		<table border="0" cellpadding="0" cellspacing="0"><tr><td>
		<img
			id="logo"
			src="<?php echo $img?>/big_logo.png"
			height="202" width="724"
			onMouseOut="PZ_IMG.src='<?php echo $img?>/big_logo.png';"
			onMouseOver="PZ_IMG=document.getElementById('logo'); PZ_IMG.src='<?php echo $img?>/big_logo_light.png';"
			onClick="document.location.href='page.php?id=10&lg=fr';"
		>
		</td></tr>
		<tr><td align="center">
			Puzzle Factory 0.2 alpha (C) 2003-2004 DPJB
		</td></tr>
		</table>
	</div>
</body>
</html>