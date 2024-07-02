<?php
namespace role;
class Role{
    private int $id_role;
    private string $label;

    public function  __construct(string $label){
        $this->label = $label;
    }

    public function getLabel(){
        return $this->label;
    }

    public function setLabel(string $label){
        $this->label = $label;
    }
}