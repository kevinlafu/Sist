function mouseOver(c)
{
	document.getElementById("b"+ c).src ="../img/crear-evento-hover.gif";
}

function mouseOut(c)
{
	document.getElementById("b"+ c).src ="../img/agendaico.png";
}

function aumentar(c)
{
	document.getElementById("count").value=c+1;
}

function disminuir(c)
{
	document.getElementById("count").value=c-1;
}