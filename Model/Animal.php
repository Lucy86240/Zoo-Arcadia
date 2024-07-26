<?php

//namespace animal;
include_once "Image.php";
//use \PDO;

Class Animal{
    private int $id_animal;
    private string $name;
    private int $breed;
    private int $housing;
    private bool $isVisible;

    private $images=[];

    private $medicalReports=[];

    public function getId(){
        return $this->id_animal;
    }
    public function setId(int $id){
        $this->id_animal = $id;
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
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT label FROM breeds WHERE id_breed = :id');
            $stmt->bindParam(":id", $this->breed, PDO::PARAM_INT);
            $stmt->execute();
            $breed = $stmt->fetch(PDO::FETCH_ASSOC);
            return $breed['label'];
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

    public function getHousing(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT name FROM housings WHERE id_housing = :id');
            $stmt->bindParam(":id", $this->housing, PDO::PARAM_INT);
            $stmt->execute();
            $breed = $stmt->fetch(PDO::FETCH_ASSOC);
            return $breed['name'];
        }
        catch(error $e)
        {
            return "inconnue";
        }
    }

    public function setIdHousing(int $housing){
        $this->housing = $housing;
    }

    public function getIsVisible(){
        return $this->isVisible;
    }

    public function setIsVisible(int $isVisible){
        $this->isVisible = $isVisible;
    }

    public function setMedicalReport(int $indice, $report){
        $this->medicalReports[$indice]=$report;
    }

    public function getMedicalReport(int $id){
        if($id<count($this->medicalReports)){
            return $this->medicalReports[$id];
        }
        else{
            return new MedicalReport();
        }
    }
    public function getLastMedicalReport(){
        if ($this->countMedicalReports() <1) return null;
        return $this->medicalReports[0];
    }
    public function addMedicalReport($report){
        array_push($this->medicalReports,$report);
    }

    public function countMedicalReports(){
        return count($this->medicalReports);
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