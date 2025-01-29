<?php

namespace Api\Models;

class Appointment
{
    public $id;
    public $patient_id;
    public $doctor_id;
    public $date;
    public $time;
    public $status;

    public function __construct($id, $patient_id, $doctor_id, $date, $time, $status)
    {
        $this->id = $id;
        $this->patient_id = $patient_id;
        $this->doctor_id = $doctor_id;
        $this->date = $date;
        $this->time = $time;
        $this->status = $status;
    }
}
