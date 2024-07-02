<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "View/assets/css/style.css">
    <script src="View/assets/script/header.js" defer></script>
    <title>Zoo Arcadia</title>
</head>
<body>
    <header class="header">
        <nav class="navbar top">
            <div class="container-fluid" id="container-fluid">
                <a class="navbar-brand" href="/">
                    <img class="logo" src="View/assets/img/general/header/logo.png" alt="logo du zoo Arcadia">
                </a>
                <div class="menu">
                    <label class="mobile" for="toggle"><img class="menu-icon" src="View/assets/img/general/header/menu.svg" alt="Menu"></label>
                    <input type="checkbox" id="toggle">
                    <div class="navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="services">Nos services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="habitats">Nos habitats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="contact">Contact</a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link connected-link" id="dropdown-toggle" href="#" role="button" aria-expanded="false">
                                Espace ROLE
                                <img class="arrow" id="arrow-close" src="View/assets/img/general/buttons/arrow-drop-down.svg" alt="menu-close">
                                <img class="arrow none" id="arrow-open" src="View/assets/img/general/buttons/arrow-drop-up.svg" alt="menu-open">
                            </a>
                            <ul class="dropdown-menu none top" id="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tableau de bord</a></li>
                                <li><a class="dropdown-item" href="#">Comptes-rendus vétérinaires</a></li>
                                <li><a class="dropdown-item" href="#">Animaux</a></li>
                                <li><a class="dropdown-item" href="#">Horaires du zoo</a></li>
                                <li><a class="dropdown-item" href="avis">Avis</a></li>
                                <li><a class="dropdown-item" href="#">Nourrir un animal</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Comptes utilisateurs</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="connexion">
                    <a href=#"><img class="account" src="View/assets/img/general/header/account.svg" alt="Connexion"> </a>
                    <span class="text-center">Me connecter</span>
                </div>
            </div>
        </nav>
    </header>