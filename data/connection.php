<?php

namespace WebFactory\Data;

use \Phink\Data\Client\PDO\TPdoCommand;

class Connection extends \Phink\Data\Client\PDO\TPdoConnection {
    private static $_connection = null;

    public function __construct() {
        $config = new \Phink\Data\Client\PDO\TPdoConfiguration(\Phink\Data\TServerType::MYSQL, 'webfactory', 'localhost', 'root', '1Am2Sword');
        
        parent::__construct($config);
    }

    public static function getInstance() {

        if(self::$_connection === null) {
            self::$_connection = new Connection();
            self::$_connection->open();
        }

        return self::$_connection;
    }

    public static function getCommand() {
        return new TPdoCommand(self::getInstance());
    }
}
