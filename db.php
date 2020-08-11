<?php

/**
 * Class Db позволяет работать с БД
 */
class Db
{
    /**
     * Переменная, хранящаяя текущее соединение с БД
     * @var mixed
     */
    private static $instance;

    /**
     * Метод, повзволяющий установить соединение с БД и вернуть его.
     * @return mixed
     */
    public static function getInstance()
    {
        // Проверяется, есть уже существующее содинение с БД
        if(!isset(self::$instance)){
            self::$instance = new PDO("mysql:host=localhost;dbname=assignment", "root", '1234');
            // Для текущего соединения устанавливается режим кодировки utf8
            self::$instance->exec("set names utf8");
        }
        return self::$instance;
    }
}