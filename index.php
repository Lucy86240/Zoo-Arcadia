<?php
    require_once 'CONSTANTES.php';
    require_once 'router/router.php';
    $optionPage=optionPage($request);

    require_once 'View/elements/header.php';

    loadContentPage($request);

    require_once 'View/elements/footer_desktop.php';
    require_once 'View/elements/footer_mobile.php';
