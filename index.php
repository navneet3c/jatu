<?php
ini_set("use_cookies",1);
ini_set("use_only_cookies",1);
ini_set('session.save_path',"s");
session_name("PROXY_SESSION123");
session_set_cookie_params(0,"/");
session_start();
$username="jha";
$password="bc29b08213e84b61a4c0d088096c6ec8";
$initial="http://localhost";
$logged=0;

if(isset($_POST['lo'])){
	if($_POST['lo']==1){
		$logged=0;
		setcookie(session_name(),"",time()-10000);
		session_destroy();
		if(file_exists("s/c.dat")) unlink("s/c.dat");
		session_start();
	}
}else if(isset($_SESSION['logged'])){
	$logged=1;
}else if(isset($_POST['loginSubmit'])){
	try{
		if(!isset($_POST['u'],$_POST['p']))
			throw new Exception();
		if($username!=$_POST['u'] || $password!=md5($_POST['p']))
			throw new Exception();
		$_SESSION['logged']=1;
		$_SESSION['url']=$initial;
		$logged=1;
	}catch(Exception $e){
		$logged=0;
	}
}
$part='';
if($logged){
	if(isset($_GET['x'])){
		$u=urldecode($_GET['x']);
		if(filter_var($u,FILTER_VALIDATE_URL))
			$_SESSION['url']=$u;
		$_SERVER["QUERY_STRING"]='';
	}
	if(isset($_SERVER["PATH_INFO"]))
		$part.=$_SERVER["PATH_INFO"];
	$_SESSION['part']=$part;
	if($_SERVER["QUERY_STRING"])
		$part.='?'.$_SERVER["QUERY_STRING"];
	$_SESSION['part']=$part;
}
if($part!='?' && $part!=''){ 
	require('proxy.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<title>Proxy</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<style type="text/css">
html{height:100%;width:100%;margin:0px;padding:0px;border:0px;}
#wbody{background-color:#dedede;width:100%;margin: 0px; padding: 0px}
#w{margin: 0 auto;margin-top:10%;width: 30%; border-radius:20px; border: 5px solid rgba(255,255,255,0.3); box-shadow: 0px 0px 100px 10px #555;background-color:rgba(100,100,100,0.5); padding: 30px;text-align:center}
#u,#p{padding: 10px;font-size:14px;border-radius:50px; border: 2px solid #666;width:70%;margin: 15px;background-color:#efefef;box-shadow: 0px 0px 15px #888 inset;text-align:center;-webkit-transition:background-color linear 0.2s,box-shadow linear 0.2s;transition:background-color linear 0.2s,box-shadow linear 0.2s}
#u:hover,#p:hover{box-shadow:none;-webkit-transition:box-shadow linear 0.2s;transition:box-shadow linear 0.2s}
#u:focus,#p:focus{background-color:#fefefe;-webkit-transition:background-color linear 0.1s;transition:background-color linear 0.1s}
#su{padding: 7px 30px;font-size:12px;border-radius:10px; border: 1px solid #555;margin: 20px;background-color:#777;cursor:pointer;color:#fff;opacity:0.8}
#su:hover,#su:focus{box-shadow:0px 0px 10px #ccc; opacity:1}
#fbody{width:100%;margin: 0px; padding: 0px;height:100%;}
#fu,#fd{box-shadow: 0px 0px 10px #000;border-radius:10px 10px 0px 0px;position:fixed;bottom:0px;left:0px;margin:0px;}
#fu{height:30px;width:100%;background-color:#efefef;padding:5px;}
#mi,#ma{cursor:pointer;width:24px;height:24px;opacity:0.4;-webkit-transition:opacity linear 0.2s;transition:opacity linear 0.2s}
#mi{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAAJiS0dEAP+Hj8y/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAB60lEQVQ4y5WUvWtUQRTFf/e9mXmPqBsUxBRCLIxCInaClSiCjYWCpYVYWalNtAoWJoVEJJhg7z8gaBPBIAhqYxBs1UYTDOKGkH0bssmafcdiN9m3MRvIuQwM955zP2aGMdro4zJDGP/DqPCGT/wtOoeYZhV1sQbz3CVp0w/zuit505a5Dq5ZkYucB3K+MMsfGh3tlDjJOfbTyw2mWz57YDLZZxu0yDrGMMzsgD2yhsl+Wn+05QeY5Su5UEEgJKq8ZLnJiopzb2umiAVqzY1rpwcakO94quSbZSP2iD0Lii1V9R0cJIj6RmdLnQLAqPHQXgAlhiWexFmjewWgwihTtk6JEd0B9TAaZTld4HB9rsfhSm48rsWKFC3apagYP+rmndyc6y862/SaPbaSFWJ+0P12cnPuGOmF5FS6nT5epHs8/ppf8fLz/rjTFZ3Jb/GDEd0mFaxpijHLXMoAaeu6+rnHPiCjRpjw8h/c83i1nT0mSZPh8CsshnIoh3JYCQoKCk+Dx094OcUq0tM0uZ9kibbZu+REghPQWuuaZMyqwXTVblKlUri5KjM84xu4LTpa4hXVGMEMHzveOGywRH0NIJ6IFSmSyWTvOb3TH1BEHJ3VABVlZGQ6xBHeUt9NYNFBelGzvoycBTZ2E/wDrpHYJtTBA/EAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTMtMDctMjdUMTY6MzI6MTUrMDU6MDApS0bqAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEzLTA3LTI3VDE2OjMyOjE1KzA1OjAwWBb+VgAAAABJRU5ErkJggg==");
float:left;margin:5px 0px;}
#mi:hover,#ma:hover{opacity:1.0; -webkit-transition:opacity linear 0.4s;transition:opacity linear 0.4s}
#fd{background-color:#efefef;padding:8px;height:30px;bottom:-60px}
#f2{overflow:auto;height:100%;}
#fm{width:100%;height:100%;border:0px;margin:0px;padding:0px;}
#fo{padding-left:10px}
#lo{float:right;background-color:#444;border:1px solid #666;border-radius:5px;padding:2px 4px;color:#fff;cursor:pointer;margin:4px 0px}
#ft{padding: 3px;font-size:12px;border-radius:5px; border: 2px solid #aaa;background-color:#f9f9f9;margin:4px 0px;width:80%}
#ft:focus{background-color:#fff}
#fs{background-color:#999;border:2px solid #777;border-radius:5px;padding:2px 6px;color:#fff;cursor:pointer}
#cn{float:right;cursor:crosshair;font-size:10px;font-family:Courier;margin:20px 0px;padding-right:10px;}
#cn .b{color:#000}#cn .w{color:#666;}
</style>
<script type="text/javascript">
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
</script>
</head>
<?php if($logged) { ?>
<body id="fbody">
	<div id="fu">
		<div id="cn" draggable="true"><span class="w">Code</span><span class="b">Navo</span></div>
		<a id="mi" title="Minimize address bar"></a>
		<div id="fo">
			<form action="index.php" method="post">
				<input type="hidden" value="1" name="lo">
				<input type="submit" id="lo" value="Logout">
			</form>
			<form action="index.php" method="get">
				&nbsp;&nbsp;<input type="text" value="<?=$_SESSION['url']?>" id="ft" name="x" value="" placeholder="Enter URL">&nbsp;<input type="submit" value="Go" id="fs">
			</form>
			
		</div>
		
	</div>
	<div id="fd"><a id="ma" title="Show address bar"><img alt="out" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAAJiS0dEAP+Hj8y/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAByUlEQVQ4y5WSv2sUURDHP/N2nrsR9pSAQYNoimjAH8EmNhYixLQKqcQ/4QjptFHBX80lcEXSiEVqxVZtBRttBYtoZa5JIaKL3u3p3Y1F9ty9Y88jM9Wb9/nO+743T/h/KNM4MQAB4YeMEcRssCi9TODk6RheYF7eiok5cxZYUFeACA4wiQ6xTb51rfOB27yQYyCAoBHAHFWuEmP/cEfCfXnWhZhrMtnHgZDwdPgmtKFMwltRFCAVqbmWs8ACU/Pm62qeKpcB+EUrM9OWOpt/0l6FO7JCJNCS5zLLJUGZYhGA96zxJROk9rmTWo6nsskDZuSJCH7WN7z5n37Z4ws3LphpaU0rSkR4LrqCzuiOmu76MzqIrw3i+ShP6o6aNvS4Fp5IltzXIq4H9ejevjPyLAzhHVvSpi0bPCKx0FbthmV/pSR6BAkPaYqwbgkhK9ylxmgBdNGExwhtg2W5x0TfgFq5gg783rsPpyzO6459xr4FfUtSLhUMgrITJpge0TJgalhgwGGuE4vIQHcBxxwLkFGAkrDNCRxVzrNNIjbUfYELQMqnvHyT79iYfM2RXBCySoPuSLjJK87mRgE8F1niEGVTND7ykt3+8i9webEP7CLlvwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxMy0wNy0yN1QxNjoyNToxNyswNjowMI8zPJQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTMtMDctMjdUMTY6MjU6MTUrMDY6MDBp8ZUBAAAAAElFTkSuQmCC" /></a></div>
	
	<div id="f2" style="overflow:hidden"><iframe seamless="seamless" id="fm" src="proxy.php"></iframe></div>
</body>
<?php } else { ?>
<body id="wbody">
	<div id="w">
		<form method="post" action="index.php" autocomplete="off">
			<input id="u" type="text" name="u" value="" placeholder="Username"><br />
			<input id="p" type="password" name="p" value="" placeholder="Password"><br />
			<input type="submit" id="su" value="Start" name="loginSubmit" >
		</form>
	</div>
	
</body>
<?php } ?>
</html>
<?php } ?>