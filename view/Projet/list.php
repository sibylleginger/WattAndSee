<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Intitulé</th>
            <th class="mdl-data-table__cell--non-numeric">Source de financement</th>
            <th class="mdl-data-table__cell--non-numeric">Statut</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            $sourceFin = ModelSourceFin::select($value->getCodeSourceFin());

            echo '<tr>
                        <td><a href="index.php?controller=projet&action=read&codeProjet=' . htmlspecialchars($value->getCodeProjet()) . '">'. htmlspecialchars($value->getNomProjet()).'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'; if($sourceFin == false) {
                            echo 'Inconnue';
                        }else {
                            echo htmlspecialchars($sourceFin->getNomSourceFin());
                        }
                        echo '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getStatut()).'</td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=update&codeProjet=' . htmlspecialchars($value->getCodeProjet()).'"><i class="material-icons">edit</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<!--
<a href="index.php?controller=departement&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>

-->
<a href="index.php?controller=projet&action=create" class="new">
    <button id="demo-menu-top-right"
            class="mdl-button mdl-js-button mdl-button--fab">
        <i class="material-icons">add</i>
    </button>

    <!--<ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        for="demo-menu-top-right">
        <a href="index.php?controller=departement&action=create"><li class="mdl-menu__item">Ajouter un nouveau projet</li></a>
        <a href="index.php?controller=diplome&action=create"><li class="mdl-menu__item">Créer un diplome</li></a>
        <a href="index.php?controller=uniteDEnseignement&action=create"><li class="mdl-menu__item">Créer une unité d'enseignement</li></a>
    </ul>-->
</a>