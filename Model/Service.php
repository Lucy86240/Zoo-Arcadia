<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/Service.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    //namespace service;
    require_once "Image.php";
    class Service{
        private int $id_service;
        private string $name;
        private string $description;

        private Image $photo;

        private Image $icon;

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

        
        public function setPhoto($img){
            $this->photo=$img;
        }

        public function getPhoto() : Image{
            return $this->photo;
        }

        public function setIcon($img){
            $this->icon=$img;
        }

        public function getIcon() : Image{
            return $this->icon;
        }


    }
}