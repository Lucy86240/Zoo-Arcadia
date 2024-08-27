<?php if($_SERVER['REQUEST_URI']=='/View/elements/footer_desktop.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{ ?>
    <?php require 'Controller/schedules.php'; ?>
    <section class="footer-desktop footer">
        <hr class="line-top"> </hr>
        <div class="container-links">
            <div class="container-illu">
                    <div class="networks-container">
                        <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/footer/animals_quokka_map.png" alt="illustration d'un quokka tenant une carte">
                        <div class="network">
                            <a href=""><img class="logo-network" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/footer/facebook.svg" alt="logo de facebook"></a>
                            <a href=""><img class="logo-network" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/footer/x.svg" alt="logo de X"></a>
                            <a href=""><img class="logo-network" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/footer/instagram.svg" alt="logo d'instagram'"></a>
                            <a href=""><img class="logo-network" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/footer/tiktok.svg" alt="logo de tiktok"></a>
                        </div>
                    </div>
                    <div class="contactDetails-container">
                        <h2>Nos coordonnées</h2>
                        <span>Route de brocéliande</span>
                        <span>12345 VilleBidon</span>
                        </br>
                        <span> +33 ** ** ** **</span>
                        <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>contact">Nous contacter</a>
                    </div>
            </div>
            <div class="schedules-container">
                <h2>Nos horaires</h2>
                <span><?php echo($schedules) ?></span>
            </div>
            <div class = "discover-container">
                <h2>Découvrir</h2>
                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>habitats">Nos habitats</a>
                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>animaux">Nos animaux</a>
                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>services">Nos services</a>
                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>avis">Vos avis</a>
            </div>
        </div>
        <hr class="line"> </hr>
        <div class="other">
            <span>© Zoo Arcadia 2024</span>
            <a href="mentions_legales">Mentions légales</a>
            <a href="politique_confidentialite">Politique de confidentialité</a>
        </div>
    </section>
<?php } ?>