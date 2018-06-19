<h2>Calendrier</h2>
<div class="horizontal">
    <?php
        foreach ($dates as $value) {
            list($year, $month, $day) = explode('-', $value->getDateDeadLine());
            $tab = ModelDeadLine::selectByDate($value->getDateDeadLine());
            echo '<div class="demo-card-square mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                        <h2 class="mdl-card__title-text">'.$day.'/'.$month.'/'.$year.'</h2>
                    </div>
                  <div class="mdl-card__actions mdl-card--border">';
            foreach ($tab as $deadLine) {
                $projet = ModelProjet::select($deadLine->getCodeProjet());
                if ($deadLine->getDateDeadLine() == $value->getDateDeadLine()) {
                    echo '
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=projet&action=read&codeProjet='.$deadLine->getCodeProjet().'">'.htmlspecialchars($projet->getNomProjet()).'</a> - '.htmlspecialchars($deadLine->getNomDeadLine()).'<a class="deleteDate" id="'.$deadLine->getCodeDeadLine().'" href=""><i class="material-icons">delete</i></a> ';
                }
            }
            echo '</div>
            </div>';
        }
    ?>
    
</div>