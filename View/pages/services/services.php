<?php if($_SERVER['REQUEST_URI']=='/View/pages/services/services.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
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
            <!-- les services version mobile-->
            <div class="service service-mobile">
                <?php if(authorize(['Employé.e','Administrateur.rice'])){ ?>
                <div class = "box-backOffice">
                    <div class="bgc-img-box editServiceM">
                        <img class="img-box" src="View/assets/img/general/icons/edit.svg" alt="Modifier service">
                    </div>
                    <?php if(authorize(['Administrateur.rice'])){ ?>
                    <div class="bgc-img-box iconDelete" id = <?php echo($service['id_service']);?> nameService = "<?php echo(echapHTML($service['name']));?>">
                        <img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer service">
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="container-service">
                    <h2><?php echo($service['name']);?></h2>
                    <img class="img-service <?php if($service['photo']['portrait']) echo('img-portrait'); ?>" src="<?php echo($service['photo']['path']);?>" alt="<?php echo($service['photo']['description']); ?>">
                    <p><?php echo($service['description']);?></p>
                </div>

            </div>
                <!-- formulaire de mise à jour s'affichant au clic d'edit-->
                <?php include 'View/pages/services/updateService.php'; ?>
            <?php $index++; 
        }?>
        <div id="js-confirm"> </div>
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