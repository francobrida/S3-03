<?php

require_once __DIR__ . '/../persistence/CategoryJSON.php';
require_once __DIR__ . '/../persistence/CategorySQL.php';

class CategoryFactory {

    public static function create() {
        $config = require '../config.php';

        switch ($config['persistence']) {
            case 'json':
                $persistence = new CategoryJSON();
                break;

            case 'sql':
                $persistence = new CategorySQL();
                break;

            default:
                throw new Exception("Invalid persistence type");
        }

        return new Category($persistence);
    }
}