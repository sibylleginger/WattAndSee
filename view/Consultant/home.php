<div class="detailBatiment1" style="justify-content: center;">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Régler les différentes erreurs</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="index.php?controller=extraction&action=readAllType">
                <label class="select">Type d'erreur</label>
                <select style="display: block;" required name="typeErreur">
                    <option value="statut">Statut</option>
                    <option value="departementEns">Département Enseignant</option>
                    <option value="Département invalide">Département invalide</option>
                    <option value="autre">Autre</option>
                </select>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>
</div>