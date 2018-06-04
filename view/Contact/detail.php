<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
        <div class="mdl-card__title mdl-card--expand">
            <h3><?php echo $pagetitle ?></h3>
        </div>
        <div class="mdl-card__supporting-text">
            <b>Nom :</b> <?php echo $contact->getNomContact() ?><br>
            <b>Prénom :</b> <?php echo $contact->getPrenomContact() ?><br>
            <?php
                if ($entite == false) {
                    if (!$sourceFin) {
                        echo 'Pas d\'affiliation';
                    }else {
                        echo "<b>Affiliation :</b> ". $sourceFin->getNomSourceFin()."<br>";
                    }
                }else {
                    echo "<b>Entité EDF :</b> <a href=\"index.php?controller=entite&action=read&codeEntite=". $entite->getCodeEntite()."\">".$entite->getNomEntite()."</a><br>";
                    if ($departement != false) {
                        echo "<b>Département :</b> ". $departement->getNomDepartement()."<br>";
                    }
                }
                echo "<b>Adresse mail :</b> ";
                if ($contact->getMail() != null) {
                    echo $contact->getMail();
                }else {
                    echo 'Inconnue';
                }
            ?>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=contact&action=update&codeContact=<?php echo htmlspecialchars($contact->getCodeContact()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=contact&action=delete&codeContact=<?php echo htmlspecialchars($contact->getCodeContact()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>
    <!--</div>-->

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th>Nom du projet</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabProjet as $projet) {
            echo '    <tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=read&codeProjet='.$projet->getCodeProjet().'">'.$projet->getNomProjet().'</a></td>
                  </tr>';
        }
        ?>
        </tbody>
    </table>

</div>

<a href="index.php?controller=contact&action=create">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>