<?php
//session_start();
require_once("Auth/Auth.php");
//require_once("Auth/HTTP.php");
require_once("MySmarty.class.php");
//require_once("../User.class.php");
//function __autoload($name){
	//$o_smarty=new MySmarty()の実行で、$nameにMySmartyがセットされる。（PHP5から）
	//echo $_SERVER['SCRIPT_NAME'].$name;
	//require_once("../".$name.".class.php");
//}

function myLogin(){
	global $o_smarty;


}

//echo $_POST['password'];
$o_smarty=new MySmarty();

$params=array(
	"dsn" => $o_smarty->get_config_vars("db_string"),
	"table" => "mt_author",
	"usernamecol" => "author_name",
	"passwordcol" => "author_password");
$_SESSION['dsn']=$o_smarty->get_config_vars("db_string");

//$auth=new Auth("認証の種類:DB",上記で設定したパラメータ:$params,ログインページ表示ユーザ定義関数名:"myLogin",ログイン処理必須:TRUE);
$auth=new Auth("DB",$params,"myLogin",TRUE);
$auth->start();
//echo "user".$auth->getUsername();
if($auth->getUsername()!=""){

}else{
	exit(1);
}

?>