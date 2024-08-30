<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Controller/ManageUser.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    try{
        require_once "Model/ManageUserModel.php";

        /**
         * Summary of verifiedLogin : indique si l'identifiant et mot de passe saisis sont liés (nécessite un formulaire)
         * @return bool 
         */
        function verifiedLogin(){
            //si on soumet le formulaire
            if(isset($_POST['login'])){
                //on vérifie d'abord si l'utilisateur est bloqué
                if(verifiedBlocked($_POST['user'])){
                    $_POST['login']=null;
                    $_SESSION['passwordError']=true;
                }
                // sinon on vérifie si des données ont été saisies
                else if(isset($_POST['user']) && isset($_POST['password'])){
                    //on consulte la base de données, si c'est ok
                    if(verifiedLoginInput($_POST['user'], $_POST['password'])){
                        //onr réinitialise les $_SESSION en lien avec les erreurs
                        $_SESSION['passwordError']=false;
                        if(isset($_SESSION['nbError'][$_POST['user']])) $_SESSION['nbError'][$_POST['user']]=0;
                        return true;
                    }
                    //si le mot de passe est fait
                    else{
                        $_POST['login']=null;
                        // on enregistre que l'utilisateur a saisi un mot de passe faut
                        $_SESSION['passwordError']=true;
                        //on crédite le nombre de mauvais de mot de passe saisi par l'utilisateur pour le login
                        if(!isset($_SESSION['nbError'][$_POST['user']])) $_SESSION['nbError'][$_POST['user']]=1;
                        else $_SESSION['nbError'][$_POST['user']]++;
                        //on bloc l'accès en cas de 3 mauvais mot de passe pour le login
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
            //si on ferme le popup on réinitialise les variables de sessions
            if (isset($_POST['close-login'])){
                $_SESSION['passwordError']=false;
                $_SESSION['openLogin']=false;
                $_POST['close-login']=null;
                $_SESSION['blocked']=0;
            }
            //retourne la variable de session ayant enregistré si un mauvais de passe est saisi
            if(isset($_SESSION['passwordError'])) return $_SESSION['passwordError'];
            else return false;
        }
    
        /**
         * Summary of logout : déconnecte l'utilisateur (nécessite un formulaire)
         * @return void
         */
        function logout(){
            if(isset($_POST['logout'])){
                //on réinitialise les variables de session
                $_SESSION['mail']='';
                $_SESSION['role']='';
                $_SESSION['firstName']='';
                $_SESSION['lastName']='';
            }
        }
    
        /**
         * Summary of authorize : indique si le role de l'utilisateur en cours fait parti de ceux entrés en paramètre
         * @param mixed $roles : tableau de roles authorisés ('disconnect' (en 0), 'connected' (en 0), 'Employé.e', 'Adminitrateur.rice', 'Vétérinaire')
         * @return bool : 
         */
        function authorize($roles){
            //si le tableau est vide retourne vrai
            if($roles==[]) return true;
            //si le role 0 est disconnect
            if($roles[0]=='disconnect'){
                if(isConnected()) return false;
                else return true;
            }
            else{
                //si le role 0 est connected
                if($roles[0]=='connected'){
                    //si l'utilisateur n'a pas de role c'est faux
                    if((!isset($_SESSION['role']) || $_SESSION['role']=="")) return false;
                    else return true;
                }
                else{
                    // si le role de l'utilisateur fait parti du tableau true
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
    
        //on permet de vérifier le login en cas de soumission
        verifiedLogin();
        //on permet à l'utilisateur de se déconnecter
        logout();
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }
}