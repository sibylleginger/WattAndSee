<form method="post" action="index.php?controller=projet&action=updateContacts">
    <div style="margin: auto; display: flex; align-items: flex-start;">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
        <div class="updateContactBox">
            <h5>Contacts EDF</h5>
            <a href="index.php?controller=contact&action=create" class="addNew">
                <i class="material-icons">add</i>
            </a>
        </div>
        <div class="updateContactBox" id="<?php echo $projet->getCodeProjet()?>">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableEDF">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Prenom</th>
                    <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($tabContact as $contact) {
                    //$contact = ModelContact::select($IDContact);
                    if ($contact->getCodeEntite() != null) {
                        echo '<tr class="'.$projet->getCodeProjet().'">
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteContact" id="'.$contact->getCodeContact().'" href=""><i class="material-icons">delete</i></a></td>
                        </tr>';
                    }
                }
                ?>              
                </tbody>
            </table>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableAllEDF">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Prenom</th>
                    <th class="mdl-data-table__cell--non-numeric">Ajouter</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($allContactEDF as $contact) {
                    //$contact = ModelContact::select($IDContact);
                    if ($contact->getCodeEntite() != null) {
                        echo '<tr class="'.$projet->getCodeProjet().'">
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="addContact" id="'.$contact->getCodeContact().'" href=""><i class="material-icons">add</i></a></td>
                        </tr>';
                    }
                }
                ?>
                                
                </tbody>
            </table>
        </div>
        <div class="updateContactBox">
            <h5>Contacts du programme de financement</h5>
            <a href="index.php?controller=contact&action=create&codeSourceFin=<?php echo $projet->getCodeSourceFin() ?>" class="addNew">
                <i class="material-icons">add</i>
            </a>
        </div>
        <div class="updateContactBox" id="<?php echo $projet->getCodeProjet()?>">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableHorsEDF">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Prenom</th>
                    <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($tabContact as $contact) {
                    //$contact = ModelContact::select($IDContact);
                    if ($contact->getCodeEntite() == null) {
                        echo '<tr class="'.$projet->getCodeProjet().'">
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteContact" id="'.$contact->getCodeContact().'" href=""><i class="material-icons">delete</i></a></td>
                        </tr>';
                    }
                }
                ?>
                                
                </tbody>
            </table>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableAllHorsEDF">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Prenom</th>
                    <th class="mdl-data-table__cell--non-numeric">Ajouter</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($allContactHorsEDF as $contact) {
                    //$contact = ModelContact::select($IDContact);
                        echo '<tr class="'.$projet->getCodeProjet().'">
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="addContact" id="'.$contact->getCodeContact().'" href=""><i class="material-icons">add</i></a></td>
                        </tr>';
                }
                ?>
                                
                </tbody>
            </table>
        </div>

        <h5>Contacts Consortium</h5>
        <div class="updateContactBox" id="<?php echo $projet->getCodeProjet()?>">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableConsortium">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Nationalité</th>
                    <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($tabParticipant == false) {
                    echo '<tr class="'.$projet->getCodeProjet().'"></tr>';
                }else {
                    foreach ($tabParticipant as $participant) {
                        echo '<tr class="'.$projet->getCodeProjet().'">
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=participant&action=read&codeParticipant='.$participant->getCodeParticipant().'">'.$participant->getNomParticipant().'</a></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$participant->getNationalite().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteParticipant" id="'.$participant->getCodeParticipant().'" href=""><i class="material-icons">delete</i></a></td>
                        </tr>';
                    }
                }
                ?>
                                
                </tbody>
            </table>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users scroll" id="tableAllConsortium">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Nom</th>
                    <th class="mdl-data-table__cell--non-numeric">Nationalité</th>
                    <th class="mdl-data-table__cell--non-numeric">Ajouter</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($allParticipant as $participant) {
                    echo '<tr class="'.$projet->getCodeProjet().'">
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=participant&action=read&codeParticipant='.$participant->getCodeParticipant().'">'.$participant->getNomParticipant().'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'.$participant->getNationalite().'</td>
                        <td class="mdl-data-table__cell--non-numeric"><a class="addParticipant" id="'.$participant->getCodeParticipant().'" href=""><i class="material-icons">add</i></a></td>
                    </tr>';
                }
                ?>
                                
                </tbody>
            </table>
        </div>
        
        
            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeProjet" value="' . $_GET['codeProjet'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
