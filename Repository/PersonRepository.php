<?php

require_once 'AbstractRepository.php';
class PersonRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct('person');
    }
}