<?php if($_SERVER['REQUEST_URI']=='/View/elements/header.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href = "<?php if($optionPage){echo("../");}?>View/assets/css/style.css">
        <script src="<?php if($optionPage){echo("../");}?>View/assets/script/popup.js" defer></script>
        <script src="<?php if($optionPage){echo("../");}?>View/assets/script/header.js" defer></script>
        <title>Zoo Arcadia</title>
    </head>
    <body>
        <header class="header">
            <nav class="navbar top">
                <div class="container-fluid" id="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img class="logo" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/header/logo.png" alt="logo du zoo Arcadia">
                    </a>
                    <div class="menu">
                        <label class="mobile" for="toggle">
                            <img class="menu-icon" src="<?php if($optionPage==true){echo("../");}?>View/assets/img/general/header/menu.svg" alt="Menu">
                        </label>
                        <input type="checkbox" id="toggle">
                        <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_SERVER['REQUEST_URI']=='/') echo('active') ?>" id="<?php if($optionPage){echo("../");}?>home" aria-current="page" href="/">Accueil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_SERVER['REQUEST_URI']=='/services') echo('active') ?>" id="<?php if($optionPage){echo("../");}?>services" href="<?php if($optionPage==true){echo("../");}?>services">Nos services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_SERVER['REQUEST_URI']=='/habitats') echo('active') ?> text-white" id="<?php if($optionPage){echo("../");}?>housings" href="<?php if($optionPage==true){echo("../");}?>habitats">Nos habitats</a>
                                </li>
                                <?php if(authorize(['disconnect'])){?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_SERVER['REQUEST_URI']=='/contact') echo('active') ?> text-white" id="<?php if($optionPage){echo("../");}?>contact" href="<?php if($optionPage==true){echo("../");}?>contact">Contact</a>
                                </li>
                                <?php } ?>
                                    <?php if(authorize(['connected'])){ ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link connected-link" id="dropdown-toggle" href="#" role="button" aria-expanded="false">
                                                Espace <?php if(isset($_SESSION['role'])) echo($_SESSION['role']);?>
                                                <img class="arrow" id="arrow-close" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/arrow-drop-down.svg" alt="menu-close">
                                                <img class="arrow none" id="arrow-open" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/arrow-drop-up.svg" alt="menu-open">
                                            </a>
                                            <ul class="dropdown-menu none top" id="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>dashboard">Tableau de bord</a></li>
                                                <?php if(authorize(['Administrateur.rice','Vétérinaire'])){ ?>
                                                    <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>rapports_medicaux">Comptes-rendus vétérinaires</a></li>
                                                <?php } ?>
                                                <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>animaux">Animaux</a></li>
                                                <?php if(authorize(['Administrateur.rice'])){ ?>
                                                    <li><a class="dropdown-item" href="horaires">Horaires du zoo</a></li>
                                                <?php } ?>
                                                <?php if(authorize(['Administrateur.rice','Employé.e'])){ ?>
                                                    <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>avis">Avis</a></li>
                                                <?php } ?>
                                                <?php if(authorize(['Employé.e'])){ ?>
                                                    <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>repas">Nourrir un animal</a></li>
                                                <?php } ?>
                                                <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>commentaires_habitats">Commentaires des habitats</a></li>
                                                <?php if(authorize(['Administrateur.rice'])){ ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="<?php if($optionPage){echo("../");}?>comptes_utilisateurs">Comptes utilisateurs</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="login">
                        <?php include_once ("View/pages/connected/login.php");?>
                    </div>
                </div>
            </nav>
        </header>
<?php } ?>