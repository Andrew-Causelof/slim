<?php

namespace Api\Models;

class Patient
{
    public $id;
    public $name;
    public $age;
    public $email;

    public function __construct($id, $name, $age, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
    }
}
