<?php

class CommentHousing{
    private int $id_comment;
    private string $veterinarian;
    private int $housing;
    private string $comment;
    private $date;
    private bool $archive;

    public function getId(){
        return $this->id_comment;
    }
    public function getVeterinarian():string{
        return $this->veterinarian;
    }
    public function setVeterinarian(string $mail){
        $this->veterinarian = $mail;
    }
    public function getHousing():int{
        return $this->housing;
    }
    public function setHousing(int $housing){
        $this->housing = $housing;
    }
    public function getComment():string{
        return $this->comment;
    }
    public function setComment(string $comment){
        $this->comment = $comment;
    }
    public function getDate(){
        return $this->date;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function getArchive():bool{
        return $this->archive;
    }
    public function setArchive(bool $archive){
        $this->archive = $archive;
    }
}