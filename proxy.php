<?php
if(!session_id()){
	session_name("PROXY_SESSION123");
	ini_set("use_cookies",1);
	ini_set("use_only_cookies",1);
	ini_set('session.save_path',"s");
	session_start();
}
if(!$_SESSION['logged']) die();
$url=$_SESSION['url'];
$old=$_SESSION['url'];
if(!isset($part)) $part='';
else{
	$site=strrpos($url,'?');
	if($site!==false)
		$url=substr($url,0,strrpos($url,'?'));
	$site=strrpos(trim($url,"/"),'/',7);
	if($site!==false && strpos($url,'.',$site)!==false){
		$url=substr($url,0,strrpos($url,'/'));
	}
}
$site=trim('http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]," \n\r\0/");
$site=substr($site,0,strrpos($site,'/'));
$curl=curl_init();
curl_setopt_array($curl,array(
	CURLOPT_URL=>$url.$part,
	CURLOPT_BINARYTRANSFER=>true,
	CURLOPT_RETURNTRANSFER=>true,
	CURLOPT_REFERER=>"",
	CURLOPT_USERAGENT=>$_SERVER["HTTP_USER_AGENT"],
	CURLOPT_FOLLOWLOCATION=>true,
	CURLOPT_COOKIEJAR=>"s/c.dat",
	CURLOPT_COOKIEFILE=>"s/c.dat"
));
if($_POST){
	curl_setopt($curl,CURLOPT_POST,1);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$_POST);
}
$page=curl_exec($curl);
$resp=curl_getinfo($curl,CURLINFO_HTTP_CODE);
$type=curl_getinfo($curl,CURLINFO_CONTENT_TYPE);
curl_close($curl); 
//global
/*$res=trim($_SERVER["PHP_SELF"],'/');
$res=substr($res,0,strrpos($res,'/')+1);
$page=preg_replace('/src\s*=\s*(\"|\\\')?(?!http:)/','src=${1}/'.$res,$page);*/
$page=preg_replace('/(bgimage|src|href)\s*=\s*(\"|\\\')?\//','${1}=${2}./',$page);
$page=preg_replace('/url\s*\(\s*(\"|\\\')?\//','url(${1}./',$page);

$page=str_replace($old,$site,$page);

header("Content-Type: ".$type);
echo $page; 
?>