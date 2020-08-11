<?php
/**
 * Создание таблицы с полями представляющими ФИО, дату рождения, пол.
 */
function assignment1()
{
    if(!($person = new Person())->isTableExists()){
        $person->createTable();
        echo "Таблица создана\n";
    }else{
        echo "Таблица уже существует\n";
    }
}