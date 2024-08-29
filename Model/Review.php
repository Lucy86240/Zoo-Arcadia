<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/Review.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    Class Review{
        private int $id_review;
        private string $pseudo;
        private $date_visite;
        private int $note;
        private string $comment;
        private $date_check;
        private $check_by;
        private bool $isVisible;

        function getId():int{
            return $this->id_review;
        }

        function getPseudo():string{
            return $this->pseudo;
        }

        function setPseudo(string $pseudo){
            $this->pseudo = $pseudo;
        }

        function getDateVisite(){
            return $this->date_visite;
        }

        function setDateVisite($dateVisite){
            $this->date_visite = $dateVisite;
        }

        function getNote():int{
            return $this->note;
        }

        function setNote(int $note){
            $this->note = $note;
        }

        function getComment():string{
            return $this->comment;
        }

        function setComment(string $comment){
            $this->comment = $comment;
        }

        function getDateCheck(){
            return $this->date_check;
        }

        function setDateCheck($dateCheck){
            $this->date_check = $dateCheck;
        }

        function getCheckBy(){
            return $this->check_by;
        }

        function setCheckBy(string $checkBy){
            $this->check_by = $checkBy;
        }
        function getIsVisible():bool{
            return $this->isVisible;
        }

        function setIsVisible(bool $isVisible){
            $this->isVisible = $isVisible;
        }
    }
}