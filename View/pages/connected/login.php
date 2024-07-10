
    <form method="POST" action="" id="logout-btn">
        <button class="btn-logout" type="submit" name="logout" form="logout-btn">
            <img class="account-connected <?php if(!isset($_SESSION['firstName']) || empty($_SESSION['firstName'])) echo('none');?>"src="<?php if($optionPage)echo("../");?>View/assets/img/general/header/connected.png"  alt="Connexion">
            <img class="account <?php if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])) echo('none');?>"src="<?php if($optionPage)echo("../");?>View/assets/img/general/header/account.svg"  alt="Connexion">
            <span class="logoutText none">Déconnexion</span>
        </button>
    </form>
    <span id="popup-login" aria-haspopup="dialog" aria-controls="dialog"><?php if(!isset($_SESSION['firstName']) || empty($_SESSION['firstName'])) echo('Me connecter'); 
        else echo($_SESSION['firstName']);  
    ?></span>
    <div id="login-dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-desc" aria-modal="true" aria-hidden="true" tabindex="-1" class="c-dialog">
        <div class="fond"></div>
        <div role="document" class="c-dialog__box">
            <div class="Entete">
                <h3>Me connecter</h3>
                <button type="button" aria-label="Fermer" title="Fermer connexion" data-dismiss="dialog">x</button>
            </div>
            <div class="img"><img id="illustration-login" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/header/login.png"></div>
            <form class="login-form" method="POST" action="">
                <div class="element">
                    <label for="user">Votre mail : </label>
                    <input type="mail" name="user" id="user" required placeholder="mail@exemple.fr" autocomplete="email">
                </div>
                <div class="element">
                    <label for="password">Votre mot de passe : </label>
                    <input type="password" name="password" id="password" minlength="12" required>
                </div>
                <div class="form-submit">
                    <input type="submit" value="Connexion" name="login" class="button btn-green" />
                </div>
            </form>
        </div>
    </div>
    <script src="<?php if($optionPage){echo("../");}?>View/assets/script/popup.js"></script>