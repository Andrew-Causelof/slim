<?php

namespace Api\Models;

class Document
{
    public $id;
    public $patient_id;
    public $title;
    public $date;
    public $url;

    public function __construct($id, $patient_id, $title, $date, $url)
    {
        $this->id = $id;
        $this->patient_id = $patient_id;
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
    }
}
