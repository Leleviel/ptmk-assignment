<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'db.php';
require_once 'Entity/Person.php';
require_once 'Entity/ORM.php';
require_once 'Repository/PersonRepository.php';
require_once 'Repository/AbstractRepository.php';
// Возможные режимы работы, их описания и что необходимо подключить для их выполнения
$modes = [
    '1' => [
        'description' => 'Создание таблицы в БД',
        'function' => 'assignment1'
    ],
    '2' => [
        'description' => 'Создание записи в БД',
        'function' => 'assignment2'
    ],
    '3' => [
        'description' => 'Вывод всех строк с уникальным значением ФИО+дата, отсортированным по ФИО , вывести ФИО, Дату рождения, пол, кол-во полных лет.',
        'function' => 'assignment3'
    ],
    '4' => [
        'description' => 'Заполнение автоматически 1000000 строк. Распределение пола в них должно быть относительно равномерным, начальной буквы ФИО также. Заполнение автоматически  100 строк в которых пол мужской и ФИО начинается с "F".',
        'function' => 'assignment4'
    ],
    '5' => [
        'description' => 'Результат выборки из таблицы по критерию: пол мужской, ФИО  начинается с "F". Сделать замер времени исполнения.',
        'function' => 'assignment5'
    ],
    '6' => [
        'description' => 'Произвести определенные манипуляции над базой данных для ускорения запроса из пункта 5. Убедиться, что время исполнения уменьшилось. Объяснить смысл произведенных действий. Предоставить результаты замера до и после.',
        'function' => 'assignment6'
    ]
];




// Проверка на ввод значения и иго наличие в списке $modes
if (isset($argv[1]) && isset($modes[$argv[1]])) {
    // Получение названия функции из списка
    $fn = $modes[$argv[1]]['function'];
    // Подключение зависимости, где находится функция
    require_once "assignments\\$fn.php";
    printf("Выбран режим работы %s — %s \n", $argv[1], $modes[$argv[1]]['description']);
    // Вызов функции с аргументами
    call_user_func($modes[$argv[1]]['function'], array_slice($argv, 2));
} else {
    // Вывод пользователю списка возможных действий
    echo "Не выбран режим работы. Возможные режимы:\n";
    foreach ($modes as $number => $addition) {
        echo $number . ".\t" . $addition['description'] . "\n";
    }
}

