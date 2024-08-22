<?php

include_once "Model/ManageUsersModel.php";

function accountsList(){
    $accountsObject= listOfUsers();
    $accounts = [];
    foreach($accountsObject as $account){
        $account = array(
            'firstName' => $account->getFirstName(),
            'lastName' => $account->getLastName(),
            'mail' => $account->getUsername(),
            'role' => $account->getRole(),
            'blocked' => $account->getBlocked()
        );
        array_push($accounts,$account);
    }
    return $accounts;
}

function deleteAccount(&$accounts){
    for($i=0; $i<count($accounts); $i++){
        $name='Delete'.$accounts[$i]['mail'];
        $name=str_replace('.','',$name);
        if(isset($_POST[$name])) deleteUser($accounts[$i]['mail']);
    }
    $accounts = accountsList();
}

function blockedAccount(&$accounts){
    for($i=0; $i<count($accounts); $i++){
        $name='Bloc-'.$accounts[$i]['mail'];
        $name=str_replace('.','',$name);

        if(isset($_POST[$name])){
            blocUser($accounts[$i]['mail']);
        }
    }
    $accounts = accountsList();
}

function unblockedAccount(&$accounts){
    $msg='';
    for($i=0; $i<count($accounts); $i++){
        $name='unblocAccount-'.$accounts[$i]['mail'];
        $name=str_replace('.','',$name);
        if(isset($_POST[$name])){
            if(isset($_POST['unblocAccountPassword']) && isset($_POST['unblocAccountConfirmPassword']) && verifiedBlocked($accounts[$i]['mail'])){
                if($_POST['unblocAccountPassword'] == $_POST['unblocAccountConfirmPassword']) unblocUser($accounts[$i]['mail'],$_POST['unblocAccountPassword']);
                else $msg = "La confirmation du mot de passe est différente.";
            }
        }
    }
    $accounts = accountsList();
    return $msg;
}

function updateAccount(&$accounts){
    $msg='';
    $firstname ='';
    $lastname ='';
    $mail='';
    $password='';
    $role='';
    //modification des utilisateurs
    for($i=0; $i<count($accounts); $i++){
        $id= str_replace('.','',$accounts[$i]['mail']);
        if(isset($_POST['updateAccount-'.$id])){
            if(isset($_POST['updateAccountFirstname-'.$id])) $firstname = $_POST['updateAccountFirstname-'.$id];
            if(isset($_POST['updateAccountLastname-'.$id])) $lastname = $_POST['updateAccountLastname-'.$id];
            if(isset($_POST['updateAccountRole-'.$id])) $role = $_POST['updateAccountRole-'.$id];  
            if(isset($_POST['updateAccountMail-'.$id]) && isset($_POST['updateAccountConfirmMail-'.$id])){
                if(!userExist($_POST['updateAccountMail-'.$id])){
                    if($_POST['updateAccountMail-'.$id] == $_POST['updateAccountConfirmMail-'.$id]) $mail = $_POST['updateAccountMail-'.$id];
                    else $msg .= "La confirmation du mail est différente.";
                }
                else{
                    $msg .= "Le mail : ".$_POST['updateAccountMail-'.$id]."est déjà utilisé";
                }
            }          
            if(isset($_POST['updateAccountPassword-'.$id]) && isset($_POST['updateAccountConfirmPassword-'.$id])){
                if($_POST['updateAccountPassword-'.$id] == $_POST['updateAccountConfirmPassword-'.$id]) $password = $_POST['updateAccountPassword-'.$id];
                else $msg .= "La confirmation du mot de passe est différente.";
            }
            $user = new User();
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setUsername($mail);
            $user->setPassword($password);

            $user->setIdrole(findIdRole($role));
            updateUser($user, $accounts[$i]['mail']);
        }
    }

    $accounts = accountsList();
    return $msg;
}

$accounts = accountsList();
deleteAccount($accounts);
blockedAccount($accounts);
unblockedAccount($accounts);
updateAccount($accounts);