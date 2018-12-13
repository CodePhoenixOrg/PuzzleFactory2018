<?php

namespace WebFactory\Business;

use Phink\Core\TObject;
use WebFactory\Models\Menus as MenusModel;
use Phink\Core\TApplication;

class Menus extends TObject
{
    public function createMainMenu($lg = 'fr')
    {
        include_once MODEL_ROOT . 'menus.class.php';
        //get_variable("lg");
        
        $main_menu="<table border='0' cellpading='0' cellspacing='0'><tr>";

        $model = new MenusModel();
        $stmt = $model->getMainMenu();
        while ($rows = $stmt->fetch()) {
            $index = $rows[0];
            $level = $rows[1];
            $caption = $rows[2];
            //$target=$rows[3];
            //$link=$rows[4];
            
            #$main_menu=$main_menu . "<td bgcolor='black'><a href='page.php?id=$index&lg=" . $lg . "'><font color='#ffffff'><b>$caption</b></font></a><font color='#ffffff'><b>&nbsp;|&nbsp;</b></font></td>";
            $main_menu = $main_menu . "<td><a href='page.php?id=$index&lg=" . $lg . "'><font color='#ffffff'><b>$caption</b></font></a><font color='#ffffff'><b>&nbsp;|&nbsp;</b></font></td>";
            
            if ($count == 0) {
                $default_index = $index;
            }
            $count++;
        }
        $main_menu = substr($main_menu, 0, strlen($main_menu)-23);
        $main_menu .= "</tr></table>";
        
        return array("index"=>$default_index, "menu"=>$main_menu);
    }

    public function createSubMenu($lg = 'fr', $orientation = SUB_MENU_HORIZONTAL)
    {
        include_once MODEL_ROOT . 'menus.class.php';

        if ($orientation==SUB_MENU_HORIZONTAL) {
            $sub_menu="";
        } elseif ($orientation==SUB_MENU_VERTICAL) {
            $sub_menu="<table width='100%'>";
        }
    
        $model = new MenusModel();
        $stmt = $model->getSubMenu(1, $lg);
        while ($rows=$stmt->fetch()) {
            $index=$rows[0];
            $level=$rows[1];
            $caption=$rows[2];
            $target=$rows[3];
            $link=$rows[4];
            $page=$rows[5];
            if ($orientation==SUB_MENU_HORIZONTAL) {
                switch ($level) {
            case "2":
                $sub_menu.="<a href='page.php?id=$index&lg=" . $lg . "'><font color='#FFFFFF'>$caption</font></a><font color='#FFFFFF'>&nbsp;|&nbsp;</font>";
                break;
            case "3":
                $sub_menu.="<a href='$target?id=$index&lg=" . $lg . "'><font color='#FFFFFF'>$caption</font></a><font color='#FFFFFF'>&nbsp;|&nbsp;</font>";
                break;
            case "4":
                $sub_menu.="<a href='page.php?id=$page&lg=" . $lg . "#$target'><font color='#FFFFFF'>$caption</font></a><font color='#FFFFFF'>&nbsp;|&nbsp;</font>";
                //$sub_menu.="<a href='$PHP_SELF#$target'><font color='#FFFFFF'>$caption</font></a><font color='#FFFFFF'>&nbsp;|&nbsp;</font>";
                break;
                }
            } elseif ($orientation==SUB_MENU_VERTICAL) {
                switch ($level) {
            case "2":
                $sub_menu.="<tr><td><a href='page.php?id=$index&lg=" . $lg . "'>$caption</a></td></tr>";
                break;
            case "3":
                $sub_menu.="<tr><td><a href='$target?id=$index&lg=" . $lg . "'>$caption</a></td></tr>";
                break;
            case "4":
                $sub_menu.="<tr><td><a href='page.php?id=$page&lg=" . $lg . "#$target'>$caption</a></td></tr>";
                break;
            case "5":
                $sub_menu.="<tr><td>&nbsp;&nbsp;&nbsp;<a href='page.php?id=$page&lg=" . $lg . "#$target'>$caption</a></td></tr>";
                // no break
            case "6":
                $sub_menu.="<tr><td><a href='$link' target='_new'>$caption</a></td></tr>";
                break;
                }
            }
        }
        if ($orientation==SUB_MENU_HORIZONTAL) {
            $sub_menu=substr($sub_menu, 0, strlen($sub_menu)-14);
        } elseif ($orientation==SUB_MENU_VERTICAL) {
            $sub_menu.="</table>";
        }
        return $sub_menu;
    }

	function retrievePageByMenuIndex($id=0, $lg="fr") {
        include_once MODEL_ROOT . 'menus.class.php';

		$title="";
		$page="";

        $model = new MenusModel();
        $stmt = $model->getPageByMenuIndex($id, $lg);
        $rows = $stmt->fetch();
        
        // TApplication::getLogger()->dump('PAGE ROW', $rows);
        
		$index = $rows[0];
		$page = $rows[1];
		$charset = $rows[2];
		$title = $rows[4];
		if($title=="") $title = $rows[3];
		
		$request="";
		$p=strpos($page, "?", 0);
		if($p>-1) {
			$request="&".substr($page, $p+1, strlen($page)-$p);
			$page=substr($page, 0, $p);
		}
		
		$title_page=array("index"=>$index, "title"=>$title, "page"=>$page, "request"=>$request, "charset"=>$charset);

		/*
		$filename=$lg."/".$page;
		
		if (!file_exists($filename)) {
			copy("includes/fichier_vide.php", $filename);
		}
		*/
		return $title_page;
	}

}
