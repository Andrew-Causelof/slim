<?php

namespace Api\Models;

class Doctor
{
    public $id;
    public $name;
    public $specialization;
    public $email;

    public function __construct($id, $name, $specialization, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialization = $specialization;
        $this->email = $email;
    }
}
