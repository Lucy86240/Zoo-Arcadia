<?php
if($_SERVER['REQUEST_URI']=='/Model/Breed.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
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
}