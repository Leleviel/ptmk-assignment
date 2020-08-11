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
    // строка, содержащаяя запроса
    $query = "INSERT INTO person (full_name, birthdate, sex) VALUES (?, ? , ?)";
    // Получение соединения с БД и выполнение запроса
    $instance = Db::getInstance();
    $stmt = $instance->prepare($query);
    if ($stmt->execute($values)) {
        // Если пользователь был успешно создан, то выводится его идентификатор в БД
        echo $instance->lastInsertId() . ' пользователь был успешно создан';
    } else {
        echo "Не удалось создать пользователя";
    }
    return;
}