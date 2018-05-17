<div class="detailBatiment1">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
    </div>
    <h3>Projets liés</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">Nom du projet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tabProjet as $projet) {
                echo '<tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=read&codeProjet='.$projet->getCodeProjet().'">'.$projet->getNomProjet().'</a></td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="updateContactBox">
        <h5>Contacts du programme de financement</h5>
            <a href="index.php?controller=contact&action=create&codeSourceFin=<?php echo $projet->getCodeSourceFin() ?>" class="addNew">
                <i class="material-icons">add</i>
            </a>
        </div>
        <div class="updateContactBox" id="<?php echo $projet->getCodeProjet()?>">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users" id="tableHorsEDF">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Nom</th>
                        <th class="mdl-data-table__cell--non-numeric">Prénom</th>
                        <th class="mdl-data-table__cell--non-numeric">Mail</th>
                        <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tabContact as $contact) {
                        echo '<tr>
                                <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                                <td class="mdl-data-table__cell--non-numeric"><a class="deleteContact" id="'.$contact->getCodeContact().'" href=""><i class="material-icons">delete</i></a></td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=sourceFin&action=update&codeSourceFin=<?php echo htmlspecialchars($sourceFin->getCodeSourceFin()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=sourceFin&action=delete&codeSourceFin=<?php echo htmlspecialchars($sourceFin->getCodeSourceFin()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
</div>

<a href="index.php?controller=sourceFin&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>