<?php if($_SERVER['REQUEST_URI']=='/View/pages/contact.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <section id="contactPage">
        <div class="head"></div>
        <h1>Nous contacter</h1>
        <?php if(isset($msg) && $msg){ ?>
            <p>Votre message a bien été envoyé. <br> Notre équipe le traitera sous les meilleurs délais.</p>
        <?php } ?>
        <?php if(isset($msg) && !$msg){ ?>
            <p>Une erreur est survenue nous n'avons pas pu envoyer votre message.</p>
        <?php } ?>
        <div id="form">
            <img id="illustration">
            <?php if(!isset($msg) || (isset($msg) && $msg==false)){ ?>
            <form method="POST" action="">
                <div class="element">
                    <label for="company">Structure :</label>
                    <input type="text" name="company" id="company" pattern="^([a-zA-Z0-9èéëïç&])+$">
                </div>
                <div id="name">
                    <div class="element">
                        <label for="firstName">Prénom* :</label>
                        <input type="text" name="firstName" id="firstName" pattern="^([a-zA-Zèéëïç])+$" required>
                    </div>
                    <div class="element">
                        <label for="lastName">Nom* :</label>
                        <input type="text" name="lastName" id="lastName" pattern="^([a-zA-Zèéëïç])+$" required>
                    </div>
                </div>
                <div id="coordonate">
                    <div class="element">
                        <label for="tel">Téléphone :</label>
                        <input type="tel" name="tel" id="tel" pattern="^([0-9])+$">
                    </div>
                    <div class="element">
                        <label for="mail">Mail* :</label>
                        <input type="email" name="mail" id="mail" required>
                    </div>
                </div>
                <div class="element">
                    <label for="object">Objet* :</label>
                    <input type="tel" name="object" id="object" pattern="^([a-zA-Zèéëïç])+$" required>
                </div>
                <div class="element">
                    <span>Message* :</span>
                    <textarea name="msg" pattern="^([a-zA-Z0-9èéëïç&!?,:;()])+$" required></textarea>
                </div>
                <div class="form-submit">
                    <input type="submit" value="Envoyer" name="submitMsg" class="button btn-brown" />    
                </div>
            </form>
            <?php } ?>       
        </div>
        <script src="View/assets/script/contact.js"></script>
    </section>
<?php } ?> 