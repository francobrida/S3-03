<?php

require_once __DIR__ . '/../persistence/TaskJSON.php';
require_once __DIR__ . '/../persistence/TaskSQL.php';

class TaskFactory {

    public static function create() {
        $config = require '../config.php';

        switch ($config['persistence']) {
            case 'json':
                $persistence = new TaskJSON();
                break;

            case 'sql':
                $persistence = new TaskSQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new Task($persistence);
    }
}