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
if(strrpos($url,'.php')!==false){
	$url=trim(substr($url,0,strrpos($url,'/')),"/");
	$query=strrchr($old,'?');
}else $query='';
$site=trim('http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]," \n\r\0/");
$site=substr($site,0,strrpos($site,'/'));

$curl=curl_init();
if(!isset($part)) $part='';
curl_setopt_array($curl,array(
	CURLOPT_URL=>$url.$part.$query,
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
//var_dump(curl_getinfo($curl));
$page=curl_exec($curl);
$resp=curl_getinfo($curl,CURLINFO_HTTP_CODE);
$type=curl_getinfo($curl,CURLINFO_CONTENT_TYPE);
curl_close($curl); 
//global
$res=trim($_SERVER["PHP_SELF"],'/');
$res=substr($res,0,strrpos($res,'/')+1);
$page=preg_replace('/src\s*=\s*(\"|\\\')(?!http:)/','src=${1}/'.$res,$page);

$page=str_replace($old,$site,$page);

/*if(strrpos($part,'.css')!==false)
	$res=trim(substr($part,0,strrpos($part,'/')),"/");
else $res=trim($part,"/");
$page=preg_replace('/url\s*\(\s*(?!\\\'|http:)/','url('.$res.'/',$page);
$page=preg_replace('/url\s*\(\s*\\\'(?!http:)/','url(\''.$res.'/',$page);
*/
header("Content-Type: ".$type);
echo $page; 
?>