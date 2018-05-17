<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div>
    <h5>Êtes-vous sûr de vouloir supprimer ce compte?</h5>
    <h5>
    <?php echo
    '<a href="index.php?controller=user&action=deleted&mailUser='.htmlspecialchars($user->getMailUser()).'"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Confirmer</button></a>';
    ?>
    </h5>
</div>