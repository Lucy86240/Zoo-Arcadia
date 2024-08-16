<section id="usersBoard">
    <table>
        <caption>
            <div class="headerTable">
                <img class="illustration" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/pages/food/monkey.png" alt="">
                <div class="title">
                    <h1>Comptes utilisateurs</h1>
                    </br>
                </div>
            </div>
            <!-- filtres -->
            <form class="filter" method="POST">
                <span class="title">Filtre :</span>
                <div>
                    <label for="roleSearch">Role </label>
                    <input type="text" name="roleSearch" id="roleSearch">
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
                        <tr>
                            <th scope="row"><?php echo($account['lastName']); ?></th>
                            <td><?php echo($account['firstName']); ?></td>
                            <td><?php echo($account['mail']); ?></td>
                            <td><?php echo($account['role']); ?></td>
                            <td>
                                <?php if($account['blocked']==0){ ?>
                                    pas bloqué
                                <?php }
                                else{ ?>
                                    bloqué
                                <?php } ?>
                                <div class="icon">
                                    Modifier
                                </div>
                                <div class="icon">
                                    Supprimer
                                </div>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>

</section>
