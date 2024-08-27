<?php
if($_SERVER['REQUEST_URI']!='/Controller/ManageContact.php'){
    if(isset($_POST['submitMsg'])){
        $company = '';
        $firstName = '';
        $lastName = '';
        $tel = '';
        $mail = '';
        $object = '';
        $msg = '';
        $goodForSend = true;

        if(isset($_POST['company'])) $company = $_POST['company'];
        if(isset($_POST['tel'])) $tel = $_POST['tel'];

        if(isset($_POST['firstName'])) $firstName = $_POST['firstName'];
        else $goodForSend = false;

        if(isset($_POST['lastName'])) $lastName = $_POST['lastName'];
        else $goodForSend = false;

        if(isset($_POST['mail']) && $_POST['mail']!='' && preg_match_all("/^[a-zA-Z0-9_.±]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/",$_POST['mail'])==1) $mail = $_POST['mail'];
        else $goodForSend = false;

        if(isset($_POST['object'])) $obj = $_POST['object'];
        else $goodForSend = false;

        if(isset($_POST['msg'])) $msg = $_POST['msg'];
        else $goodForSend = false;
                    
        if($goodForSend){
            //$recipient = MAIL_CONTACT;
            $recipient = "lulucastagnette.16@hotmail.fr";
            $object = "Nouveau message : ".$obj;
            $message = "Vous avez un nouveau message :"."<br>";
            $message .= "Emetteur : ".$firstName.' '.$lastName."<br>";
            if($company != '') $message.= "Entreprise : ".$company."<br>";
            $message .= "Mail : ".$mail."<br>";
            $message .= "Téléphone : ".$tel."<br>";
            $message .= "Objet : ".$obj."<br>";
            $message .= "Message : ".$msg."<br>";
            $headers="MIME-version: 1.0\r\n".'Date: '.date("r")."\r\n";
            $headers .= "From:".$firstName." ".$lastName." <".$mail.">" . "\r\n"."Reply-To: ".$firstName." ".$lastName." <".$mail."> \r\n";
            $headers .= "Content-type: text/html; charset=utf-8" . "\r\n"; 
            if(mail($recipient,$object,$message,$headers)) $msg=true;
            else $msg=false;
        }
        else
            $msg = false;
    }
}
else{
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
