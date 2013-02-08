function openHelp () {
	var Fenster
	var ns4up = (document.layers) ? 1 : 0
	var ie4up = (document.all) ? 1 : 0
	var xsize = screen.width
	var ysize = screen.height
	var breite=300 /*xsize/3*/
	var hoehe=ysize/2
	var xpos=(xsize-breite-30)
	var ypos=0 /*(ysize-hoehe-50) */
/*	Fenster = window.open("pages/slogin.html", helpText, "width=600,height=300,left=100, top=100");*/
	Fenster=window.open("pages/help.html","HilfeSystem","scrollbars=no,status=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos)
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
var xsize = screen.width
var ysize = screen.height
var breite=600 /*xsize/3*/
var hoehe=300 /*ysize/3*/
var xpos=(xsize-breite)/2
var ypos=(ysize-hoehe)/2
	wstat=window.open("pages/slogin.html","","scrollbars=no,status=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos)
}
