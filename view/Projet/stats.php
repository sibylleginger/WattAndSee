<div style="justify-content: center;">
    
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Créer un graphique</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="index.php?controller=projet&action=createBarGraph" class="horizontal">
                <div>
                    <div>
                        <label class="select" for="type">Forme du diagramme</label>
                        <select required name="type" id="type">
                            <option value="pie">Circulaire</option>
                            <option value="serial">Barres verticales</option>
                        </select>
                    </div>
                    <div>
                        <label class="select" for="data">Créer un graphe sur</label>
                        <select required name="data" id="data">
                            <option value="1">Le nombre de projets</option>
                            <option value="2">Le montant des budgets ou subventions</option>
                        </select>
                    </div>
                    <div>
                        <label class="select" for="xAxis">Valeurs de l'axe X</label>
                        <select required name="xAxis" id="xAxis">
                            <option value="1">Statuts des projets</option>
                            <option value="2" class="optionPie">Entités</option>
                            <option value="3" class="optionPie">Programmes</option>
                            <option value="4" class="optionBar">Années</option>
                        </select>
                    </div>
                </div>
                <div id="checkboxStatut">
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
                <div id="radioStatut">
                <p>Quel(s) type(s) de projet</p>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="accepte">
                    <input type="radio" id="accepte" class="mdl-radio__button" name="statut" value="Accepté">
                    <span class="mdl-radio__label">Acceptés</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="refuse">
                    <input type="radio" id="refuse" class="mdl-radio__button" name="statut" value="Refusé">
                    <span class="mdl-radio__label">Refusés</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="depose">
                    <input type="radio" id="depose" class="mdl-radio__button" name="statut" value="Déposé">
                    <span class="mdl-radio__label">Déposés</span>
                </label>
                </div>
                <div id="divMontant">
                    <div id="checkboxMontant">
                        <p>Montant de</p>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="budgetTotal1">
                            <input type="checkbox" id="budgetTotal1" name="montant[]" value="budgetTotal" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Budget total</span>
                        </label>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="budgetEDF1">
                            <input type="checkbox" id="budgetEDF1" name="montant[]" value="budgetEDF" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Budget EDF</span>
                        </label>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="subventionTotal1">
                            <input type="checkbox" id="subventionTotal1" name="montant[]" value="subventionTotal" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Subvention totale</span>
                        </label>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="subventionEDF1">
                            <input type="checkbox" id="subventionEDF1" name="montant[]" value="subventionEDF" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Subvention EDF</span>
                        </label>
                    </div>
                    <div id="radioMontant">
                        <p>Montant de</p>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="budgetTotal2">
                            <input type="radio" id="budgetTotal2" name="montant" value="budgetTotal" class="mdl-radio__button">
                            <span class="mdl-radio__label">Budget total</span>
                        </label>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="budgetEDF2">
                            <input type="radio" id="budgetEDF2" name="montant" value="budgetEDF" class="mdl-radio__button">
                            <span class="mdl-radio__label">Budget EDF</span>
                        </label>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="subventionTotal2">
                            <input type="radio" id="subventionTotal2" name="montant" value="subventionTotal" class="mdl-radio__button">
                            <span class="mdl-radio__label">Subvention totale</span>
                        </label>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="subventionEDF2">
                            <input type="radio" id="subventionEDF2" name="montant[]" value="subventionEDF" class="mdl-radio__button">
                            <span class="mdl-radio__label">Subvention EDF</span>
                        </label>
                    </div>
                </div>
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
                <div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="titre" type="text" id="titre">
                    <label class="mdl-textfield__label" for="titre">Titre du graphique</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="yAxis" type="text" id="yAxis">
                    <label class="mdl-textfield__label" for="yAxis">Titre axe Y</label>
                </div>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="exceptionnel">
                    <input type="radio" id="exceptionnel" class="mdl-radio__button" name="exceptionnel" value="1">
                    <span class="mdl-radio__label">Projets exceptionnels</span>
                </label>
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
            <div id="graph1" class="graph"></div>
        </div>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graph2" class="graph"></div>
        </div>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graph3" class="graph"></div>
        </div>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graph4" class="graph"></div>
        </div>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graph5" class="graph"></div>
        </div>
    </div>
    <div class="mdl-card mdl-shadow--2dp graph">
        <div class="mdl-card__supporting-text mdl-card--border">
            <div id="graph6" class="graph"></div>
        </div>
    </div>
</div>

<h3>EDF R&D c'est :</h3>
<div class="list">
<div class="mdl-card mdl-shadow--2dp graph">
    <div class="mdl-card__supporting-text mdl-card--border">
        <div id="graph7" class="graph"></div>
    </div>
</div>
<div class="mdl-card mdl-shadow--2dp graph">
    <div class="mdl-card__supporting-text mdl-card--border">
        <div id="graph8" class="graph"></div>
    </div>
</div>
</div>
</div>
<a href="index.php?controller=enseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>


