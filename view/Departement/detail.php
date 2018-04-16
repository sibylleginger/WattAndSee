<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo htmlspecialchars($dep->getNomDepartement()) ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Batiment : <?php echo $dep->getNomBatiment()->getNomBatiment() ?>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=departement&action=update&codeDepartement=<?php echo htmlspecialchars($dep->getCodeDepartement()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=departement&action=delete&codeDepartement=<?php echo htmlspecialchars($dep->getCodeDepartement()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>


    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Diplome</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=diplome&action=read&codeDiplome=' . htmlspecialchars($value->getCodeDiplome()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td>' . htmlspecialchars($value->nommer()) . '</td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>

</div>

<a href="index.php?controller=diplome&action=create&codeDepartement=<?php echo htmlspecialchars($dep->getCodeDepartement()) ?>" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>

