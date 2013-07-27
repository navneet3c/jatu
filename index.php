<?php
ini_set("use_cookies",1);
ini_set("use_only_cookies",1);
ini_set('session.save_path',"s");
session_name("PROXY_SESSION123");
session_start();
$username="jha";
$password="bc29b08213e84b61a4c0d088096c6ec8";
$initial="http://localhost";
$logged=0;

if(isset($_POST['lo'])){
	if($_POST['lo']==1){
		$logged=0;
		session_destroy();
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
//var_dump($url.$part,$_SERVER["QUERY_STRING"]);
$part='';
if($logged){
	if(isset($_GET['x'])){
		$u=urldecode($_GET['x']);
		if(filter_var($u,FILTER_VALIDATE_URL))
			$_SESSION['url']=$u;
	}
	if(isset($_SERVER["PATH_INFO"]))
		$part.=$_SERVER["PATH_INFO"];
	$_SESSION['part']=$part;
}
//echo addslashes($page);die();
if($part){ 
	require('proxy.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<title>Proxy Login</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<script type="text/javascript" src="script.js"></script>
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
				<input type="text" value="<?=$_SESSION['url']?>" id="ft" name="x" value="" placeholder="Enter URL">
				<input type="submit" value="Go" id="fs">
			</form>
			
		</div>
		
	</div>
	<div id="fd"><a id="ma" title="Show address bar"><img alt="out" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAAJiS0dEAP+Hj8y/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAByUlEQVQ4y5WSv2sUURDHP/N2nrsR9pSAQYNoimjAH8EmNhYixLQKqcQ/4QjptFHBX80lcEXSiEVqxVZtBRttBYtoZa5JIaKL3u3p3Y1F9ty9Y88jM9Wb9/nO+743T/h/KNM4MQAB4YeMEcRssCi9TODk6RheYF7eiok5cxZYUFeACA4wiQ6xTb51rfOB27yQYyCAoBHAHFWuEmP/cEfCfXnWhZhrMtnHgZDwdPgmtKFMwltRFCAVqbmWs8ACU/Pm62qeKpcB+EUrM9OWOpt/0l6FO7JCJNCS5zLLJUGZYhGA96zxJROk9rmTWo6nsskDZuSJCH7WN7z5n37Z4ws3LphpaU0rSkR4LrqCzuiOmu76MzqIrw3i+ShP6o6aNvS4Fp5IltzXIq4H9ejevjPyLAzhHVvSpi0bPCKx0FbthmV/pSR6BAkPaYqwbgkhK9ylxmgBdNGExwhtg2W5x0TfgFq5gg783rsPpyzO6459xr4FfUtSLhUMgrITJpge0TJgalhgwGGuE4vIQHcBxxwLkFGAkrDNCRxVzrNNIjbUfYELQMqnvHyT79iYfM2RXBCySoPuSLjJK87mRgE8F1niEGVTND7ykt3+8i9webEP7CLlvwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxMy0wNy0yN1QxNjoyNToxNyswNjowMI8zPJQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTMtMDctMjdUMTY6MjU6MTUrMDY6MDBp8ZUBAAAAAElFTkSuQmCC" /></a></div>
	
	<div id="f2"><iframe seamless id="fm" src="proxy.php"></iframe>
</body>
<?php } else { ?>
<body id="wbody">
	<div id="w">
		<form method="post" action="index.php" autocomplete="off">
			<input id="u" type="text" name="u" value="" placeholder="Username"><br />
			<input id="p" type="password" name="p" value="" placeholder="Password">
			<input type="submit" id="su" value="Start" name="loginSubmit" >
		</form>
	</div>
	
</body>
<?php } ?>
</html>
<?php } ?>