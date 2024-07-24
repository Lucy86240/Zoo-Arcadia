<section class="animal">
    <div class="theme-beige layout">
        <div class="box-backoffice">
            <!-- Boite à outil permettant de UD un animal
                - éditer l'animal v
                - supprimer l'animal v
                - l'archiver
            -->
            <div class="box-general">
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box editAnimal" src="View/assets/img/general/icons/edit.svg" alt="Modifier l'animal"></div>
                    <span class="legend">Modifier</span>
                </div>
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer animal"></div>
                    <span class="legend">Supprimer</span>
                </div>
            </div>
            <!-- Boite à outil permettant de CR un repas
                - donner à manger
                - voir ses repas
            -->
            <div class="box-feed">
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box mealsAnimal" src="View/assets/img/general/icons/meals.svg" alt="Visualiser les repas"></div>
                    <span class="legend">Repas</span>
                </div>
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box feedAnimal" src="View/assets/img/general/icons/feed.svg" alt="Nourrir"></div>
                    <span class="legend">Nourrir</span>
                </div>
            </div>
            <!-- Boite à outil permettant de CR un compte rendu médical
                - rédiger un compte rendu
                - voir les comptes rendus
            -->
            <div class="box-cure">
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box reportMedicalAnimal" src="View/assets/img/general/icons/description.svg" alt="Visualiser les rapports médicaux"></div>
                    <span class="legend">Rapport médicaux</span>
                </div>
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box newReportAnimal" src="View/assets/img/general/icons/note_add.svg" alt="Ajouter un rapport médical"></div>
                    <span class="legend">Nouveau rapport</span>
                </div>
            </div>
        </div>
        <div class="title">
            <h2><?php echo($animal['name']); ?></h2>
            <h3><?php echo($animal['breed']); ?></h3>
        </div>
        <div class="body">
            <div class="images">
                <div class="img-container"><img class="imgAnimal" src="View/assets/img/animals/1-Marcel/Marcel1.jpg" alt="Marcel"></div>
                <div class ="pagination">
                    <!-- image précédente (désactivé si on se trouve sur la 1ère image) -->
                        <div class="btn-previous bp-brown">
                            <img class="previous-img" src="View/assets/img/general/buttons/previous_brown.png" alt="Bouton précédent">
                            <p class="previous-text txt-pagination">Précédent</p> 
                        </div>   
                    <!-- image suivante (désactivé si on se trouve sur la dernière image) -->
                        <div class="btn-next bn-brown">
                            <p class="next-text txt-pagination">Suivant</p> 
                            <img class="next-img" src="View/assets/img/general/buttons/next_brown.png" alt="Bouton suivant">
                        </div>    
                </div>
            </div>
            <div class="description">
                <div class="element">
                    <p><span>Son habitat :</span>
                    <?php echo($animal['housing']); ?></p>
                </div>
                <div class="element">
                    <p> <span>Son état :</span> 
                    <?php echo($animal['LastMedicalReport']['health']); ?></p>
                </div>
                <div class="element"> 
                    <p> <span>Sa nourriture :</span>
                    <?php echo($animal['LastMedicalReport']['food']); ?></p>
                </div>
                <div class="element"> 
                    <p> <span>Son grammage :</span> 
                    <?php echo($animal['LastMedicalReport']['weightFood']); ?></p>
                </div>
                <div class="element">
                    <p> <span>Détail de son état :</span>
                    <?php echo($animal['LastMedicalReport']['comment']); ?></p>
                </div>
                <div class="element">
                    <p> <span>Dernière visite du vétérinaire :</span>
                    <?php echo($animal['LastMedicalReport']['date']); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>