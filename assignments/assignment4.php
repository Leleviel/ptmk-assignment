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
        (new Person())->insertBunch($vals);
    }

    $vals=[];
    for($j = 0; $j < 100; $j++){
        $birthdate = $faker->date('Y-m-d', '2000-01-01')."\n";
        $name = 'F' . $faker->name($gender);
        array_push($vals, $name, $birthdate, 'male');
    }
    (new Person())->insertBunch($vals);
    echo 'Генерация пользователей завершена';
}