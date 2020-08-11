<?php
require_once 'Person.php';
require_once 'Db.php';
abstract class ORM
{

    public function insert(){
        if(!$this->isTableExists()){
            echo 'Таблица '.$this->getTableName().' не найдена';
            return;
        }
        $blocked = ['id'];
        // Получение переменных класса и фильтрование таким образом, что бы не осталось id
        $class_vars = array_filter(get_object_vars($this), function ($key) use ($blocked){
            return !in_array($key, $blocked);
        },ARRAY_FILTER_USE_KEY);
        $class_var_values = array_values($class_vars);
        $class_var_keys =  array_keys($class_vars);

        // Подготовка запроса
        $var_count = count($class_vars);
        $columns =  '('.join(', ', $class_var_keys).')';
        $prepare_values =  '('.join(', ', array_fill(0,$var_count,'?')).')';
        $query = "INSERT INTO ".$this->getTableName().$columns.' VALUES '.$prepare_values;
        var_dump($query);

        // Запрос
        $instance = Db::getInstance();
        $stmt = $instance->prepare($query);
        $stmt->execute($class_var_values);

        return $instance->lastInsertId();
    }
    public function insertBunch($list){
        $blocked = ['id'];
        // Получение переменных класса и фильтрование таким образом, что бы не осталось id
        $class_vars = array_filter(get_object_vars($this), function ($key) use ($blocked){
            return !in_array($key, $blocked);
        },ARRAY_FILTER_USE_KEY);
        $class_var_values = array_values($class_vars);
        $class_var_keys =  array_keys($class_vars);

        // Подготовка запроса
        $var_count = count($class_vars);
        $columns =  ' ('.join(', ', $class_var_keys).')';
        $prepare_values =  str_repeat('('.join(', ', array_fill(0,$var_count,'?')).'), ',
            count($list)/$var_count-1);
        $prepare_values.='('.join(', ', array_fill(0,$var_count,'?')).')';
        $query = "INSERT INTO ".$this->getTableName().$columns.' VALUES '.$prepare_values;
//        var_dump($columns);
        // Выполнение запроса
        // Может быть нужно будет добавить выход из цикла в случае ошибки, т.к. в противном случае все равно будет
        // продолжаться попытка создания пользователей.
        // Но, с другой стороны, кратковременная неполадка тогда прервет другие создания пользователей
        $stmt = Db::getInstance()->prepare($query);
        $stmt->execute($list);

    }
    abstract public function getTableName();
    /**
     * Иссер, проверяющий, существует ли таблица с заданным имененм
     * @return bool
     */
    public function isTableExists(){
        try {
            $result = Db::getInstance()->query("SELECT 1 FROM ".$this->getTableName()." LIMIT 1");
        } catch (Exception $e) {
            // ошибка — таблица не найдена
            return FALSE;
        }
        // Резульатат или false (таблица не найдена) или PDOStatement Object (table найдена)
        return $result !== FALSE;
    }
}