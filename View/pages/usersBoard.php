<section id="usersBoard">
    <!--<div class="head"></div>-->
    <div class="themeBeige">
        <table>
            <caption>
                <div class="entete">
                    <img class="illustration" src="View/assets/img/general/pages/usersBoard/ours.png" alt="">
                    <div class="title">
                        <h1>Comptes utilisateurs</h1>
                        </br>
                    </div>
                </div>
                <!-- filtres -->
                <form class="filter" method="POST">
                    <span class="title">Filtres :</span>
                    <div class="bodyFilter">
                        <div>
                            <span>Roles : </span>
                            <div>
                                <?php $roles = listOfRole();
                                $count=0;
                                foreach($roles as $role){?>
                                    <div>
                                        <input class="roleCheckbox" type="checkbox" value="<?php echo($role[0]);?>" name="role<?php echo($count) ?>" id="role<?php echo($count) ?>" checked>
                                        <label for="role<?php echo($count) ?>"><?php echo($role[0]);?></label
                                    </div>
                                <?php $count++; }?>
                            </div>
                        </div>
                        <div>
                            <label for="mailSearch">Mail : </label>
                            <input type="text" name="mailSearch" id="mailSearch">
                        </div>
                    </div>
                </form>
            </caption>
            <thead>
                <tr>
                    <th scope="col"> <h3>Nom</h3> </th>
                    <th scope="col"> <h3>Prénom</h3> </th>
                    <th scope="col"> <h3>Mail</h3> </th>
                    <th scope="col"> <h3>Role</h3> </th>
                    <th scope="col"> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($accounts as $account){ ?>
                    <?php if($_SESSION['mail']!=$account['mail']){ ?>
                        <tr class="js-account">
                            <th scope="row" class="js-lastName" mail=<?php echo($account['mail']); ?>><?php echo($account['lastName']); ?></th>
                            <td class="js-firstname" mail=<?php echo($account['mail']); ?>><?php echo($account['firstName']); ?></td>
                            <td class="js-mail" mail=<?php echo($account['mail']); ?>><?php echo($account['mail']); ?></td>
                            <td class="js-role" mail=<?php echo($account['mail']); ?>><?php echo($account['role']); ?></td>
                            <td>
                                <div class="icons">
                                    <?php if($account['blocked']==0){ ?>
                                        <div class="icon js-icon js-bloc" mail=<?php echo($account['mail']); ?>>
                                            <img  src="View/assets/img/general/pages/usersBoard/cadenas-ouvert.png" alt="Bloquer compte">
                                        </div>
                                    <?php }
                                    else{ ?>
                                        <div class="icon js-icon js-unbloc" mail=<?php echo($account['mail']); ?>>
                                            <img  src="View/assets/img/general/pages/usersBoard/cadenas.png" alt="Débloquer compte">
                                        </div>
                                    <?php } ?>
                                    <div class="icon js-icon js-edit" mail=<?php echo($account['mail']); ?>>
                                        <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/edit.svg" alt="Modifier compte"></div>
                                    </div>
                                    <div class="icon js-icon js-delete" mail=<?php echo($account['mail']); ?>>
                                        <div class="bgc-img-box"><img class="img-box" src="View/assets/img/general/icons/delete.svg" alt="Supprimer compte"></div>
                                    </div>
                                </div>
                                <div class="legends">
                                    <?php if($account['blocked']==0){ ?>
                                        <span class="legend js-legend none">Bloquer</span>
                                    <?php }
                                    else{ ?>
                                        <span class="legend js-legend none">Débloquer</span>
                                    <?php } ?>
                                    <span class="legend js-legend none">Modifier</span>
                                    <span class="legend js-legend none">Suppr.</span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>    
                <?php } ?>
            
            </tbody>
        </table>
        <div class="buttons">
            <div id="btnCreateAccount" class="btn-green btnUser" ><span>Créer un utilisateur</span></div>
            <div class="btn-green btnUser" mail="<?php echo($_SESSION['mail'])?>" firstName = "<?php echo($_SESSION['firstName'])?>" lastName = "<?php echo($_SESSION['lastName'])?>" role = "<?php echo($_SESSION['role'])?>" id="updateMyAccount"><span>Modifier mon compte</span></div>
        </div>
        <div id="js-confirm"></div>
    </div>
</section>

<script src="View/assets/script/popup.js"></script>
<script src="View/assets/script/usersBoard.js"></script>