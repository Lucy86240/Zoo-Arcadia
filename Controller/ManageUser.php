<?php

include_once "Model/ManageUserModel.php";

function verifiedLogin(){
    if(isset($_POST['login'])){
        if(isset($_POST['user']) && isset($_POST['password'])){
            if(verifiedLoginInput($_POST['user'], $_POST['password'])){
                $_SESSION['passwordError']=false;
                return true;
            }
            else{
                $_POST['login']=null;
                $_SESSION['passwordError']=true;
                return false;
            }
        }
    }
}

function passwordError(){
    if (isset($_POST['close-login'])){
        $_SESSION['passwordError']=false;
        $_SESSION['openLogin']=false;
        $_POST['close-login']=null;
    }
    if(isset($_SESSION['passwordError'])) return $_SESSION['passwordError'];
    else return false;
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