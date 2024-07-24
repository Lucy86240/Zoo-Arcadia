<?php

//namespace MedicalReport;
include_once "User.php";
include_once "Animal.php";
//use \PDO;

Class MedicalReport{
    private int $id_report;
    private int $animal;
    private int $veterinarian;
    private $date;
    private string $health;
    private string $food;
    private $weight_of_food;
    private string $comment;

    public function getId(){
        return $this->id_report;
    }

    public function getIdAnimal(){
        return $this->animal;
    }
    public function getAnimal(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM animals WHERE id_animal = :id');
            $stmt->bindParam(":id", $this->animal, PDO::PARAM_INT);
            $stmt->execute();
            $animal = $stmt->fetch(PDO::FETCH_ASSOC);
            return $animal;
        }
        catch(error $e)
        {
            return "inconnue";
        }
    }

    public function setIdAnimal(int $animal){
        $this->animal = $animal;
    }
    public function getIdVeterinarian(){
        return $this->veterinarian;
    }

    public function getVeterinarian(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id_user = :id');
            $stmt->bindParam(":id", $this->veterinarian, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
        catch(error $e)
        {
            return "inconnue";
        }
    }

    public function setIdVeterinarian(int $veterinarian){
        $this->veterinarian = $veterinarian;
    }

    public function getDate(){
        return $this->date;
    }
    public function setDate($date){
        $this->date = $date;
    }

    public function getHealth():string{
        return $this->health;
    }
    public function setHealth(string $health){
        $this->health = $health;
    }

    public function getFood():string{
        return $this->food;
    }
    public function setFood(string $food){
        $this->food = $food;
    }

    public function getWeightOfFood():string{
        return $this->weight_of_food;
    }
    public function setWeightOfFood(string $weight){
        $this->weight_of_food = $weight;
    }
    public function getComment():string{
        return $this->comment;
    }
    public function setComment(string $comment){
        $this->comment = $comment;
    }
}