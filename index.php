<?php
    session_start();
    require_once 'CONSTANTES.php';
    require_once 'config.php';
    require_once 'fonctions_generals.php';
    require_once 'router/router.php';
    $optionPage=optionPage($request);
    ?> <script src="<?php if($optionPage){echo("../");}?>CONSTANTES.js"></script> <?php
    
    require_once 'View/elements/header.php';
    

    loadContentPage($request);

    require_once 'View/elements/footer_desktop.php';
    require_once 'View/elements/footer_mobile.php';

