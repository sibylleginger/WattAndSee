<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Batiment</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <td><a href="index.php?controller=batiment&action=read&nomBatiment=' . htmlspecialchars($value->getNomBatiment()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomBatiment()) . '</td>
                        <td><a href="index.php?controller=batiment&action=delete&nomBatiment=' . htmlspecialchars($value->getNomBatiment()) . '"><i class="material-icons">delete</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <form method="post" action="index.php?controller=batiment&action=created">
                <th><button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--mini-fab mdl-button--colored bouton" type="submits">
                        <i class="material-icons">add</i>
                    </button></th>
                <th>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input"
                               type="text" id="nomBatiment" name="nomBatiment" required>
                        <label class="mdl-textfield__label" for="nomBatiment">Nom Batiment</label>
                    </div>
                </th>
            </form>
        </tr>
        </tfoot>
    </table>
</div>