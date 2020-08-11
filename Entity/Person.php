<?php

require_once 'ORM.php';
class Person extends ORM
{
    protected $id;
    protected $full_name;
    protected $birthdate;
    protected $gender;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getTableName()
    {
        return 'person';
    }

    public function createTable(){
        Db::getInstance()->query("CREATE TABLE IF NOT EXISTS person(id INT AUTO_INCREMENT, full_name varchar(255) not null, gender varchar(10), birthdate DATE, PRIMARY KEY(id)) ENGINE=InnoDB");
    }

    public function getAge(){
        try {
            $dt1 = new DateTime($this->birthdate);
            return $dt2 = (new DateTime('now'))->diff($dt1)->y;
        } catch (Exception $e) {
        }

    }


}