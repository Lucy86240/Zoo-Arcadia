<?php
    session_start();
    require_once 'CONSTANTES.php';
    require_once 'config.php';
    require_once 'fonctions_generals_and_initializations.php';

    require_once 'router/router.php';

    $optionPage=optionPage($request);
?> 

<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Découvrez le Zoo Arcadia, un lieu engagé pour la préservation de la biodiversité et la protection de l'environnement. Profitez d'une visite éducative et respectueuse de la nature, avec des initiatives écologiques innovantes." />
        <link rel="stylesheet" href = "<?php if($optionPage){echo("../");}?>View/assets/css/style.css">
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>CONSTANTES_inputs.js"></script> 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/popup.js" defer></script>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/header.js" defer></script>

        <title>Zoo Arcadia</title>
    </head>
    <body>
        <?php
            require_once 'View/elements/header.php';

            loadContentPage($request);

            require_once 'View/elements/footer.php';  
        ?>
    </body>
</html>



