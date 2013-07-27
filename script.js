function g(v){ return document.getElementById(v)}
window.onload=function(){
	var x=g("mi")
	if(x) x.onclick=function(){ down("fu"); up("fd");}
	x=g("ma")
	if(x) x.onclick=function(){ down("fd"); up("fu");}
}
var de,ds,di,ue,us,ui
function down(id){
	de=g(id);
	di=0;
	ds=window.setInterval(function(){
		di-=5;
		if(di<-60){ window.clearInterval(ds); }
		else de.style.bottom=di+"px";
		},20)
}
function up(id){
	ue=g(id);
	ui=-60;
	us=window.setInterval(function(){
		ui+=3;
		if(ui>=-3){ ue.style.bottom="0px"; window.clearInterval(us); }
		else ue.style.bottom=ui+"px";
		},20)
}