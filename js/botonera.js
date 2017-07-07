function cambiar_mes()
{
	$('#aumentar').click(function(){
		var mov= document. ;
		mov += 1;
		$('#btn input[name=count]').val(mov.attr('data-contar'));
		
		return false;
	});
	/*$('#disminuir').click(function(){
		var mov=0;
		mov -= 1;
		alert("por disminucion");

		return false;
	});*/
}

$(document).ready(cambiar_mes);