<div class="detailProjet">
    <div>
    <h2><?php echo $pagetitle ?></h2>
    <h3>Contacts</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3 scroll">
        <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">Nom</th>
                <th class="mdl-data-table__cell--non-numeric">Prénom</th>
                <th class="mdl-data-table__cell--non-numeric">Mail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tabContact as $contact) {
                echo '<tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
    <div class="list">
        <div class="mdl-card mdl-shadow--2dp graph">
            <div id="graph1" style="height: 400px;"></div>
        </div>
        <div class="mdl-card mdl-shadow--2dp graph">
            <div id="graph2" style="height: 400px;"></div>
        </div>
        <div class="mdl-card mdl-shadow--2dp graph">
            <div id="graph3" style="height: 400px;"></div>
        </div>
        <div class="mdl-card mdl-shadow--2dp graph">
            <div id="graph4" style="height: 400px;"></div>
        </div>
    </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=entite&action=update&codeEntite=<?php echo htmlspecialchars($entite->getCodeEntite()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=entite&action=delete&codeEntite=<?php echo htmlspecialchars($entite->getCodeEntite()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
</div>

<a href="index.php?controller=Entite&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>