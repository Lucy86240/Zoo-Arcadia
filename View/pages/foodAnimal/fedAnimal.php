
            <form method="POST" action="">
                <div class="element">
                    <label for="dateFed">Date : </label>
                    <input type="date" name="dateFed" id="dateFed" value="<?php echo(now());?>">
                </div>
                <div class="element">
                    <label for="hourFed">Heure : </label>
                    <input type="time" name="hourFed" id="hourFed" value="">
                </div>
                <div class="element">
                    <label for="animalFed">Animal :</label>
                    <input type="text" class="animalFed" id="animalFed" value="<?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>" placeholder="par défaut : <?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>"autocomplete="off">
                    <?php $animalsListUpdate = listAllAnimals();?>
                </div>
                <div class="element">
                    <div> </div>
                    <ul class="animals" id="listAnimals">
                        <?php foreach($animalsListUpdate as $animalListUpdate){ ?>
                            <li class="form-check none">
                                <input class="form-check-input" type="radio" name="searchAnimalFed" id="searchAnimalFed<?php echo($animalListUpdate['id_animal']);?>" value="<?php echo($animalListUpdate['id_animal']);?>" required>
                                <label class="form-check-label" for="searchAnimalFed<?php echo($animalListUpdate['id_animal']);?>">
                                    <?php echo($animalListUpdate['name'].' - '.$animalListUpdate['label']) ?>
                                </label>
                            </li>
                        <?php }?>
                        <p class="MessageResult none" id="msgListAnimals">Trop de résultats possibles... veuillez affiner</p>
                    </ul>
                </div>

                <!--
                    animal -> par défaut get
                    emp -> utilisateur connecté
-->
                <div class="element">
                    <label for="foodFed">Nourriture donnée :</label>
                    <input type="text" name="foodFed" id="foodFed" required />
                </div>
                <div class="element">
                    <label for="weightFed">Quantité :</label>
                    <input type="text" name="weightFed" id="weightFed" required />
                </div>
                <div class="form-submit">
                    <input type="submit" value="Soumettre" name="addFood" class="button btn-darkGreen" />
                </div>
            </form>
