<?php

require_once 'persistence/CategoryJSON.php';
require_once 'persistence/CategorySQL.php';

class CategoryFactory {

    public static function create() {
        $config = require '../config.php';

        switch ($config['persistence']) {
            case 'json':
                $adapter = new CategoryJSON();
                break;

            case 'sql':
                $adapter = new CategorySQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new Category($adapter);
    }
}