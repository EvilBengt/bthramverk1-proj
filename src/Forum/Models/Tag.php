<?php

namespace EVB\Forum\Models;

class Tag
{
    private $id;
    private $name;


    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }
}
