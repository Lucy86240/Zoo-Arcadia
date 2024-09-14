<?php
    session_start();
    require_once 'CONSTANTES.php';
    require_once 'config.php';
    require_once 'fonctions_generals_and_initializations.php';
    require_once 'router/router.php';
    $optionPage=optionPage($request);?> 
    <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>CONSTANTES_inputs.js"></script> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <?php
    require_once 'View/elements/header.php';
    
    try{
        loadContentPage($request);
    }
    catch(error $e){
        echo("router merde");
    }

    
    require_once 'View/elements/footer.php';   

