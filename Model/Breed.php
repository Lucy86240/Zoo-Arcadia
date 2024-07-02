<?php

namespace breed;

class Breed{
    private int $id_breed;
    private string $label;

    public function __construct(string $label){
        $this->label = $label;
    }

    public function getId(){
        return $this->id_breed;
    }

    public function getLabel(){
        return $this->label;
    } 

    public function setLabel(string $label){
        $this->label = $label;
    }

}