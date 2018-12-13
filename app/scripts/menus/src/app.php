#!/usr/bin/env php
<?php
namespace WebFactory\Tests;

include 'phink/phink_library.php';

use WebFactory\Business\Menus as MenusBusiness;

class Menus extends \Phink\UI\TConsoleApplication
{
    /**
     * Application starter
     *
     * @param array $argv List of argunments of the command line
     * @param int $argc Count the number of these arguments
     */
    public static function main($args_v, $args_c = 0)
    {
        (new Menus($args_v, $args_c));
    }

    /**
     * Takes arguments of the command line in parameters.
     * The start make this job fine.
     *
     * @param array $argv List of argunments of the command line
     * @param int $argc Count the number of these arguments
     */
    public function __construct($args_v, $args_c = 0)
    {
        $dir = dirname(__FILE__);
        parent::__construct($args_v, $args_c, $dir);
    }

    /**
     * Entrypoint of a TConsoleApplication
     */
    public function run()
    {
        if ($this->canStop()) {
            return;
        }

        $this->createMainMenuTest();
    }

    public function createMainMenuTest()
    {
        include BUSINESS_ROOT . 'menus.class.php';

        $menus = new MenusBusiness();
        $mainmenu = $menus->createMainMenu();

        print_r($mainmenu);
    }

    public function modelTest()
    {
        require MODEL_ROOT . 'menus.class.php';

        try {
            $model = new \WebFactory\Models\Menus();
            $cmd = $model->getMainMenu();

            print_r($cmd->getSelectQuery());

            $stmt = $cmd->querySelect();
            $res = $stmt->fetchAll();

            print $stmt->getFieldCount() . PHP_EOL;

            print_r($res);
        } catch (\PDOException $ex) {
            var_dump($ex);
            self::$logger->exception($ex, __FILE__, __LINE__);
        }
    }

    public function ladminTest()
    {
        require_once APP_DATA . 'ladmin_connection.php';

        $connector = new \SoL\Data\LAdminConnection();
        $connector->open();

        try {
            $cmd = new Phink\Data\Client\PDO\TPdoCommand($connector);
            $cmd->setCommandText('select * from members;');
            $stmt = $cmd->query();
            print $stmt->getFieldCount() . PHP_EOL;
            $res = $stmt->fetchAll();
            print_r($res);
        } catch (\PDOException $ex) {
            var_dump($ex);
            self::$logger->exception($ex, __FILE__, __LINE__);
        }
    }
}

Menus::main($argv, $argc);
