<div class="detailProjet">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle.' <a href="index.php?controller=projet&action=read&codeProjet='.$projet->getCodeProjet().'">'.$projet->getNomProjet() ?></a></h2>
        </div>
        <div >
        <div class="updateContactBox">
            <h5>Contacts EDF</h5>
            <a href="index.php?controller=contact&action=create&codeProjet=<?php echo $projet->getCodeProjet()?>" class="addNew">
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
                    <th class="mdl-data-table__cell--non-numeric">Chef</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($tabContact as $contact) {
                    //$contact = ModelContact::select($IDContact);
                    if ($contact->getCodeEntite() != null) {
                        echo '<tr class="'.$projet->getCodeProjet().'"';
                        if ($chef && $contact->getCodeContact() == $chef->getCodeContact()) {
                            echo ' style="background-color: #b9e2f7;"';
                        }
                        echo '>
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.$contact->getCodeContact().'">'.$contact->getNomContact().'</a></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$contact->getPrenomContact().'</td>
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteContact '.$contact->getCodeContact().'" href=""><i class="material-icons">delete</i></a></td>
                            <td class="mdl-data-table__cell--non-numeric">';
                        if (!$chef || $contact->getCodeContact() != $chef->getCodeContact()) {
                            echo '<a class="setAsChef" href="index.php?controller=implication&action=setChef&codeProjet='.$projet->getCodeProjet().'&codeContact='.$contact->getCodeContact().'"><i class="material-icons">radio_button_unchecked</i></a>';
                        }else {
                            echo '<a class="setAsChef" href="index.php?controller=implication&action=setChef&codeProjet='.$projet->getCodeProjet().'&codeContact='.$contact->getCodeContact().'"><i class="material-icons">radio_button_checked</i></a>';
                        }
                        echo '</td>
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
                            <td class="mdl-data-table__cell--non-numeric"><a class="addContact '.$contact->getCodeContact().'" href=""><i class="material-icons">add</i></a></td>
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
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteContact '.$contact->getCodeContact().'" href=""><i class="material-icons">delete</i></a></td>
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
                            <td class="mdl-data-table__cell--non-numeric"><a class="addContact '.$contact->getCodeContact().'" href=""><i class="material-icons">add</i></a></td>
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
                            <td class="mdl-data-table__cell--non-numeric"><a class="deleteParticipant '.$participant->getCodeParticipant().'" href=""><i class="material-icons">delete</i></a></td>
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
                        <td class="mdl-data-table__cell--non-numeric"><a class="addParticipant '.$participant->getCodeParticipant().'" href=""><i class="material-icons">add</i></a></td>
                    </tr>';
                }
                ?>
                                
                </tbody>
            </table>
        </div>
        </div>
    </div>
