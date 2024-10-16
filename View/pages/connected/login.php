<?php if($_SERVER['REQUEST_URI']=='/View/pages/connected/login.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
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
            <span class="js-nameLog nameLog" id="popup-login"> Me connecter </span>
        <?php }
        else{ ?>
            <span class="js-nameLog nameLog"><?php echo($_SESSION['firstName']) ?></span>
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
                        <input type="email" name="user" id="user" required placeholder="mail@exemple.fr" autocomplete="email">
                    </div>
                    <div class="element">
                        <label for="password">Votre mot de passe : </label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <?php if(isset($_SESSION['passwordError']) && $_SESSION['passwordError']==true && (!isset($_SESSION['blocked']) || (isset($_SESSION['blocked']) && $_SESSION['blocked'] == false))){ ?>
                        <p>
                            Votre mail ou votre mot de passe est incorrect. <br>
                            <?php if(isset($_POST['user'])){ ?>
                            Il vous reste <?php echo(3-$_SESSION['nbError'][$_POST['user']]) ?> essai(s).
                            <?php } ?>
                        </p>
                    <?php } ?>
                    <?php if(isset($_SESSION['blocked'])) {?>
                        <p>
                        <?php  if(isset ($_POST['user']))
                                    if(isset($_SESSION['nbError'][$_POST['user']]) && $_SESSION['nbError'][$_POST['user']] >=3){ ?>    
                                        Vous avez fait plus de 3 mots de passe erronés. </br>
                                    <?php }
                        if(isset($_SESSION['blocked']) && $_SESSION['blocked']==true){ ?>
                        Votre accès est bloqué. Veuillez contacter l'admin pour vous débloquer.
                        <?php }?>
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