<?php
/**
 * Вывод всех строк с уникальным значением ФИО+дата, отсортированным по ФИО , вывести ФИО, Дату рождения, пол, кол-во полных лет.
 * Пример запуска приложения:
 * myApp 3
 */
function assignment3(){
    // Получение списка, сгруппированного по full_name  и birthdate
    $list = (new PersonRepository())->findAll(['full_name, birthdate']);

    // Сортировка по имени
    uasort($list, function($a,$b){
        if ($a->getFullName()[0] == $b->getFullName()[0]) {
            return 0;
        }
        return ($a->getFullName()[0]<$b->getFullName()[0]) ? -1 : 1;
    });

    // Вывод пользователей в виде таблицы
    printf("%'-100s\n",'');
    printf("|%-58s|%-15s|%-20s|%-5s|\n",'ФИО','Дата рождения','Пол','Полных лет');
    printf("%'-100s\n",'');
    foreach($list as $person){
        printf("|%-55s|%13s|%-17s|%10s|\n",$person->getFullName(),$person->getBirthdate(),
            $person->getGender(),$person->getAge());
        printf("%'-100s\n",'');
    }
}