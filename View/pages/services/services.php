<?php if($_SERVER['REQUEST_URI']=='/View/pages/services/services.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <section class="services">
        <div class="head"> </div>
        <div class="title">
            <p>Pour vous accompagner nous vous proposons</p>
            <h1>les services </h1>
        </div>
        <?php $index = 0;
        foreach($services as $service){?>
            <!-- service version desktop-->
            <div class="service service-desktop">
        
            <!-- icones permettant la modification / suppression d'un service (seulement pour admin et employés)-->
                <?php if(authorize(['Employé.e','Administrateur.rice'])){ ?>
                <div class = "box-backOffice">
                    <div class="bgc-img-box"><img class="img-box editServiceD" src="View/assets/img/general/icons/edit.svg" alt="Modifier service"></div>
                    
                    <?php if(authorize(['Administrateur.rice'])){ ?>
                        <!-- bouton de suppression seulement pour admin-->
                        <a href="#" class="bgc-img-box iconDelete"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer service"></a>
                        
                        <!-- le popup de suppression s'affichant quand la poubelle est cliquée-->
                        <div class="none c-dialog popupDelete">
                            <div class="fond"> </div>
                            <form class="popup-confirm" method="POST">
                                    <p class="entete">Suppression</p>
                                    
                                    <p>Etes vous sûr de vouloir supprimer le service : "<?php echo($service['name']);?>" ?</p>
                                    <div class="confirm-choice">
                                        <input type="submit" name="ValidationDeleteService<?php echo($service['id_service']);?>" value="Oui" class="button-confirm">
                                        <button class="button btn-green">Non</button>
                                    </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>

                <!-- image et textes du service-->
                <div class="container-service">
                    <?php if($index%2==0){?> <img class="img-service <?php if($service['photo']->getPortrait()) echo('img-portrait'); ?>" src="<?php echo($service['photo']->getPath());?>" alt="<?php echo($service['photo']->getDescription()); ?>"><?php } ?>
                    <div class="text-service">
                        <h2><?php echo($service['name']);?></h2>
                        <p><?php echo($service['description']);?></p>
                    </div>
                    <?php if($index%2!=0){?> <img class="img-service <?php if($service['photo']->getPortrait()) echo('img-portrait'); ?>" src="<?php echo($service['photo']->getPath());?>" alt="<?php echo($service['photo']->getDescription()); ?>"><?php } ?>
                </div>
            </div>
            <!-- les services version mobile-->
            <div class="service service-mobile">
                <?php if(authorize(['Employé.e','Administrateur.rice'])){ ?>
                <div class = "box-backOffice">
                    <div class="bgc-img-box editServiceM"><img class="img-box" src="View/assets/img/general/icons/edit.svg" alt="Modifier service"></div>
                    <?php if(authorize(['Administrateur.rice'])){ ?>
                    <div class="bgc-img-box popupMobile"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer service"></div>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php if(authorize(['Administrateur.rice'])){ ?>
                <!-- le popup de suppression s'affichant quand la poubelle est cliquée-->
                <div class="none c-dialog dialog-popupMobile-js">
                    <div class="fond"> </div>
                    <form class="c-dialog__box popup-confirm" method="POST">
                            <span class="Entete">Suppression</span> 
                            <p>Etes vous sûr de vouloir supprimer le service : "<?php echo($service['name']);?>" ?</p>
                            <div class="confirm-choice">
                                <input type="submit" name="ValidationDeleteService<?php echo($service['id_service']);?>" value="Oui" class="button-confirm">
                                <button class="button btn-green">Non</button>
                            </div>
                    </form>
                </div>
                <?php } ?>

                <div class="container-service">
                    <h2><?php echo($service['name']);?></h2>
                    <img class="img-service <?php if($service['photo']->getPortrait()) echo('img-portrait'); ?>" src="<?php echo($service['photo']->getPath());?>" alt="<?php echo($service['photo']->getDescription()); ?>">
                    <p><?php echo($service['description']);?></p>
                </div>

            </div>
                <!-- formulaire de mise à jour s'affichant au clic d'edit-->
                <?php include 'View/pages/services/updateService.php'; ?>
            <?php $index++; 
        }?>

        <?php if(authorize(['Administrateur.rice'])){ ?>
            <div class="button-addService">
                <a href="nouveau_service">
                    <button type="button" id="popup-service" aria-haspopup="dialog" aria-controls="dialog" class="btn btn-green">
                        Ajouter un service
                    </button>
                </a>
            </div>
        <?php } ?>
        <script src="View/assets/script/popup.js"></script>
        <script src="View/assets/script/services.js"></script>
    </section>
<?php } ?>