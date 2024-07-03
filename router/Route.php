<?php

Class Route {
    private string $url;
    private bool $option;
    private string $title;
    private string $pathHtml;
    private array $authorize;
    private string $pathController;

    function __construct($url, $option, $title, $pathHtml, $authorize, $pathController) {
        $this->url = $url;
        $this->option = $option;
        $this->title = $title;
        $this->pathHtml = $pathHtml;
        $this->pathController = $pathController;
        $this->authorize = $authorize;
    }

    function getURL(){
        return $this->url;
    }

    function getOption(){
        return $this->option;
    }

    function getPathHtml(){
        return $this->pathHtml;
    }

    function getAuthorize(){
        return $this->authorize;
    }

    function getPathController(){
        return $this->pathController;
    }
}