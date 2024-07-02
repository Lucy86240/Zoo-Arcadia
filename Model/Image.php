<?php
//namespace image;
class Image{
    private int $id_image;
    private string $path;
    private string $description;
    private bool $icon;
    private bool $portrait;

    /*public function __construct(string $path, string $description, bool $icon, bool $portrait){
        $this->path = $path;
        $this->description = $description;
        $this->icon = $icon;
        $this->portrait = $portrait;
    }*/

    public function getPath() : string{
        return $this->path;
    }

    public function setPath(string $path){
        $this->path = $path;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function setIcon(bool $icon){
        $this->icon=$icon;
    }

    public function getPortrait(){
        return $this->portrait;
    }

    public function setPortrait(bool $portrait){
        $this->portrait=$portrait;
    }

}