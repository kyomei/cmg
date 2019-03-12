<?php

/**
 * Description of DB
 *
 * @author kyomei
 */
require_once 'config.php';

class DB {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=' . HOST . ';dbname=' . BASE.';charset=utf8', USER, PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $ex) {
                echo "Erro na conexão: " . $ex->getMessage();
            }
        }
        return self::$instance;
    }

    public static function prepare($sql) {
        return self::getInstance()->prepare($sql);
    }

}
