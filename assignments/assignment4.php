<?php
/**
 * Заполнение автоматически 1000000 строк.
 * Распределение пола в них должно быть относительно равномерным, начальной буквы ФИО также.
 * Заполнение автоматически  100 строк в которых пол мужской и ФИО начинается с "F".
 * Пример запуска приложения:
 * myApp 4
 */
function assignment4(){
    // количество объектов в каждом запроса
    $batch_size = 1000;
    // Для создание случайных значений была использована библиотека Faker, что бы результат имел хотя бы какой-то
    // читаемые вид
    $faker = Faker\Factory::create();
    // массив, содержащий возможный пол пользователя (может быть нужно будет добавить other)
    $genders = ['male','female'];
    // Строка запроса
    $query = "INSERT INTO person (full_name, birthdate, sex) VALUES ";
    // Построение запроса с вставкой 1000 значений
    $query .= str_repeat("(?,?,?),", $batch_size-1);
    $query .= "(?,?,?)";
    // Подготовка запроса
    $instance = Db::getInstance();
    $stmt = $instance->prepare($query);
    for ($i = 0; $i < (1000000/$batch_size); $i++) {
        $vals = array();
        // генерация значений
        for ($j = 0; $j < $batch_size; $j++) {
            $birthdate = $faker->date('Y-m-d', '2000-01-01')."\n";
            $gender = $genders[array_rand($genders)];
            // Первая буква генерируется случайно,
            // т.к. случайная генерация имен не гарантирует равномерное распределение
            $name = chr(rand(65,90)) . $faker->name($gender);
            array_push($vals, $name, $birthdate, $gender);
        }
        // Выполнение запроса
        // Может быть нужно будет добавить выход из цикла в случае ошибки, т.к. в противном случае все равно будет
        // продолжаться попытка создания пользователей.
        // Но, с другой стороны, кратковременная неполадка тогда прервет другие создания пользователей
        $stmt->execute($vals);
    }

    // Генерация выборки из 100 необходимых пользователей
    $query = "INSERT INTO person (full_name, birthdate, sex) VALUES ";
    $query .= str_repeat("(?,?,?),", 99);
    $query .= "(?,?,?)";
    $stmt = $instance->prepare($query);
    $vals = array();
    $gender = 'male';
    for($j = 0; $j < 100; $j++){
        $birthdate = $faker->date('Y-m-d', '2000-01-01')."\n";
        $name = 'F' . $faker->name($gender);
        array_push($vals, $name, $birthdate, 'male');
    }
    $stmt->execute($vals);
    echo 'Генерация пользователей завершена';
}