<?php
//on execute le programme seulement si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageContact.php'){
    // si on soumet le formulaire
    if(isset($_POST['submitMsg'])){

        //initialisation des variables
        $company = '';
        $firstName = '';
        $lastName = '';
        $tel = '';
        $mail = '';
        $object = '';

        //message si le mail est envoyé
        $msg = null;

        //on initialise une variable permettant de savoir si une étape n'est pas respectée
        $goodForSend = true;

        //on récupère la structure
        if(isset($_POST['company']) && preg_match_all("/^([a-zA-Z0-9èéëïç&\- ])+$/",$_POST['company'])) $company = $_POST['company'];
        if(isset($_POST['tel'])) $tel = $_POST['tel'];

        //on récupère le prénom
        if(isset($_POST['firstName']) && isName($_POST['firstName'])) $firstName = $_POST['firstName'];
        else $goodForSend = false;

        //on récupère le nom
        if(isset($_POST['lastName']) && isName($_POST['lastName'])) $lastName = $_POST['lastName'];
        else $goodForSend = false;

        //on récupère le mail
        if(isset($_POST['mail']) && $_POST['mail']!='' && isMail($_POST['mail'])) $mail = $_POST['mail'];
        else $goodForSend = false;

        //on récupère l'objet
        if(isset($_POST['object']) && isText($_POST['object'])) $obj = $_POST['object'];
        else $goodForSend = false;

        //on récupère le message
        if(isset($_POST['msg']) && isText($_POST['msg'])) $msg = $_POST['msg'];
        else $goodForSend = false;
        
        //si on a pu tout récupéré on envoi le mail à Arcadia
        if($goodForSend){
            //destinaire présent dans les constantes
            $recipient = MAIL_CONTACT;
            
            $object = "Nouveau message : ".$obj;
            $message = "Vous avez un nouveau message :"."<br>";
            $message .= "Emetteur : ".$firstName.' '.$lastName."<br>";
            if($company != '') $message.= "Entreprise : ".$company."<br>";
            $message .= "Mail : ".$mail."<br>";
            $message .= "Téléphone : ".$tel."<br>";
            $message .= "Objet : ".$obj."<br>";
            $message .= "Message : ".$msg."<br>";
            $headers= "MIME-version: 1.0\r\n".'Date: '.date("r")."\r\n";
            
            //émetteur du mail le visiteur permettant ainsi à Arcadia de faire directement répondre
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
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
