
var cle;
 function detect(Event) {
  // Event appears to be passed by Mozilla
  // IE does not appear to pass it, so lets use global var
  if(Event==null) {
  		alert('null');
  		Event=event;
  		}
  cle = Event.keyCode;
 }
 
 function chang(Event,quoi) {
 detect(Event);
 setTimeout('cle=""',100);
 if(cle=='13')
  while(quoi!=null) 
 	{
 	quoi = quoi.nextSibling;
 	if(quoi.tagName=='INPUT') 
 		{
 		quoi.focus();
 		// quoi.select();
 		quoi=null;
 		}
 	}
 }
  
 function ok() {
 if(cle != '13') return true;
 else return false;
 }
function newWindow(){
	window.open('http://localhost','mywindow','width=400,height=200')
}
function goTo(){
	window.location="http://localhost";
}