<?php
	session_start();
	//ob_start("ob_gzhandler");
?>
<head>
<?php
	include("pz_style.php");
	include("pz_misc.php");
	include(PZ_DEFAULTS);
	include("pz_menus.php");
	include("pz_blocks.php");

	//$filename=$www_root.PZ_JS_TEMP;
	//if (file_exists($filename)) unlink($filename);

	if(!session_is_registered("javascript")) {
		session_register("javascript");
	}
	$_SESSION["javascript"]="";
	if(!isset($lg)) $lg="fr";
	
	$main_menu = create_main_menu($database, 1);
	$toplinks=$main_menu["menu"];
	$default_id=$main_menu["index"];
	
	global $img;
	$img="img";
	
	/*
	if(!isset($di))
		$title_page = retrieve_page_by_menu_index($database, $id, $lg);
	else 
		$title_page = retrieve_page_by_dictionary_index($database, $di, $lg);
	*/
	//$sidelinks = create_menu_tree($database, $id, $lg, SUB_MENU_VERTICAL);
	//$sub_menu = create_sub_menu("alades", $id, $lg, SUB_MENU_HORIZONTAL);
		
	if(isset($di)) {
		$title_page = retrieve_page_by_dictionary_index($database, $di, $lg);
		$id=$title_page["index"];
	} 
	if(isset($id) && !isset($di)) {
		$title_page = retrieve_page_by_menu_index($database, $id, $lg);
		$di=$title_page["index"];
	} 
	if(!isset($id) && !isset($di)) {
		$id="1";
		$title_page = retrieve_page_by_menu_index($database, $id, $lg);
		$di=$title_page["index"];
	}
	
	$title = $title_page["title"];
	$page = $lg . "/" . $title_page["page"];
	
  	$admin_url=get_admin_url($database);
	
	if(!empty($page_colors)) {
		$back_color=$page_colors["back_color"];
		$text_color=$page_colors["text_color"];
		$link_color=$page_colors["link_color"];
		$vlink_color=$page_colors["vlink_color"];
		$alink_color=$page_colors["alink_color"];
	} else {
		$back_color="white";
		$text_color="black";
		$link_color="black";
		$vlink_color="black";
		$alink_color="black";
	}

?>	
	<title>Bienvenue sur le site du projet Puzzle</title>
	<meta http-equiv="Content-Type" content="text/html">
       	<META NAME="Generator" CONTENT="PHP, HTML & JavaScript code: gVim; Graphics: The GIMP">
       	<META NAME="Description" CONTENT="Puzzle">
        <META NAME="Keywords" CONTENT="web, creation, puzzle, database, php, delphi, kylix, mysql">
       	<META NAME="Author" CONTENT="David BL:ANCHARD">
        <META NAME="Identifier-URL" CONTENT="http://akades.free.fr">
        <META NAME="Reply-to" CONTENT="davidbl@wanadoo.fr">
       	<META NAME="Category" CONTENT="Internet">
        <META NAME="Publisher" CONTENT="www.free.fr">
       	<META NAME="Copyright" CONTENT="(C)2001-2003 David BLANCHARD">

</head>

<body bgcolor="<?echo $back_color?>" text="<?echo $text_color?>" link="<?echo $link_color?>" vlink="<?echo $vlink_color?>" alink="<?echo $alink_color?>" leftmargin="0" topmargin="0">
<center>
<table valign="top" width="790" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3" height="50"> 
      <table valign="top" width="100%" border="0" cellspacing="0" cellpadding="00" height="100%">
        <tr> 
          <td align="center" width="86%" height="24">
	  <img
		id="logo"
	  	src="<?echo $img?>/logo.png" width="368" height="88"
		height="16" width="30"
		onMouseOut="PZ_IMG.src='<?echo $img?>/logo.png';"
		onMouseOver="PZ_IMG=document.getElementById('logo'); PZ_IMG.src='<?echo $img?>/logo_light.png';"
	  	onClick="document.location.href='index.php?lg=<?echo $lg?>'"
	  >
	  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="25%" height="8" align="left" valign="middle">
    	<?php
		if($_SESSION["ses_nom"]!="") echo "Bienvenue ".$_SESSION["ses_nom"];
	?>
    </td>
    <td width="50%" height="8" align="center" valign="middle"><?php echo $toplinks ?></td>
    <td width="25%" height="8" align="right" valign="middle">&nbsp;</td>
  </tr>
    <tr>
    <td colspan="3" width="790" height="1" background="<?echo $img?>/bar.jpg" align="middle" valign="middle">
    	<?php //echo $sub_menu ?>
    </td>
  </tr>
  <tr> 
    <td width="790" height="430" colspan="3" align="center"> 
      <table valign="top" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
        <tr height="100%"> 
          <td valign="top" width="100" height="100%">
		<?php 
			$members_block=create_members_block($database, $logout, "members", $id, $lg, $panel_colors);
			echo $members_block."\n\n";

			$msg=perform_members_ident($mbr_login, $mbr_pass, $mbr_valider);
			echo $msg;

			$block_set=create_block_set($database, BLOCK_LEFT_COLUMN, $id, $lg, $panel_colors);
			echo $block_set."\n\n";
		?>
	
	    </td>
	    <td width="16"></td>
          <td valign="top" width="600">
		<font face="helvetica"><center><H2>
		<?php 
			echo $title."<br>";
		?>
	      </H2></font></center>
		<font face="helvetica" size="-1">
		<?php 
			include $page;
		?>
		</font>
	</td>
	    <td width="16"></td>
          <td valign="top" width="100" height="100%">
		<?php
			$newsltr_block=create_newsletter_block($database, "newsltr", $id, $lg, $panel_colors);
			echo $newsltr_block."\n\n";
			
			$js=perform_newsletter_subscription($nlr_email, $nlr_subscribe, $nlr_valider);
			echo $js;

			$block_set=create_block_set($database, BLOCK_RIGHT_COLUMN, $id, $lg, $panel_colors);
			echo $block_set."\n\n";

			$calendar_block=create_calendar_block($date, $id, $lg, $panel_colors);
			echo $calendar_block;
			
			/*$newsltr_block=create_newsletter_block($database, "newsltr", $id, $lg, $panel_colors);
			echo $newsltr_block."\n\n";
			
			$msg=perform_newsletter_subscription($nlr_email, $nlr_subscribe, $nlr_valider);
			echo $msg;

			//$block_set=create_block_set($database, BLOCK_RIGHT_COLUMN, $id, $lg);
			//echo $block_set."\n\n";
			*/
		?>
	
	</td>
        </tr>
      </table>
    </td>
  </tr>
    <tr>
    <td colspan="3" width="790" height="1" background="<?echo $img?>/bar.jpg"></td>
    </tr>
    <tr>
    <td colspan="3" align="right" valign="middle"><?php echo "Crédits" ?></td>
  </tr>
</table>
</center>
<script language="JavaScript">
<? 
	//if (file_exists($filename)) include($filename);
	echo $_SESSION["javascript"];
?>
</script>
</body>
<? //ob_end_flush(); ?>
