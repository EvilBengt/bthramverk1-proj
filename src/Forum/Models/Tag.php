<?php

namespace EVB\Forum\Models;

class Tag
{
    private $id;
    private $name;
    private $frequency;


    public function __construct($id, $name, $frequency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->frequency = $frequency;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getFrequency() : string
    {
        return $this->frequency;
    }
}
