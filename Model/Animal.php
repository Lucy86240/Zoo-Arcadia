<?php

//namespace animal;
include_once "Image.php";
//use \PDO;

Class Animal{
    private int $id_animal;
    private string $name;
    private int $breed;
    private int $housing;
    private string $health;
    private bool $isVisible;

    private $images=[];

    public function getId(){
        return $this->id_animal;
    }

    public function getName(){
        return $this->name;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getIdBreed(){
        return $this->breed;
    }

    public function getBreed(){
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo','root','');
            $stmt = $pdo->prepare('SELECT label FROM breeds WHERE id_breed = :id');
            $stmt->bindParam(":id", $this->breed, PDO::PARAM_INT);
            $stmt->execute();
            $breed = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $breed;
        }
        catch(error $e)
        {
            return "inconnue";
        }
    }

    public function setIdBreed(int $breed){
        $this->breed = $breed;
    }

    public function getIdHousing(){
        return $this->housing;
    }

    public function setIdHousing(int $housing){
        $this->housing = $housing;
    }

    public function getHealth(){
        return $this->health;
    }

    public function setHealth(int $health){
        $this->health = $health;
    }

    public function getIsVisible(){
        return $this->isVisible;
    }

    public function setIsVisible(int $isVisible){
        $this->isVisible = $isVisible;
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