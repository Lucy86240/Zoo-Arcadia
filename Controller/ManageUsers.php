<?php
//execution du programme seulement si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageUsers.php'){
    try{
        require_once "Model/ManageUsersModel.php";

        /**
         * Summary of accountsList : liste des utilisateurs 
         * @return array tableau associatif(firstName,lastName,mail,blocked)
         */
        function accountsList(){
            //récupères les objets user de la base de données
            $accountsObject= listOfUsers();
            //on crée le tableau associatif
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
    
        /**
         * Summary of deleteAccount permet la suppression d'un compte (nécessite un popup de validation)
         * @param mixed $accounts : liste des utilisateurs à mette à jour
         * @return void
         */
        function deleteAccount(&$accounts){
            for($i=0; $i<count($accounts); $i++){
                //on initialise le nom du bouton submit
                $name='Delete'.$accounts[$i]['mail'];
                $name=str_replace('.','',$name);
                //on vérifie s'il a été cliqué
                if(isset($_POST[$name])) deleteUser($accounts[$i]['mail']);
            }
            //on met à jour la liste des utilisateurs
            $accounts = accountsList();
        }
    
        /**
         * Summary of blockedAccount permet de bloquer un compte (nécessite un popup de validation)
         * @param mixed $accounts : liste des utilisateurs à mette à jour
         * @return void
         */
        function blockedAccount(&$accounts){
            for($i=0; $i<count($accounts); $i++){
                //initialisation du nom du bouton
                $name='Bloc-'.$accounts[$i]['mail'];
                $name=str_replace('.','',$name);
                //vérification s'il a été cliqué
                if(isset($_POST[$name])){
                    blocUser($accounts[$i]['mail']);
                }
            }
            //mise à jour de la liste
            $accounts = accountsList();
        }
    
        /**
         * Summary of unblockedAccount: permet de débloquer un compte
         * @param mixed $accounts : liste des utilisateurs à mette à jour
         * @return string : message d'erreur ou de succès
         */
        function unblockedAccount(&$accounts){
            $msg='';
            for($i=0; $i<count($accounts); $i++){
                //initialisation du nom du bouton
                $name='unblocAccount-'.$accounts[$i]['mail'];
                $name=str_replace('.','',$name);
                //si on a cliqué dessus
                if(isset($_POST[$name])){
                    //mise à jour de la base de données si les mots de passe sont saisis et identiques
                    if(isset($_POST['unblocAccountPassword']) && isset($_POST['unblocAccountConfirmPassword']) && verifiedBlocked($accounts[$i]['mail'])){
                        if($_POST['unblocAccountPassword'] == $_POST['unblocAccountConfirmPassword']) unblocUser($accounts[$i]['mail'],$_POST['unblocAccountPassword']);
                        else $msg = "La confirmation du mot de passe est différente.";
                    }
                }
            }
            //mise à jour de la liste
            $accounts = accountsList();
            return $msg;
        }
    
        /**
         * Summary of updateAccount : permet la modification des utilisateurs (nécessite un formulaire)
         * @param mixed $accounts : liste des utilisateurs à mette à jour 
         * @return string : message en cas d'erreur
         */
        function updateAccount(&$accounts){
            //initialise les variables
            $msg='';
            $firstname ='';
            $lastname ='';
            $mail='';
            $password='';
            $role='';
            //on vérifie pour tous les utilisateurs
            for($i=0; $i<count($accounts); $i++){
                //initialise le nom du bouton submit
                $id= str_replace('.','',$accounts[$i]['mail']);
                //si le bouton est cliqué
                if(isset($_POST['updateAccount-'.$id])){
                    //on récupère le prénom
                    if(isset($_POST['updateAccountFirstname-'.$id]) && isName($_POST['updateAccountFirstname-'.$id])) $firstname = $_POST['updateAccountFirstname-'.$id];
                    //on récupère le nom
                    if(isset($_POST['updateAccountLastname-'.$id]) && isName($_POST['updateAccountLastname-'.$id])) $lastname = $_POST['updateAccountLastname-'.$id];
                    //on récupère le role
                    if(isset($_POST['updateAccountRole-'.$id]) && isName($_POST['updateAccountRole-'.$id])) $role = $_POST['updateAccountRole-'.$id];  
                    // on récupère le mail 
                    if(isset($_POST['updateAccountMail-'.$id]) && isMail($_POST['updateAccountMail-'.$id])
                    && isset($_POST['updateAccountConfirmMail-'.$id]) && isMail($_POST['updateAccountConfirmMail-'.$id]) ){
                        //on vérifie que le mail n'est pas déjà utilisé
                        if(!userExist($_POST['updateAccountMail-'.$id])){
                            //on vérifie que le mail et sa confirmation sont identiques
                            if($_POST['updateAccountMail-'.$id] == $_POST['updateAccountConfirmMail-'.$id]) $mail = $_POST['updateAccountMail-'.$id];
                            else $msg .= "La confirmation du mail est différente.";
                        }
                        else{
                            $msg .= "Le mail : ".$_POST['updateAccountMail-'.$id]."est déjà utilisé";
                        }
                    }
                    //on récupère le mot de passe          
                    if(isset($_POST['updateAccountPassword-'.$id]) && isset($_POST['updateAccountConfirmPassword-'.$id])){
                        //on vérifie que le mot de passe et sa confirmation sont identiques
                        if($_POST['updateAccountPassword-'.$id] == $_POST['updateAccountConfirmPassword-'.$id]) $password = $_POST['updateAccountPassword-'.$id];
                        else $msg .= "La confirmation du mot de passe est différente.";
                    }
                    //on crée un objet user avec toutes les infos récupérées
                    $user = new User();
                    $user->setFirstName($firstname);
                    $user->setLastName($lastname);
                    $user->setUsername($mail);
                    $user->setPassword($password);
    
                    $user->setIdrole(findIdRole($role));
                    //on met à jour la base de données
                    updateUser($user, $accounts[$i]['mail']);
                }
            }
    
            //mise à jour de la liste
            $accounts = accountsList();
            return $msg;
        }
    
        /**
         * Summary of newAccount permet la création d'un nouvel utilisateur (nécessite un formulaire)
         * @param mixed $accounts : liste des utilisateurs à mette à jour 
         * @return string
         */
        function newAccount(&$accounts){
            //initialisation des variables
            $firstname ='';
            $lastname ='';
            $mail='';
            $password='';
            $role='';
            $msg='';
            //si on a cliqué sur ajout d'un utilisateur
            if(isset($_POST['createAccount'])){
                //on vérifie que le mail a été saisi  
                if(isset($_POST['newAccountMail']) && isMail($_POST['newAccountMail'])){
                    //on vérifie que le mail n'est pas déjà utilisé
                    if(!userExist($_POST['newAccountMail'])){
                        //on vérifie que le mot de passe est saisi
                        if(isset($_POST['newAccountPassword']) && isset($_POST['newAccountConfirmPassword'])){
                            //on récupère les MDP si la confirmation est identique
                            if($_POST['newAccountPassword'] == $_POST['newAccountConfirmPassword']) $password = $_POST['newAccountPassword'];
                            else $msg .= "La confirmation du mot de passe est différente.";
                        }
                        //on récupère le prénom
                        if(isset($_POST['newAccountFirstname']) && isName($_POST['newAccountFirstname'])) $firstname = $_POST['newAccountFirstname'];
                        //on récupère le nom
                        if(isset($_POST['newAccountLastname']) && isName($_POST['newAccountLastname'])) $lastname = $_POST['newAccountLastname'];
                        //on récupère le role
                        if(isset($_POST['newAccountRole']) && isName($_POST['newAccountRole'])) $role = $_POST['newAccountRole'];
                        //on récupère le mail si la confirmation est identique
                        if($_POST['newAccountMail'] == $_POST['newAccountConfirmMail']) $mail = $_POST['newAccountMail'];
                        else $msg .= "La confirmation du mail est différente.";
                        
                        //on met à jour la base de données si on a tout récupéré
                        if($firstname !='' && $lastname!='' && $mail!='' && $password!='' && $role!=''){
                            $user = new User();
                            $user->setFirstName($firstname);
                            $user->setLastName($lastname);
                            $user->setUsername($mail);
                            $user->setPassword($password);
                            $user->setIdrole(findIdRole($role));
                            $create = newUser($user);
                            //si on a bien crée l'utilisateur on lui envoi un mail de bienvenue
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
            //mise à jour de la base de données
            $accounts = accountsList();
            return $msg;
        }
    
        //initialisation de la liste
        $accounts = accountsList();
        //on permet de la mettre à jour en effectuant un CUD
        deleteAccount($accounts);
        blockedAccount($accounts);
        unblockedAccount($accounts);
        updateAccount($accounts);
        newAccount($accounts);        
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}
else{
    //on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}