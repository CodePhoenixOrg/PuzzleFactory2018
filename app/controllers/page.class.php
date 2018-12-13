<?php

namespace WebFactory\Controllers;

use \WebFactory\Business\Menus as MenusBusiness;
use Phink\Core\TApplication;

class Page extends \Phink\MVC\TController
{
    protected $img = 'images';
    protected $page;
    protected $toplinks;
    protected $main_menu;
    protected $sub_menu;
    protected $title;
    protected $back_color;
    protected $text_color;
    protected $link_color;
    protected $vlink_color;
    protected $alink_color;
    protected $di;

    public function init ()
    {
        //\Phink\Log\TLog::debug('LOAD');
        $_SESSION["javascript"] = "";
    
        if (!isset($lg)) {
            $lg = "fr";
        }
    
        //$this->main_menu = \iPuzzle\Menus::create_main_menu('', 1, $lg);
        include BUSINESS_ROOT . 'menus.class.php';

        $menus = new MenusBusiness();
        $this->main_menu = $menus->createMainMenu();
        TApplication::getLogger()->dump('MAIN MENU', $this->main_menu);

        $this->sub_menu = $menus->createSubMenu($lg, SUB_MENU_HORIZONTAL);
        $this->toplinks = $this->main_menu["menu"];
        $default_id = $this->main_menu["index"];
        TApplication::getLogger()->dump('TOP LINKS', $this->toplinks);
        TApplication::getLogger()->dump('SUB MENU', $this->sub_menu);
        TApplication::getLogger()->dump('PAGE ID', $default_id);

        // if ($id==1) {
        //     $id = $default_id;
        //     unset($di);
        // }

        /*
        if (isset($di) && !isset($id)) {
            $title_page = \iPuzzle\Menus::retrieve_page_by_dictionary_index('', $di, $lg);
            $id = $title_page["index"];
            if ($id = "") {
                $id = $default_id;
            }
        }
        if (isset($id) && !isset($di)) {
            $title_page = \iPuzzle\Menus::retrieve_page_by_menu_index('', $id, $lg);
            $di = $title_page["index"];
        }
        if (!isset($id) && !isset($di)) {
            $id = $default_id;
            $title_page = \iPuzzle\Menus::retrieve_page_by_menu_index('', $id, $lg);
            $di = $title_page["index"];
        }
        */
        $id = $default_id;
        $title_page = $menus->retrievePageByMenuIndex($id, $lg);
        $di = $title_page["index"];

        $this->title = $title_page["title"];
        $this->page = $lg . "/" . $title_page["page"];

        TApplication::getLogger()->dump('PAGE', $title_page);
    
        if (!empty($page_colors)) {
            $this->back_color = $page_colors["back_color"];
            $this->text_color = $page_colors["text_color"];
            $this->link_color = $page_colors["link_color"];
            $this->vlink_color = $page_colors["vlink_color"];
            $this->alink_color = $page_colors["alink_color"];
        } else {
            $this->back_color = "black";
            $this->text_color = "black";
            $this->link_color = "black";
            $this->vlink_color = "black";
            $this->alink_color = "black";
        }

        $this->img = "images";
    
        //$ses_login = $_SESSION["ses_login"];
    //$authentication=get_authentication($ses_login);

    //if($authentication) {
    }
}
