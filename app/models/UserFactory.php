<?php

require_once 'persistence/UserJSON.php';
require_once 'persistence/UserSQL.php';
require_once 'User.php'; 

class UserFactory {

    public static function create(): User {
        
        $config = require 'config.php';

        switch ($config['persistence']) {
            case 'json':
                $adapter = new UserJSON();
                break;

            case 'sql':
                $adapter = new UserSQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new User($adapter);
    }
}