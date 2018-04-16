<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo htmlspecialchars($ens->getNomEns()) ?></h2>
        </div>
        <div class="mdl-card__supporting-text mdl-card--border">
            Code Enseignant : <?php echo htmlspecialchars($ens->getCodeEns()) ?><br>
            Departement : <?php echo htmlspecialchars($ens->getCodeDepartement()->getNomDepartement()) ?><br>
            Statut v1 : <?php echo htmlspecialchars($ens->getCodeStatut()->getStatut()) ?><br>
            Statut v2 : <?php echo htmlspecialchars($ens->getCodeStatut()->getTypeStatut()) ?><br>
            Etat Service : <?php echo htmlspecialchars($ens->getNbHeuresReal()) ?><br>
            Nombre d'heures à faire : <?php echo htmlspecialchars($ens->getCodeStatut()->getNombresHeures()) ?><br>
        </div>
        <div class="mdl-card__supporting-text mdl-card--border">
            <h2 class="mdl-card__title-text">Remarque</h2>
            <?php
            if ($ens->getRemarque() == NULL) echo 'Aucune remarque';
            else echo htmlspecialchars($ens->getRemarque());
            ?>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=enseignant&action=update&codeEns=<?php echo htmlspecialchars($ens->getCodeEns()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=enseignant&action=delete&codeEns=<?php echo htmlspecialchars($ens->getCodeEns()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>

    <?php

    foreach ($modules as $module) {
        echo '
            <div class="mdl-card mdl-shadow--2dp import" style="width: auto">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">'.htmlspecialchars($module['nomDepartement']).'</h2>
        </div>
        <div class="mdl-card__supporting-text" style="width: 100%; padding-right: 15px">
        ';
        // Tableaux modules
        echo '
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Code du module</th>
            <th class="mdl-data-table__cell--non-numeric">Nom du module</th>
            <th class="mdl-data-table__cell--non-numeric">Heures TD</th>
            <th class="mdl-data-table__cell--non-numeric">Heures TP</th>
            <th class="mdl-data-table__cell--non-numeric">Heures CM</th>
            <th class="mdl-data-table__cell--non-numeric">Autres heures</th>
        </tr>
        </thead>
        <tbody>
        ';
        // BOUCLE FOREACH DES MODULES
        $tab = $module['modules'];
        foreach ($tab as $item) {
            echo '    <tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=module&action=read&codeModule='.$item->getCodeModule().'"><i class="material-icons">expand_more</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric">'.$item->nommer().'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$item->getNomModule().'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$ens->getHeuresTD($item->getCodeModule()).'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$ens->getHeuresTP($item->getCodeModule()).'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$ens->getHeuresCM($item->getCodeModule()).'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$ens->getHeuresAutres($item->getCodeModule()).'</td>
                  </tr>';
        }
        echo '
        </tbody>
</table>


        ';
        echo '
            </div>
        </div>
        ';
    }
    
    ?>

</div>


<a href="index.php?controller=enseignant&action=getListCours&codeEns=<?php echo $ens->getCodeEns()  ?>" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">expand_more</i>
    </button>
</a>