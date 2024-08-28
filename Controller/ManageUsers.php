<?php

if($_SERVER['REQUEST_URI']!='/Controller/ManageUsers.php'){

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
                if(isset($_POST['updateAccountFirstname-'.$id]) && isName($_POST['updateAccountFirstname-'.$id])) $firstname = $_POST['updateAccountFirstname-'.$id];
                if(isset($_POST['updateAccountLastname-'.$id]) && isName($_POST['updateAccountLastname-'.$id])) $lastname = $_POST['updateAccountLastname-'.$id];
                if(isset($_POST['updateAccountRole-'.$id]) && isName($_POST['updateAccountRole-'.$id])) $role = $_POST['updateAccountRole-'.$id];  
                if(isset($_POST['updateAccountMail-'.$id]) && isMail($_POST['updateAccountMail-'.$id])
                && isset($_POST['updateAccountConfirmMail-'.$id]) && isMail($_POST['updateAccountConfirmMail-'.$id]) ){
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

    function newAccount(&$accounts){
        $firstname ='';
        $lastname ='';
        $mail='';
        $password='';
        $role='';
        $msg='';
        if(isset($_POST['createAccount'])){  
            if(isset($_POST['newAccountMail']) && isset($_POST['newAccountConfirmMail'])){
                if(!userExist($_POST['newAccountMail'])){
                    if(isset($_POST['newAccountPassword']) && isset($_POST['newAccountConfirmPassword'])){
                        if($_POST['newAccountPassword'] == $_POST['newAccountConfirmPassword']) $password = $_POST['newAccountPassword'];
                        else $msg .= "La confirmation du mot de passe est différente.";
                    }
                    if(isset($_POST['newAccountFirstname']) && isName($_POST['newAccountFirstname'])) $firstname = $_POST['newAccountFirstname'];
                    if(isset($_POST['newAccountLastname']) && isName($_POST['newAccountLastname'])) $lastname = $_POST['newAccountLastname'];
                    if(isset($_POST['newAccountRole']) && isName($_POST['newAccountRole'])) $role = $_POST['newAccountRole'];
                    if($_POST['newAccountMail'] == $_POST['newAccountConfirmMail'] && isMail($_POST['newAccountMail'])) $mail = $_POST['newAccountMail'];
                    else $msg .= "La confirmation du mail est différente.";
                    
                    if($firstname !='' && $lastname!='' && $mail!='' && $password!='' && $role!=''){
                        $user = new User();
                        $user->setFirstName($firstname);
                        $user->setLastName($lastname);
                        $user->setUsername($mail);
                        $user->setPassword($password);
                        $user->setIdrole(findIdRole($role));
                        $create = newUser($user);
                        if($create){
                            $recipient = $user->getUsername();
                            $object = "Bienvenue à votre espace Arcadia";
                            $message = "Bonjour ".$user->getFirstName().","."<br> <br>"."Votre espace sur ".SITE_URL." vient d'être crée."."<br>"."Merci de bien vouloir vous approcher de votre administrateur pour récupérer votre mot de passe."."<br> <br>"."L'équipe Arcadia";
                            $headers="MIME-version: 1.0\r\n".'Date: '.date('r')."\r\n";
                            $headers .= 'From: Arcadia <'.MAIL_CONTACT.'>' . "\r\n"."Reply-To: Arcadia <'.MAIL_CONTACT.'> \r\n";
                            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
                            mail($recipient,$object,$message,$headers);
                        }
                    }
                }
                else{
                    $msg .= "Le mail : ".$_POST['newAccountMail']."est déjà utilisé";
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
    updateAccount($accounts);
    newAccount($accounts);
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}