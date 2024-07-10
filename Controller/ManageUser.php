<?php

if($optionPage){
    include_once "../Model/ManageUserModel.php";
}
else{
    include_once "Model/ManageUserModel.php";
}

function verifiedLogin(){
    if(isset($_POST['login'])){
        if(isset($_POST['user']) && isset($_POST['password'])){
            verifiedLoginInput($_POST['user'], $_POST['password']);
        }
    }
}

verifiedLogin();