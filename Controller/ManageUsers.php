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

$accounts = accountsList();