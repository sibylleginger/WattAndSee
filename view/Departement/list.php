<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Details</th>
            <th class="mdl-data-table__cell--non-numeric">Departement</th>
            <th class="mdl-data-table__cell--non-numeric">Batiment</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <td><a href="index.php?controller=departement&action=read&codeDepartement=' . htmlspecialchars($value->getCodeDepartement()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomDepartement()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomBatiment()->getNomBatiment()).'</td>
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
<div class="new">
    <button id="demo-menu-top-right"
            class="mdl-button mdl-js-button mdl-button--fab">
        <i class="material-icons">more_vert</i>
    </button>

    <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        for="demo-menu-top-right">
        <a href="index.php?controller=departement&action=create"><li class="mdl-menu__item">Créer un départment</li></a>
        <a href="index.php?controller=diplome&action=create"><li class="mdl-menu__item">Créer un diplome</li></a>
        <a href="index.php?controller=uniteDEnseignement&action=create"><li class="mdl-menu__item">Créer une unité d'enseignement</li></a>
    </ul>
</div>