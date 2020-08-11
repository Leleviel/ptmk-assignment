<?php

require_once 'Db.php';
require_once 'Entity/Person.php';
abstract class AbstractRepository
{
    private $table_name;
    private $entity;
    private $class_name;
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->class_name = substr(get_called_class(),0,strpos(get_called_class(),'Repository'));
        require_once "Entity\\$this->class_name.php";

    }


    public function findById($id){
        $instance = Db::getInstance();
        $query = "SELECT * FROM ".$this->table_name. " WHERE `id`=? LIMIT 0,1";
        $stmt = $instance->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetchObject($this->class_name);
    }

    public function findAll($group_by=[]){
        $instance = Db::getInstance();
        $query = "SELECT * FROM ".$this->table_name;
        if(!empty($group_by)){
            $query.=" GROUP BY ".join(', ',$group_by);
        }
        $stmt = $instance->query($query);
        $list = [];
        while($obj = $stmt->fetchObject($this->class_name)){
            array_push($list,$obj);
        }
        return $list;
    }
}
