<form method="post" action="index.php?controller=extraction&action=solvedDepInv">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Code d'activitée</th>
            <th class="mdl-data-table__cell--non-numeric">Solution</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($depInv as $item) {
            echo '
<tr>
    <td class="mdl-data-table__cell--non-numeric">'.$item['activitee'].'</td>
    <td class="mdl-data-table__cell--non-numeric">';
            echo '<div><select style="display: block;" name="'.$item['activitee'].'">';
            echo '<option value="rien">Ne rien faire</option>';
            echo '<optgroup label="Départements existants">';
            foreach ($dep as $value) {
                echo '<option value="'.$value->getCodeDepartement().'">'.$value->getNomDepartement().'</option>';
            }
            echo '</optgroup>';
            echo '</select></div>';
            echo '</td>
</tr>
';
        }

        ?>
        </tbody>
    </table>
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect"
            type="submit"
            style="margin-bottom: 15px">
        <i class="material-icons">send</i>
    </button>

</form>