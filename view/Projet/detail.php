<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
    <div class="mdl-card__title mdl-card--expand">
        <h3><?php echo htmlspecialchars($projet->getNomProjet()) ?></h3>
    </div>
    <div class="mdl-card__supporting-text">
        <b>Statut du projet :</b> <?php echo $projet->getStatut() ?><br>
        <b>Programme de financement :</b> 
        <?php
        if ($sourceFin == false) {
            echo "Inconnue<br>";
        }else {
            echo '<a href="index.php?controller=sourceFin&action=read&codeSourceFin='.$sourceFin->getCodeSourceFin().'">'.$sourceFin->getNomSourceFin().'</a><br>';  
        }
        if ($projet->getDateReponse() != null) { ?>
        <b>Date de dépôt du dossier :</b> <?php list($year, $month, $day) = explode('-', $projet->getDateDepot());
                        echo $day.'/'.$month.'/'.$year; ?> <br>
        <?php } if ($projet->getDateReponse() != null) { ?>
            <b>Date de réponse :</b> <?php list($year, $month, $day) = explode('-', $projet->getDateReponse());
                        echo $day.'/'.$month.'/'.$year.'<br>';
        }
        if ($theme != false) {
            echo "<b>Thème :</b> ".$theme->getNomTheme().'<br>';
        }
        ?><b>Rôle EDF :</b> <?php echo $projet->getRole()?>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=note&action=readAllByProjet&codeProjet=<?php echo $projet->getCodeProjet()?>">Commentaires du projet</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=document&action=readAllByProjet&codeProjet=<?php echo $projet->getCodeProjet() ?>">Documents du projet</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=deadLine&action=create&codeProjet=<?php echo $projet->getCodeProjet() ?>">Ajouter une échéance</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=projet&action=updateContacts&codeProjet=<?php echo htmlspecialchars($projet->getCodeprojet()) ?>">Modifier les contacts</a>
    </div>
    </div>


    <div class="mdl-card__supporting-text content">
        <h4>Description sommaire du projet:</h4>
        <div id="descProj"><?php echo $projet->getDescription(); ?></div>
        <div class="detailProjet">
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
            <?php
            if ($tabDeadLine) {
            ?>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Echéance</th>
                    <th class="mdl-data-table__cell--non-numeric">Date</th>
                    <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($tabDeadLine as $value) {
                    echo '<tr>
                        <td class="mdl-data-table__cell--non-numeric">'.$value->getNomDeadLine().'</td>
                        <td class="mdl-data-table__cell--non-numeric">';
                        list($year, $month, $day) = explode('-', $value->getDateDeadLine());
                        echo $day.'/'.$month.'/'.$year.'</td>
                        <td class="mdl-data-table__cell--non-numeric"><a id="'.$value->getCodeDeadLine().'" class="deleteDate" href=""><i class="material-icons">delete</i></td>
                        </tr>';
                }
                echo '
                </tbody>
            </table>';
            } ?>
        </div>
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

<div class="horizontal">
    <div>
    <h3>Contact EDF</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prenom</th>
            <th class="mdl-data-table__cell--non-numeric">Entité</th>
            <th class="mdl-data-table__cell--non-numeric">Mail</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabContact as $contact) {
            //$contact = ModelContact::select($IDContact);
            if ($contact->getCodeEntite() != null) {
                $entite = ModelEntite::select($contact->getCodeEntite());
                echo '<tr';
                if ($chef && $contact->getCodeContact() == $chef->getCodeContact()) {
                    echo ' style="background-color: #b9e2f7;"';
                }
                echo '>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=entite&action=read&codeEntite='.$contact->getCodeEntite().'">'.$entite->getNomEntite().'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                </tr>';
            }
        }
        ?>
        </tbody>
    </table>
    </div> 
    <div>
    <h3>Contact du programme</h3>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prenom</th>
            <th class="mdl-data-table__cell--non-numeric">Mail</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabContactProgramme as $contact) {
            //$contact = ModelContact::select($contact);
            if ($contact->getCodeEntite() == null) {
                echo '<tr>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                    <td class="mdl-data-table__cell--non-numeric">'.$contact->getMail().'</td>
                </tr>';
            }
        }
        ?>
        </tbody>
    </table>
    </div>
    <div>
    <h3>Partenaires du consortium</h3>
    <?php
        if ($tabParticipant == false){
            echo 'Il n\'y a pas de participant à ce consortium';
        }else {
    ?>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Mail</th>
                    <th class="mdl-data-table__cell--non-numeric">Nationalité</th>
                    <th class="mdl-data-table__cell--non-numeric">Budget</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($tabParticipant as $participant) {
                    //$participant = ModelParticipant::select($IDParticipant);
                        echo '<tr>
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=participant&action=read&codeParticipant='.$participant->getCodeParticipant().'">'.$participant->getAffiliation().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$participant->getMailParticipant().'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$participant->getNationalite().'</td>
                            <td class="mdl-data-table__cell--non-numeric">';
                        $participation = ModelParticipation::select($projet->getCodeProjet(),$participant->getCodeParticipant());
                        echo $participation->getBudget().'</td>
                        </tr>';
                    }

                ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

</div>
<a href="index.php?controller=projet&action=create" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
    <i class="material-icons">add</i>
</a>
