<?php
    require_once 'router/router.php';

    require_once 'View/elements/header.php';

    loadContentPage($request);

    require_once 'View/elements/footer_desktop.php';
    require_once 'View/elements/footer_mobile.php';
