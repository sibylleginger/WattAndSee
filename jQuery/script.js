$(function(){

    $(function() {
        var optionsBar = $('.optionsBar').toArray();
        var optionsPie = $('.optionsPie').toArray();
        var optionsType = $('#type');
        var divMontant = $('#divMontant');
        var optionsData = $('#data');
        exceptionnel.hide();
        divMontant.hide();
        optionsType.change(function() {
            if(optionsType.val() == 'pie') {
                    optionsBar.hide();
                
                    optionsPie.show();
                
            }else {
                    optionsPie.hide();
                
                    optionsBar.show();
                
            }
        });
        optionsData.change(function(){
            if(optionsData.val() == 2) {
                divMontant.show();
                exceptionnel.show();
            }else {
                divMontant.hide();
                exceptionnel.hide();
            }
        });
    });

    /*
     * Modifie le rôle de chef de projet selon la valeur initiale du contact dont le code est l'attribut classe de l'objet, impliqué dans le projet dont le code est l'attribut classe de la ligne
     * Changes the role of project leader of the contact whose id is in the object's class attribute, involved in the project of which the id is the row's class attribute
     * 
     * Appelle l'action setChef du ControllerImplication
     * Calls the setChef action from ControllerImplication
    */
	$(document).on('click','.setAsChef', function() {
		var classContact = $(this).attr('class');
        var codeContact = classContact.split(' ')[1];
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
		$.ajax({
            type:'POST',
            url:'index.php?controller=implication&action=setChef',
            data:{'codeContact':codeContact,'codeProjet':codeProjet},
            success: function(data){
                if(data!='true'){
                	window.alert('data');
                }
            }

        });
	});

	$(document).on('click','.deleteDate',function(){
        var codeDeadLine = $(this).attr('id');
        $.ajax({
            type:'POST',
            url:'index.php?controller=deadLine&action=delete',
            success: function(data){
                var tabProjet = data;    
            }

        });
    });

    /*
     * Supprime le contact, dont le code est l'attribut classe de l'objet, du projet dont le code est l'attribut classe du corps du tableau
     * Deletes the contact, whose id is in the object's class attribute, from the project of which the id is the table's body's class attribute
     * 
     * Appelle l'action delete du ControllerImplication
     * Calls the delete action from ControllerImplication
    */
    $(document).on('click','.deleteContact',function(){
        var classContact = $(this).attr('class');
        var codeContact = classContact.split(' ')[1];
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=implication&action=delete',
            data:{'codeContact':codeContact,'codeProjet':codeProjet},
            success: function(data){
                 if(data=='true'){
                    row.fadeOut().remove();
                 }else{
                 	window.alert(data);
                 }
             }

        });
    });

    /*
     * Ajoute le contact, dont le code est l'attribut classe de l'objet, au projet dont le code est l'attribut classe du corps du tableau
     * Adds the contact, whose id is in the object's class attribute, to the project of which the id is the table's body's class attribute
     * 
     * Appelle l'action add du ControllerImplication
     * Calls the add action from ControllerImplication
    */
    $(document).on('click','.addContact',function(){
        var classContact = $(this).attr('class');
        var codeContact = classContact.split(' ')[1];
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=implication&action=add',
            data:{'codeContact':codeContact,'codeProjet':codeProjet},
            success: function(data){
                 if(data=="true"){
                    row.fadeOut().remove();
                 }else{
                 	window.alert(data);
                 }
            }

        });
    });

    /*
     * Supprime le contact, dont le code est l'attribut classe de l'objet, du programme de financement
     * Deletes the contact, whose id is in the object's class attribute, from the funding program 
     * 
     * Appelle l'action updateSourceFin du ControllerContact
     * Calls the updateSourceFin action of ControllerContact
    */
    $(document).on('click','.deleteContactSource',function(){
        var classContact = $(this).attr('class');
        var codeContact = classContact.split(' ')[1];
        var row = $(this).parent().parent();
        var codeSource = null;
        $.ajax({
            type:'POST',
            url:'index.php?controller=contact&action=updateSourceFin',
            data:{'codeContact':codeContact,'codeSourceFin':codeSource},
            success: function(data){
                 if(data=='true'){
                    row.fadeOut().remove();
                 }else{
                    window.alert(data);
                 }
             }

        });
    });

    /*
     * Ajoute le contact, dont le code est l'attribut classe de l'objet, au programme dont le code est l'attribut classe du corps du tableau
     * Adds the contact, whose id is in the object's class attribute, to the program of which the id is the table's body's class attribute
     * 
     * Appelle l'action updateSourceFin du ControllerContact
     * Calls the updateSourceFin action of ControllerContact
    */
    $(document).on('click','.addContactSource',function(){
        var classContact = $(this).attr('class');
        var codeContact = classContact.split(' ')[1];
        var row = $(this).parent().parent();
        var codeSource = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=contact&action=updateSourceFin',
            data:{'codeContact':codeContact,'codeSourceFin':codeSource},
            success: function(data){
                 if(data=="true"){
                    row.fadeOut().remove();
                 }else{
                    window.alert(data);
                 }
             }

        });
    });

    /*
     * Supprime le participant, dont le code est l'attribut classe de l'objet, du projet dont le code est l'attribut classe du corps du tableau
     * Deletes the participant, whose id is in the object's class attribute, to the project of which the id is the table's body's class attribute
     * 
     * Appelle l'action delete du ControllerParticipation
     * Calls the delete action from ControllerParticipation
    */
    $(document).on('click','.deleteParticipant',function(){
        var classParticipant = $(this).attr('class');
        var codeParticipant = classParticipant.split(' ')[1];
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=participation&action=delete',
            data:{'codeProjet':codeProjet, 'codeParticipant':codeParticipant},
            success: function(data){
                 if(data=="true"){
                    row.fadeOut().remove();
                 }else{
                 	window.alert(data);
                 }
             }

        });
    });

    /*
     * Ajoute le participant, dont le code est l'attribut classe de l'objet, au projet dont le code est l'attribut classe du corps du tableau
     * Adds the participant, whose id is in the object's class attribute, to the project of which the id is the table's body's class attribute
     * 
     * Appelle l'action add du ControllerParticipation
     * Calls the add action from ControllerParticipation
    */
    $(document).on('click','.addParticipant',function(){
        var classParticipant = $(this).attr('class');
        var codeParticipant = classParticipant.split(' ')[1];
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=participation&action=add',
            data:{'codeProjet':codeProjet, 'codeParticipant':codeParticipant},
            success: function(data){
                 if(data=="true"){
                    row.fadeOut().remove();
                 }else{
                 	window.alert(data);
                 }
             }

        });
    });
});