<section class="services">
    <div style="height:80px; background-color:var(--green);"> </div>
    <div class="title">
        <p>Pour vous accompagner nous vous proposons</p>
        <h1>les services </h1>
    </div>
    <?php $index = 0;
    foreach($services as $service){?>
        
    <div class="service service-desktop">
        <div class = "box-backOffice <?php permission(['Employé.e','Administrateur.rice']); ?>">
            <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/edit.svg" alt="Modifier service"></div>
            <a href="#" class="bgc-img-box deleteService"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer service"></a>
            <div class="none c-dialog dialog-delete-js">
                <div class="fond"> </div>
                <form class="c-dialog__box popup-delete" method="POST">
                        <span class="Entete">Suppression</span>
                        
                        <p>Etes vous sûr de vouloir supprimer le service : "<?php echo($service['name']);?>" ?</p>
                        <div class="delete-choice">
                            <input type="submit" name="ValidationDeleteService<?php echo($service['id_service']);?>" value="Oui" class="button-delete">
                            <button class="button btn-green">Non</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="container-service">
            <?php if($index%2==0){?> <img class="img-service <?php if($service['images'][0]['portrait']) echo('img-portrait'); ?>" src="<?php echo($service['images'][0]['path']);?>" alt="<?php echo($service['images'][0]['description']); ?>"><?php } ?>
            <div class="text-service">
                <h2><?php echo($service['name']);?></h2>
                <p><?php echo($service['description']);?></p>
            </div>
            <?php if($index%2!=0){?> <img class="img-service <?php if($service['images'][0]['portrait']) echo('img-portrait'); ?>" src="<?php echo($service['images'][0]['path']);?>" alt="<?php echo($service['images'][0]['description']); ?>"><?php } ?>
        </div>
    </div>

    <div class="service service-mobile">
        <div class = "box-backOffice <?php permission(['Employé.e','Administrateur.rice']); ?>">
            <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/edit.svg" alt="Modifier service"></div>
            <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer service"></div>
        </div>
        <div class="container-service">
            <h2><?php echo($service['name']);?></h2>
            <img class="img-service <?php if($service['images'][0]['portrait']) echo('img-portrait'); ?>" src="<?php echo($service['images'][0]['path']);?>" alt="<?php echo($service['images'][0]['description']); ?>">
            <p><?php echo($service['description']);?></p>
        </div>
    </div>
    <?php $index++; }?>

    <div class="button-addService <?php permission(['Administrateur.rice']); ?>">
        <a href="nouveau_service">
            <button type="button" id="popup-service" aria-haspopup="dialog" aria-controls="dialog" class="btn btn-green">
                Ajouter un service
            </button>
        </a>
    </div>
    <script src="View/assets/script/services.js"></script>
</section>