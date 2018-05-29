$(function(){
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
                if(data=='true'){
                	window.alert('OK');
                }else{
                	window.alert(data);
                }
            }

        });
	});

	$(document).on('change', '#codeEntite', function() {
		var isRD = $('#isRD');
		var selectedOption = $('#codeEntite option:selected').val();
		if(selectedOption == 15) {
	    	isRD.css("display", "block");
	    } else {
	    	isRD.css("display", "none");
	    }
	});

	$(document).on('change', '#isEDF', function() {
		var membreEDF = $('#membreEDF');
		var isRD = $('#isRD')
		var notMembre = $('#notMembre');
		if($(this).is(':checked')) {
	    	notMembre.css("display", "none");
			membreEDF.css("display", "block");
	    } else {
	    	isRD.css("display", "none");
	    	membreEDF.css("display", "none");
			notMembre.css("display", "block");
	    }
	});

	$(document).on('click','.deleteDate',function(){
        var codeDeadLine = $(this).attr('id');
        $.ajax({
            type:'POST',
            url:'index.php?controller=deadLine&action=delete',
            data:{'codeDeadLine':codeDeadLine},
            success: function(data){
                if(data=='true'){
                    window.alert('EHOH');;
                }else{
                 	window.alert(codeDeadLine);
                }
             }

        });
    });

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

    $(document).on('click','.deleteParticipant',function(){
        var classParticipant = $(this).attr('class');
        var codeParticipant = classContact.split(' ')[1];
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

    $(document).on('click','.addParticipant',function(){
        var classParticipant = $(this).attr('class');
        var codeParticipant = classContact.split(' ')[1];
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