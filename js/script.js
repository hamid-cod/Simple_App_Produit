
$(document).ready(function(){
	var multiplicande  = $('#multiplicande').val();
	var multiplicateur = $('#multiplicateur').val();
	var produit = multiplicande * multiplicateur;

	var length_input = $('input:visible[class=val]').length;
	$('input:visible[class=val]').attr('maxlength','1');
	$('#input1').focus();
	$(".val").keyup(function(e){
		var i = parseInt($(this).attr("id").replace("input", ""));
		if ($('#input'+i).val() >= 0 && $('#input'+i).val() <= 9 && $('#input'+i).val() != '' && e.which != 32 && e.which != 9) {
			if (i == length_input) {
				$('input:visible[class=val]').blur(); 
			}
			else { $('#input'+(i+1)).focus(); }
		}
	});
	$('#corriger').click(function() {
		var x = $('#resultat').find('input').length-1;
		var p = 0;
		for (var i = 0; i <= x; i++) {
			p += $('#resultat').find('input').eq(i).val()*Math.pow(10,x-i);
		}
		if (p == produit) {
			Swal.fire({icon: 'success',title: 'Vrai'});
		}
		else {
			Swal.fire({icon: 'error',title: 'Fausse'});
		}
	});
});