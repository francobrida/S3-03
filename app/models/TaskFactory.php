<?php

require_once 'persistence/TaskJson.php';
require_once 'persistence/TaskSQL.php';

class TaskFactory {

    public static function create() {
        $config = require 'config.php';

        switch ($config['persistence']) {
            case 'json':
                $adapter = new TaskJSON();
                break;

            case 'sql':
                $adapter = new TaskSQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new Task($adapter);
    }
}