<script language="JavaScript">
	//Param�tres c�t� client
	
	//couleur de surlignage (menus, dbGrid, etc.)
	var hlBackColor="#46a0E9";
	var hlTextColor="white";
</script>
<?php
	//Param�tres c�t� serveur
	
	//Coleurs de la page assign�es au tag BODY (text, fond, liens)
	global $page_colors;
	$page_colors=array(
		"back_color"=>"white",
		"text_color"=>"black",
		"link_color"=>"black",
		"vlink_color"=>"black",
		"alink_color"=>"blue"
	);
	
	//Couleurs des blocs et des panels (news, etc.) 
	global $panel_colors;
	$panel_colors=array(
		"border_color"=>"#1680d9",
		"caption_color"=>"white",
		"back_color"=>"#E0E0E0",
		"fore_color"=>"black"
	);

	//Couleurs de l'agenda
	global $diary_colors;
	$diary_colors=array(
		"border_color"=>$panel_colors["border_color"],
		"caption_color"=>$panel_colors["caption_color"],
		"back_color"=>$panel_colors["back_color"],
		"fore_color"=>$panel_colors["fore_color"],
		"hl_back_color"=>"#46A0E9",
		"hl_text_color"=>"white"
	);
	
	//couleurs du control dbGrid
	global $grid_colors;
	$grid_colors=array(
		"border_color"=>"white",
		"header_back_color"=>"#1680d9",
		"even_back_color"=>"#88DDFF",
		"odd_back_color"=>"#88CCFF", 
		"header_fore_color"=>"white",
		"even_fore_color"=>"black",
		"odd_fore_color"=>"black",
		"pager_color"=>"#E0E0E0"
	);

	//Initialisation de l'affichage sur la premi�re page du menu en fran�ais
	if(!isset($id)) $id="1";
	if(!isset($lg)) $lg="fr";

	$database="factory";
?>
