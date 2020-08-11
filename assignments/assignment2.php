<?php
/**
 * Создание записи. Использовать следующий формат: myApp 2 ФИО ДатаРождения Пол
 * @param $args
 */
function assignment2($args)
{
    // массив содержит возможные не заполненные поля
    $errors = [];
    // массив содержит все необходимые для запроса значения
    // P.S. В самом запросе не используется $args, т.к. пользователь может передать большее количество перменных
    // а array_slice я решил не использовать, т.к. было бы слишком много блоков if
    $values = [];
    // Проверка на передачу пользователем трех значений
    !isset($args[0]) ? array_push($errors, 'ФИО пользователя') : array_push($values, $args[0]);
    !isset($args[1]) ? array_push($errors, 'дата рождения') : array_push($values, $args[1]);
    !isset($args[2]) ? array_push($errors, 'пол') : array_push($values, $args[2]);
    // Если три значения не были переданы, то выводится сообщение и прерывается выполнение функции
    if (!empty($errors)) {
        echo 'Не переданы все данные: ' . join(', ', $errors) . ".\n";
        return;
    }
    // Создание объекта для запроса
    $person = new Person();
    $person->setFullName($values[0]);
    $person->setBirthdate($values[1]);
    $person->setGender($values[2]);

    if ($id = $person->insert()) {
        // Если пользователь был успешно создан, то выводится его идентификатор в БД
        echo $id . ' пользователь был успешно создан';
    } else {
        echo "Не удалось создать пользователя";
    }
    return;
}