$(function(){
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

    $(document).on('click','.deleteContact',function(){
        var codeContact = $(this).attr('id');
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=implication&action=delete',
            data:{'codeContact':codeContact, 'codeProjet':codeProjet},
            success: function(data){
                 if(data!=null){
                    row.fadeOut().remove();
                 }else{
                 	window.alert('error');
                 }
             }

            });
        });

    $(document).on('click','.addContact',function(){
        var codeContact = $(this).attr('id');
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=implication&action=add',
            data:{'codeContact':codeContact, 'codeProjet':codeProjet},
            success: function(data){
                 if(data!=null){
                    row.fadeOut().remove();
                 }else{
                 	window.alert('error');
                 }
             }

            });
        });

    $(document).on('click','.deleteParticipant',function(){
        var codeParticipant = $(this).attr('id');
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=participation&action=delete',
            data:{'codeProjet':codeProjet, 'codeParticipant':codeParticipant},
            success: function(data){
                 if(data=="YES"){
                    row.fadeOut().remove();
                 }else{
                 	window.alert('error');
                 }
             }

            });
        });

    $(document).on('click','.addParticipant',function(){
        var codeParticipant = $(this).attr('id');
        var row = $(this).parent().parent();
        var codeProjet = row.attr('class');
        $.ajax({
            type:'POST',
            url:'index.php?controller=participation&action=add',
            data:{'codeProjet':codeProjet, 'codeParticipant':codeParticipant},
            success: function(data){
                 if(data=="YES"){
                    row.fadeOut().remove();
                 }else{
                 	window.alert('error');
                 }
             }

            });
        });
});