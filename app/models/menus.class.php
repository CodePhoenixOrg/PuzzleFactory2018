<?php
namespace WebFactory\Models;

require_once APP_DATA . 'connection.php';

class Menus extends \Phink\MVC\TModel
{
    public function init()
    {
        $this->connector = new \WebFactory\Data\Connection();
        $this->connector->open();
    }
    
    public function getMainMenu()
    {
        /*
        select m.pa_index, m.me_level, d.di_${lg}_short
            from ${db_prefix}menus m,  ${db_prefix}dictionary d
            where m.di_index=d.di_index
            and m.me_level='${level}'
            order by m.me_index
        */
        $sql = <<<SELECT
select m.pa_index, m.me_level, d.di_fr_short
from menus m, dictionary d
where m.di_index=d.di_index 
and m.me_level='1' 
order by m.me_index
SELECT;
        
        $cmd = new \Phink\Data\Client\PDO\TPdoCommand($this->connector);
        $stmt = $cmd->query($sql);

        return $stmt;
    }


    public function getSubMenu($id=0, $lg = 'fr')
    {

        /*
    $sql=	"select m.me_index, m.me_level, d.di_" . $lg . "_short, m.me_target, p.pa_filename, p.pa_index " .
        "from  ${db_prefix}menus m,  ${db_prefix}pages p,  ${db_prefix}dictionary d " .
        "where m.di_index=d.di_index " .
        //"and p.pa_index=m.pa_index " .
        //"and m.me_index<>m.pa_index " .
        "and m.me_level>1 "; //.
        //"and m.pa_index=" . $id;
        //and m.me_index<>m.pa_index
        */
        $sql = <<<SELECT
select m.me_index, m.me_level, d.di_fr_short, m.me_target, p.pa_filename, p.pa_index
from menus m, pages p, dictionary d
where m.di_index=d.di_index
-- and p.pa_index=m.pa_index
-- and m.me_index<>m.pa_index
and m.me_level>1
-- and m.pa_index=:id;
-- and m.me_index<>m.pa_index
SELECT;

        $cmd = new \Phink\Data\Client\PDO\TPdoCommand($this->connector);
        $stmt = $cmd->query($sql);

        return $stmt;

    }

	function getPageByMenuIndex($id=0, $lg="fr") {
/*
		$sql=   "select d.di_index, p.pa_filename, m.me_charset, d.di_" . $lg . "_short, d.di_" . $lg . "_long " .
        "from  ${db_prefix}pages p,  ${db_prefix}menus m,  ${db_prefix}dictionary d " .
        "where m.di_index=d.di_index "; //.
        //"and p.di_index=m.di_index " .
    //	"and m.me_index=$id";
        //"and p.pa_index=m.me_index " .
        */
        $sql = <<< SELECT
select d.di_index, p.pa_filename, m.me_charset, d.di_fr_short, d.di_fr_long
from  pages p, menus m, dictionary d
where m.di_index=d.di_index
and p.di_index=m.di_index
and m.me_index=:id
and p.pa_index=m.me_index
SELECT;

        $cmd = new \Phink\Data\Client\PDO\TPdoCommand($this->connector);
        $stmt = $cmd->query($sql, [':id' => $id]);

        return $stmt;
    }
}
