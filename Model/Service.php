<?php
//namespace service;
include_once "Image.php";
class Service{
    private int $id_service;
    private string $name;
    private string $description;

    private $images=[];

    public function getId(){
        return $this->id_service;
    }

    public function getName(){
        return $this->name;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    
    public function setImage(int $indice, $img){
        $this->images[$indice]=$img;
    }

    public function getImage(int $id) : Image{
        if($id<count($this->images)){
            return $this->images[$id];
        }
        else{
            return new Image();
        }
    }

    public function addImage(Image $img){
        array_push($this->images,$img);
    }

    public function countImages(){
        return count($this->images);
    }
}