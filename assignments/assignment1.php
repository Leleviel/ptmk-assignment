<?php
/**
 * Создание таблицы с полями представляющими ФИО, дату рождения, пол.
 */
function assignment1()
{
    //  Проверка существования таблцы person
    if (!isTableExists('person')) {
        // SQL запрос на воздание таблицы
        $query = "CREATE TABLE IF NOT EXISTS person(
            id INT AUTO_INCREMENT,
            full_name varchar(255) not null,
            sex varchar(10),
            birthdate DATE,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB";
        // Сам запрос на создание таблицы. В случае успеха будет выведено соответсвующее сообщение
        Db::getInstance()->exec($query);
        echo isTableExists('person')? "Таблица создана успешно\n" : "Не удалось создать таблицу\n";
    } else {
        // Нельзя выводить, что таблица уже существует, так как это могут быть просто неполадки в соединении
        echo "Не удалось создать таблицу\n";
    }
}
/**
 * Иссер, проверяющий, существуетли таблица с заданным имененм
 * @param $table_name наименование таблицы
 * @return bool|false|PDOStatement
 */
function isTableExists($table_name)
{
    try {
        $result = Db::getInstance()->query("SELECT 1 FROM " . $table_name);
    } catch (PDOException $e) {
        return FALSE;
    }
    return boolval($result);
}