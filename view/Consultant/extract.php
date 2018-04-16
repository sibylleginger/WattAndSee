<form enctype="multipart/form-data" action="index.php?controller=extraction&action=extracted" method="post">


    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Importation des données</h2>
        </div>
        <div class="mdl-card__supporting-text">
                <div class="file_input_div">
                    <div class="file_input">
                        <label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-button--colored">
                            <i class="material-icons">file_upload</i>
                            <input id="file_input_file" class="none" type="file" name="extract" required/>
                        </label>
                    </div>
                    <div id="file_input_text_div" class="mdl-textfield mdl-js-textfield textfield-demo">
                        <input class="file_input_text mdl-textfield__input" type="text" disabled readonly
                               id="file_input_text"/>
                        <label class="mdl-textfield__label" for="file_input_text"></label>
                    </div>
                </div>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <button type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Send
            </button>
        </div>
    </div>

</form>

<script src="./style/file.js"></script>