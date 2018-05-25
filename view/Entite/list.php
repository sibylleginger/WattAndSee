<div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom de l'entité</th>
            <th class="mdl-data-table__cell--non-numeric">Nombre contacts</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
            <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tabEntite as $entite) {
            $tabContact = ModelContact::selectAllByEntite($entite->getCodeEntite());
            $nbContacts = count($tabContact);
            echo '<tr>
                        <td><a href="index.php?controller=entite&action=read&codeEntite=' . htmlspecialchars($entite->getCodeEntite()) . '">'. htmlspecialchars($entite->getNomEntite()).'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'; if($nbContacts == false) {
                            echo '0';
                        }else {
                            echo htmlspecialchars($nbContacts);
                        }
                        echo '</td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=entite&action=update&codeEntite=' . htmlspecialchars($entite->getCodeEntite()).'"><i class="material-icons">edit</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=entite&action=delete&codeEntite=' . htmlspecialchars($entite->getCodeEntite()).'"><i class="material-icons">delete</i></a></td>
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
<a href="index.php?controller=sourceFin&action=create" class="new">
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