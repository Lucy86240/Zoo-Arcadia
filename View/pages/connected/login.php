<?php if($_SERVER['REQUEST_URI']=='/View/pages/connected/login.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
        <div> </div>
        <div class="container-login">
        <form method="POST" action="" id="logout-btn">
            <button class="btn-logout" type="submit" name="logout" form="logout-btn">
                <img class="account-connected <?php  if(!isset($_SESSION['firstName']) || empty($_SESSION['firstName'])) echo('none');?>"src="<?php if($optionPage)echo("../");?>View/assets/img/general/header/connected.png"  alt="Connexion">
                <img class="account <?php if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])) echo('none');?>"src="<?php if($optionPage)echo("../");?>View/assets/img/general/header/account.svg"  alt="Connexion">
                <span class="logoutText none">Déconnexion</span>
            </button>
        </form>
        <?php if(!isset($_SESSION['firstName']) || empty($_SESSION['firstName'])){ ?>
            <span class="js-nameLog" id="popup-login" aria-haspopup="dialog" aria-controls="dialog"> Me connecter </span>
        <?php }
        else{ ?>
            <span class="js-nameLog"><?php echo($_SESSION['firstName']) ?></span>
        <?php } ?>
        <div id="login-dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-desc" aria-modal="true" tabindex="-1" class="c-dialog <?php if(!passwordError()) echo('none');?>">
            <div class="fond"></div>
            <div role="document" class="c-dialog__box popup themeBlue">
                <div class="Entete">
                    <h3>Me connecter</h3>
                    <form method="POST"><input class="close" type="submit" aria-label="Fermer" value="x" name="close-login" data-dismiss="dialog"></form>
                </div>
                <div class="img"><img id="illustration-login" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/header/login.png"></div>
                <form class="login-form" method="POST" action="">
                    <div class="element">
                        <label for="user">Votre mail : </label>
                        <input type="mail" name="user" id="user" required placeholder="mail@exemple.fr" autocomplete="email">
                    </div>
                    <div class="element">
                        <label for="password">Votre mot de passe : </label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <?php if(!(!passwordError() || (isset($_SESSION['blocked']) && $_SESSION['blocked']==1) || !isset($_SESSION['blocked']))){ ?>
                        <p class="<?php // if(!passwordError() || (isset($_SESSION['blocked']) && $_SESSION['blocked']==1) || !isset($_SESSION['blocked'])) echo('none');?>">
                            Votre mail ou votre mot de passe est incorrect
                        </p>
                    <?php } ?>
                    <?php if(!((isset($_SESSION['blocked']) && $_SESSION['blocked']==0) || !isset($_SESSION['blocked']))) {?>
                        <p class="<?php if((isset($_SESSION['blocked']) && $_SESSION['blocked']==0) || !isset($_SESSION['blocked'])) echo('none'); ?>">
                        Vous avez fait plus de 3 mots de passe erronés. </br>
                        Votre accès est bloqué. Veuillez contacter l'admin pour vous débloquer.
                        </p>
                    <?php } ?>    
                    <div class="form-submit">
                        <input type="submit" value="Connexion" name="login" class="button btn-green" />
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>