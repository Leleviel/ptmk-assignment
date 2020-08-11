<?php
/**
 * Вывод всех строк с уникальным значением ФИО+дата, отсортированным по ФИО , вывести ФИО, Дату рождения, пол, кол-во полных лет.
 * Пример запуска приложения:
 * myApp 3
 */
function assignment3(){
    // Строка запроса
    // Возраст было принято считывать в MySQL, т.к. не был создан объект Person для таблицы, поэтому можно в ручную
    // редактировать, что должно получится
    $query = "SELECT full_name, birthdate, sex, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age 
        FROM (SELECT * FROM assignment.person group by full_name, birthdate) AS t 
        order by full_name";
    // Выполнение запроса
    $result = Db::getInstance()->query($query);
    // Вывод пользователей в виде таблицы
    printf("%'-100s\n",'');
    printf("|%-58s|%-15s|%-20s|%-5s|\n",'ФИО','Дата рождения','Пол','Полных лет');
    printf("%'-100s\n",'');
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        printf("|%-55s|%13s|%-17s|%10s|\n",$row['full_name'],$row['birthdate'],$row['sex'],$row['age']);
        printf("%'-100s\n",'');
    }
}