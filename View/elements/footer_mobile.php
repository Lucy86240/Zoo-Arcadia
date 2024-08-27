<?php if($_SERVER['REQUEST_URI']=='/View/elements/footer_mobile.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <?php require 'Controller/schedules.php'; ?>
    <section class="footer-mobile footer">
        <hr class="line_top"> </hr>
        <div class="networks">
            <a href=""><img class="logo-network" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/footer/facebook.svg" alt="logo de facebook"></a>
            <a href=""><img class="logo-network" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/footer/x.svg" alt="logo de X"></a>
            <a href=""><img class="logo-network" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/footer/instagram.svg" alt="logo d'instagram'"></a>
            <a href=""><img class="logo-network" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/footer/tiktok.svg" alt="logo de tiktok"></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="contactDetails-container col text-center">
                    <h2>Nos coordonnées</h2>
                    <span>Route de brocéliande</span>
                    <span>12345 VilleBidon</span>
                    </br>
                    <span> +33 ** ** ** **</span>
                    <a href="contact">Nous contacter</a>
                </div>
                <div class="schedules-container col text-center">
                    <h2>Nos horaires</h2>
                    <span><?php echo($schedules) ?></span>
                </div>
            </div>
            <div class="row">
                <div class = "discover-container col text-center">
                    <h2>Découvrir</h2>
                    <a href="habitats">Nos habitats</a>
                    <a href="animaux">Nos animaux</a>
                    <a href="services">Nos services</a>
                    <a href="avis">Vos avis</a>
                </div>
            <div class="other text-center">
                <h2>Divers</h2>
                <a href="mentions_legales">Mentions légales</a>
                <a href="politique_confidentialites">Politique de confidentialité</a>
            </div>
            </div>
        </div>
        <p class="copyright text-center">© Zoo Arcadia 2024</p>
    </section>
<?php } ?>