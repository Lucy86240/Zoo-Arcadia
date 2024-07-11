<?php

include_once "Model/ManageUserModel.php";

function verifiedLogin(){
    if(isset($_POST['login'])){
        if(isset($_POST['user']) && isset($_POST['password'])){
            verifiedLoginInput($_POST['user'], $_POST['password']);
        }
    }
}

function logout(){
    if(isset($_POST['logout'])){
        $_SESSION['mail']='';
        $_SESSION['role']='';
        $_SESSION['firstName']='';
    }
}

/**Cette fonction ecrit 'none' si le role de l'utilisateur est différent de ceux passés en paramètres
 * $permissions est un tableau (possibilités : 'connected', 'Administrateur.rice', 'Vétérinaire', 'Employé.e','disconnect')
 */
function permission($permissions){
    if($permissions[0]=='disconnect'){
        if(isConnected()) echo('none');
    }
    else{
        if($permissions[0]=='connected'){
            if((!isset($_SESSION['role']) || $_SESSION['role']=='')) echo('none');
        }
        else{
            if((isset($_SESSION['role']) && !in_array($_SESSION['role'],$permissions,true)) || !isset($_SESSION['role'])) echo('none');
        } 
    }

}

function isConnected():bool{
    if((isset($_SESSION['role']) && $_SESSION['role']!='')) return true;
    else return false;
}

verifiedLogin();
logout();