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

$accounts = accountsList();
deleteAccount($accounts);
blockedAccount($accounts);
unblockedAccount($accounts);