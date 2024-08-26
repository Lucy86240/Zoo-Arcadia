<?php

include_once "Model/ManageUserModel.php";

/**
 * Summary of verifiedLogin : indique si l'identifiant et mot de passe saisis correspondent
 * @return bool 
 */
function verifiedLogin(){
    if(isset($_POST['login'])){
        if(verifiedBlocked($_POST['user'])){
            $_POST['login']=null;
            $_SESSION['passwordError']=true;
        }
        else if(isset($_POST['user']) && isset($_POST['password'])){
            if(verifiedLoginInput($_POST['user'], $_POST['password'])){
                $_SESSION['passwordError']=false;
                if(isset($_SESSION['nbError'][$_POST['user']])) $_SESSION['nbError'][$_POST['user']]=0;
                return true;
            }
            else{
                $_POST['login']=null;
                $_SESSION['passwordError']=true;
                if(!isset($_SESSION['nbError'][$_POST['user']])) $_SESSION['nbError'][$_POST['user']]=1;
                else $_SESSION['nbError'][$_POST['user']]++;
                if($_SESSION['nbError'][$_POST['user']]>2) blocUser($_POST['user']);
                return false;
            }
        }
    }
    return false;
}
/**
 * Summary of passwordError : return true si l'utilisateur a fait un mauvais mot de passe
 * @return bool 
 */
function passwordError(){
    if (isset($_POST['close-login'])){
        $_SESSION['passwordError']=false;
        $_SESSION['openLogin']=false;
        $_POST['close-login']=null;
        $_SESSION['blocked']=0;
    }
    if(isset($_SESSION['passwordError'])) return $_SESSION['passwordError'];
    else return false;
}

/**
 * Summary of logout : déconnecte l'utilisateur
 * @return void
 */
function logout(){
    if(isset($_POST['logout'])){
        $_SESSION['mail']='';
        $_SESSION['role']='';
        $_SESSION['firstName']='';
        $_SESSION['lastName']='';
    }
}

/**affiche 'none' si le role de l'utilisateur est différent de ceux passés en paramètres
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

function authorize($roles){
    if($roles==[]) return true;
    if($roles[0]=='disconnect'){
        if(isConnected()) return false;
        else return true;
    }
    else{
        if($roles[0]=='connected'){
            if((!isset($_SESSION['role']) || $_SESSION['role']=="")) return false;
            else return true;
        }
        else{
            if((isset($_SESSION['role']) && in_array($_SESSION['role'],$roles,true))) return true;
            else return false;
        } 
    }
}

/**
 * Summary of isConnected : indique si l'utilisateur est connecté
 * @return bool
 */
function isConnected():bool{
    if((isset($_SESSION['role']) && $_SESSION['role']!='')) return true;
    else return false;
}

verifiedLogin();
logout();