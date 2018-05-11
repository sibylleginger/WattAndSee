<h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
    <div class="mdl-card__title mdl-card--expand">
        
    </div>
    <div class="mdl-card__supporting-text">
        Statut du projet : <?php echo $projet->getStatut() ?><br>
        Programme de financement : 
        <?php
        if ($sourceFin == false) {
            echo "Inconnue<br>";
        }else {
            echo $sourceFin->getNomSourceFin().'<br>';  
        }
        ?>
        Date de dépôt du dossier : <?php echo $projet->getDateDepot();?> <br>
        <?php if ($projet->getDateReponse() != null) { ?>
            Date de réponse : <?php echo $projet->getDateReponse();
        }?> <br>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Détails du projets</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Personnes impliquées</a>
    </div>
    </div>


    <div class="mdl-card__supporting-text">
        <h4>Description sommaire du projet:</h4>
        <div id="descProj"><?php echo $projet->getDescription(); ?></div>
        <div><p><?php
        if ($theme != false) {
            echo "Thème : ".$theme->getNomTheme();
        }
        ?></p> <p>Rôle EDF : <?php echo $projet->getRole()?></p></div>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric"></th>
                    <th class="mdl-data-table__cell--non-numeric">Total</th>
                    <th class="mdl-data-table__cell--non-numeric">Pour EDF</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Budget</td>
                    <td><?php echo htmlspecialchars($projet->getBudgetTotal()) ?>€</td>
                    <td><?php echo htmlspecialchars($projet->getBudgetEDF()) ?>€</td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Subventions</td>
                    <td><?php echo htmlspecialchars($projet->getSubventionTotal()) ?>€</td>
                    <td><?php echo htmlspecialchars($projet->getSubventionEDF()) ?>€</td>
                </tr>
                <!--<tr>
                    <td class="mdl-data-table__cell--non-numeric">Taux subventions</td>
                    <td><?php
                        //var taux = 
                        //echo htmlspecialchars($projet->getHeuresCM()) ?></td>
                </tr>-->
                </tbody>
            </table>
        </div>
</div>

        <div class="mdl-card__menu">
            <a href="index.php?controller=projet&action=update&codeProjet=<?php echo htmlspecialchars($projet->getCodeprojet()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=projet&action=delete&codeProjet=<?php echo htmlspecialchars($projet->getCodeprojet()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>
    <a href="index.php?controller=projet&action=updateContacts&codeProjet=<?php echo htmlspecialchars($projet->getCodeprojet()) ?>">Modifier les contacts</a>
    <h3>Contact EDF</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prenom</th>
            <th class="mdl-data-table__cell--non-numeric">Entité</th>
            <th class="mdl-data-table__cell--non-numeric">Contact</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabContact as $contact) {
            //$contact = ModelContact::select($IDContact);
            if ($contact->getCodeEntite() != null) {
                echo '<tr>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getCodeEntite().'</td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                </tr>';
            }
        }
        ?>
        </tbody>
    </table>

    <h3>Contact hors EDF</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prenom</th>
            <th class="mdl-data-table__cell--non-numeric">Affiliation</th>
            <th class="mdl-data-table__cell--non-numeric">Contact</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabContact as $contact) {
            //$contact = ModelContact::select($contact);
            if ($contact->getCodeEntite() == null) {
                echo '<tr>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getAffiliation().'</td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                </tr>';
            }
        }
        ?>
        </tbody>
    </table>

    <h3>Partenaires du consortium</h3>
    <?php
        if ($consortium == false) {
            echo 'Il n\'y a pas de consortium';
        }elseif ($tabParticipant == false){
            echo 'Il n\'y a pas de participant à ce consortium';
        }else {
    ?>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Affiliation</th>
                    <th class="mdl-data-table__cell--non-numeric">Nationalité</th>
                    <th class="mdl-data-table__cell--non-numeric">Budget</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($tabParticipant as $participant) {
                    //$participant = ModelParticipant::select($IDParticipant);
                        echo '<tr>
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$participant->getCodeParticipant().'">'.$participant->getNomParticipant().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$participant->getAffiliation().'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$participant->getNationalite().'</td>
                            <td class="mdl-data-table__cell--non-numeric">';
                        $participation = ModelParticipation::select($projet->getCodeConsortium(),$participant->getCodeParticipant());
                        echo $participation->getBudget().'</td>
                        </tr>';
                    }

                ?>
                </tbody>
            </table>
        <?php } ?>

</div>

<a href="index.php?controller=projet&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>