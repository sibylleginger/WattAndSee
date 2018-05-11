<div class="detailProjet">
    <!--<div class="mdl-card mdl-shadow--2dp detailBatiment2">-->
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Nom : <?php echo $Contact->getNomContact() ?><br>
            Prénom : <?php echo $Contact->getPrenomContact() ?><br>
            <?php
                if ($entite == false) {
                    echo "Affiliation : ". $Contact->getAffiliation();
                }else {
                    echo "Entité EDF : ". $entite->getNomEntite()."<br>";
                    if ($departement != false) {
                        echo "Département : ". $departement->getNomDepartement()."<br>";
                    }
                }
                if ($Contact->getMail() != null) {
                    echo "Adresse mail : ". $Contact->getMail();
                }
            ?>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=contact&action=update&codeContact=<?php echo htmlspecialchars($Contact->getCodeContact()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=contact&action=delete&codeContact=<?php echo htmlspecialchars($Contact->getCodeContact()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
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

<a href="index.php?controller=contact&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>