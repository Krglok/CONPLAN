function openHelp (link) {
	var Fenster
	var ns4up = (document.layers) ? 1 : 0
	var ie4up = (document.all) ? 1 : 0
	var xsize = (window.pageXOffset + window.innerWidth)
	/*var xsize = screen.width */
	var ysize = screen.height
	var breite=400 /*xsize/3*/
	var hoehe=(ysize - 150)
	var xpos= (window.innerWidth - 250)  /* (xsize-breite-30)*/
	var ypos=0 /*(ysize-hoehe-50) */
/*	Fenster = window.open("pages/slogin.html", helpText, "width=600,height=300,left=100, top=100");*/
/* screenX="+xpos+",screenY="+ypos+",*/	
	Fenster=window.open(link,"HilfeSystem","scrollbars=no,status=no,toolbar=no,location=no,directories=no,resizable=yes,menubar=no,width="+breite+",height="+hoehe+",top="+ypos+",left="+xpos);
	Fenster.focus();
/*	
  alert("Name des kleinen Fensters: " + Fenster.name);
  neu = prompt("Vergeben Sie einen neuen Fensternamen", "Name");
  Fenster.name = neu;
  alert("Der Name des Fensters lautet jetzt: " + Fenster.name);
*/  
}

function opwin() {
var wstat
var ns4up = (document.layers) ? 1 : 0
var ie4up = (document.all) ? 1 : 0
var xsize = window.pageXOffset + window.innerWidth
var ysize = screen.height
var breite=600 /*xsize/3*/
var hoehe=300 /*ysize/3*/
var xpos=(xsize-breite)/2
var ypos=(ysize-hoehe)/2
	wstat=window.open("pages/slogin.html","","scrollbars=no,status=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos)
}
