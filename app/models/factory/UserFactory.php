<?php

require_once __DIR__ . '/../persistence/UserJSON.php';
require_once __DIR__ . '/../persistence/UserSQL.php';


class UserFactory {

    public static function create(): User {
        
        $config = require '../config.php';

        switch ($config['persistence']) {
            case 'json':
                $persistence = new UserJSON();
                break;

            case 'sql':
                $persistence = new UserSQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new User($persistence);
    }
}