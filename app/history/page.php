<?php 

	include 'phink/phink_library.php';
	include 'ipuzzle/ipuzzle_library.php';

	\Phink\Web\TWebApplication::create();

	// include("ipuzzle/pz_style.php");
	// include("ipuzzle/pz_misc.php");
	//include(PZ_DEFAULTS);
	// include("ipuzzle/pz_menus.php");
	// include("ipuzzle/pz_blocks.php");
	// include("ipuzzle/pz_controls.php");
	// include("ipuzzle/pz_db_controls.php");

	$_SESSION["javascript"]="";
	
	if(!isset($lg)) $lg="fr";
	
	$main_menu = \iPuzzle\Menus::create_main_menu('', 1, $lg);
	$sub_menu = \iPuzzle\Menus::create_sub_menu('', 1, $lg, SUB_MENU_HORIZONTAL);
	$toplinks = $main_menu["menu"];
	$default_id = $main_menu["index"];
	
	if($id==1) {
		$id = $default_id;
		unset($di);
	}	

	if(isset($di) && !isset($id)) {
		$title_page = \iPuzzle\Menus::retrieve_page_by_dictionary_index('', $di, $lg);
		$id = $title_page["index"];
		if($id=="") $id = $default_id;	
	}
	if(isset($id) && !isset($di)) {
		$title_page = \iPuzzle\Menus::retrieve_page_by_menu_index('', $id, $lg);
		$di = $title_page["index"];
	}
	if(!isset($id) && !isset($di)) {
		$id = $default_id;
		$title_page = \iPuzzle\Menus::retrieve_page_by_menu_index('', $id, $lg);
		$di = $title_page["index"];
	}

	$title = $title_page["title"];
	$page = $lg . "/" . $title_page["page"];

	
	if(!empty($page_colors)) {
		$back_color = $page_colors["back_color"];
		$text_color = $page_colors["text_color"];
		$link_color = $page_colors["link_color"];
		$vlink_color = $page_colors["vlink_color"];
		$alink_color = $page_colors["alink_color"];
	} else {
		$back_color="white";
		$text_color="black";
		$link_color="black";
		$vlink_color="black";
		$alink_color="black";
	}

	global $img;
	$img="images";
	
	//$ses_login = $_SESSION["ses_login"];
	//$authentication=get_authentication($ses_login);

	//if($authentication) {

?>
<body bgcolor="<?php echo $back_color?>" text="<?php echo $text_color?>" link="<?php echo $link_color?>" vlink="<?php echo $vlink_color?>" alink="<?php echo $alink_color?>" leftmargin="0" topmargin="0">

<center>
  <table id="my_table_shadow" border="0" cellspacing="0" cellpadding="0">
    <tr><td bgcolor="white" height="3" colspan="2"></td></tr>
    <tr>
      <td rowspan="2" colspan="2">

<table border="1" cellpadding="0" cellspacing="0" height="760" width="760" valign="top"><tr><td>
<table id="my_table" bgcolor="white" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tr height="80">
		<td width="250" height="80" align="left" valign="top" style="font-size: 14;">
			<img id="logo"
	  			src="<?php echo $img?>/small_logo.png"
				onMouseOut="PZ_IMG.src='<?php echo $img?>/small_logo.png';"
				onMouseOver="PZ_IMG=document.getElementById('logo');
						PZ_IMG.src='<?php echo $img?>/small_logo_light.png';"
			  	onClick="document.location.href='<?php echo "."?>'"
	  		>
		</td>
		<td style="font-size: 30" width="510" height="80" align="right" valign="middle">
			<!--img src="<?php echo $img?>/admin/<?php echo $di?>.png" valign="top" border="0"-->
			<?php echo $title?>
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="white" height="8" align="center" valign="top">
		<?php
			echo $toplinks;
			//echo "<br>".$sub_menu;
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="black" height="1" align="center" valign="top"></td>
	</tr>
	<tr bgcolor="#a8eaff">
		<td colspan="2" align="left" valign="top" height="680">
		<?php
			include($page);
		?>
		</td>
	</tr>
</table>
</td></tr></table>

      </td>
      <td background="<?php echo $img?>/shadows/top_right.png" style="font-size: 1; width:11; height:8;"></td>
    </tr>
    <tr>
      <td id="my_table_sh" background="<?php echo $img?>/shadows/right.png" style="font-size: 1; width:11;"></td>
    </tr>
    <tr>
      <td background="<?php echo $img?>/shadows/bottom_left.png" style="font-size: 1; width:8; height:11;"></td>
      <td id="my_table_sw" background="<?php echo $img?>/shadows/bottom.png" style="font-size: 1; height: 11"></td>
      <td background="<?php echo $img?>/shadows/bottom_right.png" style="font-size: 1; width:11; height:11;"></td>
    </tr>
  </table>
</center>
<script language="JavaScript">
	pz_shadow("my_table");

<?php 
	echo $_SESSION["javascript"];
?>
</script>
</body>
<?php
	/*} else {
		echo "<script language='JavaScript'>window.location.href='login.php?lg = $lg';</script>";
	}*/
?>
