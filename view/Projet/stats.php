<div style="justify-content: center;">
    
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Créer un graphique</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="index.php?controller=projet&action=createBarGraph" class="horizontal">
                <div>
                    <label class="select" for="graph">Forme du diagramme</label>
                    <select required name="graph" id="graph">
                        <option value="pie">Circulaire</option>
                        <option value="bar">Barres verticales</option>
                    </select>
                </div>
                <div>
                <p>Créer un graphe sur</p>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="nbP">
                    <input type="radio" id="nbP" class="mdl-radio__button" name="data" value="1">
                    <span class="mdl-radio__label">Le nombre de projets</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="montant">
                    <input type="radio" id="montant" class="mdl-radio__button" name="data" value="2">
                    <span class="mdl-radio__label">Le montant des bugets ou subventions</span>
                </label>
                </div> 
                <div>
                <p>Quel(s) type(s) de projet</p>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="accepte">
                    <input type="checkbox" id="accepte" name="statut[]" value="Accepté" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Acceptés</span>
                </label>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="refuse">
                    <input type="checkbox" id="refuse" name="statut[]" value="Refusé" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Refusés</span>
                </label>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="depose">
                    <input type="checkbox" id="depose" name="statut[]" value="Déposé" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Déposés</span>
                </label>
                </div>
                <div>
                <p>Montant de</p>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="budgetTotal">
                    <input type="checkbox" id="budgetTotal" name="montant[]" value="budgetTotal" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Budget total</span>
                </label>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="budgetEDF">
                    <input type="checkbox" id="budgetEDF" name="montant[]" value="budgetEDF" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Budget EDF</span>
                </label>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="subventionTotal">
                    <input type="checkbox" id="subventionTotal" name="montant[]" value="subventionTotal" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Subvention totale</span>
                </label>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="subventionEDF">
                    <input type="checkbox" id="subventionEDF" name="montant[]" value="subventionEDF" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Subvention EDF</span>
                </label>
                </div>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="exceptionnel">
                    <input type="radio" id="exceptionnel" class="mdl-radio__button" name="exceptionnel" value="1">
                    <span class="mdl-radio__label">Projets exceptionnels</span>
                </label>
                <div>
                <p>Intervalle d'année</p>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="start" type="number" id="start">
                    <label class="mdl-textfield__label" for="start">Entre</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="end" type="number" id="end">
                    <label class="mdl-textfield__label" for="end">Et</label>
                </div>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="titre" type="text" id="titre">
                    <label class="mdl-textfield__label" for="titre">Titre du graphique</label>
                </div>
                
                
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>

<h3><a href="index.php?controller=entite&action=readAll">Voir les statistiques par entités</a></h3>

<h3>Le réseau Enfin c'est :</h3>
<div class="list">
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graphPie1"></div>
        </div>
        <button id="savePie1"></button>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graphBar1"></div>
        </div>
        <button id="saveBar1"></button>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graphBar2"></div>
        </div>
        <button id="saveBar2"></button>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graphBar4"></div>
        </div>
        <button id="saveBar4"></button>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graphBar5"></div>
        </div>
        <button id="saveBar5"></button>
    </div>
</div>

<h3>EDF R&D c'est :</h3>
<div class="list">
<div class="mdl-card mdl-shadow--2dp graph">
    <div class="mdl-card__supporting-text mdl-card--border">
        <div id="graphPie2"></div>
    </div>
    <button id="savePie2"></button>
</div>
<div class="mdl-card mdl-shadow--2dp graph">
    <div class="mdl-card__supporting-text mdl-card--border">
        <div id="graphPie3"></div>
    </div>
    <button id="savePie3"></button>
</div>
</div>
</div>
<a href="index.php?controller=enseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>


