<?php
session_start();
echo "検索処理中！！";
require_once("./MySmarty.class.php");
$o_smarty=new MySmarty();
$db=$o_smarty->getDb();
$db->query('SET NAMES utf8');

$dsnw=$o_smarty->get_config_vars("db_stringx");
echo $dsnw;
require_once 'DB.php';
$dsn=$dsnw;
$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);
$db2 = DB::connect($dsn);
if (DB::isError($db2)) {
    die($db->getMessage());
}
if(isset($_GET['userid'])===false){
    $_GET['userid']=826875;
}

$SQLM="select * from client where client_id=".$_GET['userid'];

$rsx=$db2->query($SQLM);
$rowx=$rsx->fetchRow(DB_FETCHMODE_ASSOC);

print_r($rowx);
foreach($rowx as $key=>$val){

	//echo mb_convert_encoding($val, "UTF-8", "EUC-JP")."<br>";
}
$updflg="新規";
$nickid=$rowx['client_id'];
$sei=$rowx['client_sei'];
$passwdw=$rowx['client_passwd'];
$passwd=md5($passwdw);
$passcode=mt_rand(0,9999);
$SQLINS="insert into mt_author (author_id,author_name,author_email,author_profile,author_nickname,auther_cre_date,author_password,author_type,author_keitaimail,author_hint,author_joinid,author_prejoinid)
values(".$nickid.",'".$nickid."','','vetsswebsend','".mb_convert_encoding($client_sei,"UTF-8","EUC-JP")."','".date('Y-m-d H:i:s')."','".$passwd."',0,'','".$passwdw."',".$nickid.",".$passcode.")";
//echo $SQLINS."<br>";
$rsx=$db->query($SQLINS);

//$SQL = "select currval('mt_author_author_id_seq')";


//petm生成

$sql = "select * from petm";
$result = $db->query($sql);
$col_cnt=$result->numCols();

$info = $db->tableInfo("petm");
//print_r($info);

$SQLM="select * from petm where  pet_clntid=".$_GET['userid']." order by pet_id";
$nickname="";
$cnt=0;
$rsx=$db2->query($SQLM);

//飼育数$suu
$suu=$rsx->numRows();
while($rowx=$rsx->fetchRow(DB_FETCHMODE_ASSOC)){
	//塚越動物病院の場合
	//if($_GET['petid']==$rowx['pet_memokey'] and $_GET['petid']!=$rowx['pet_id']){
	//	$_GET['petid']=$rowx['pet_id'];
	//}
   //pet_dkuが0のペットのみ登録
   if($rowx['pet_dku']==0){
	$cnt++;
	//pet_hospidがpet_hspidとなっている場合
	if(isset($rowx['pet_hospid'])){
	
	}else{
		$rowx['pet_hospid']=$rowx['pet_hspid'];
	}
	if(isset($rowx['pet_authid'])){

	}else{
		$rowx['pet_authid']=$_GET['userid'];
	}

	if($rsx->numRows()==1){
		$nickname=$nickname.$rowx["pet_name"];
	}else if($rsx->numRows()>1 and $cnt<4){

		if($rsx->numRows()==$cnt){
		$nickname=$nickname.$rowx["pet_name"];
		}else{
		$nickname=$nickname.$rowx["pet_name"]."/";
		}
	}

	//echo "insert into petm(pet_id,pet_bday,pet_dday,pet_firstday,pet_lastday,pet_authid,pet_clntid)values(".$rowx['pet_id'].",'9999-01-01','9999-01-01','9999-01-01','9999-01-01',".$_GET['userid'].",".$_GET['userid'].")<br>";

	$rs = $db->query("insert into petm(pet_id,pet_bday,pet_dday,pet_firstday,pet_lastday,pet_authid,pet_clntid)values(".$rowx['pet_id'].",'9999-01-01','9999-01-01','9999-01-01','9999-01-01',".$_GET['userid'].",".$_GET['userid'].")");

	$SQLUPD="update petm set ";
	for($i=1;$i<$col_cnt;$i++){
		//echo $info[$i][type];
		if($info[$i][type]=="date" and $rowx[$info[$i]["name"]]==""){
		 	$rowx[$info[$i]["name"]]="9999-01-01";
		}
		if($info[$i][type]=="date" OR $info[$i][type]=="varchar" OR $info[$i][type]=="char"){
			$ku="'";
		}else{
			$ku="";
		}
	   	if($i==$col_cnt-1){
			$SQLUPD=$SQLUPD.$info[$i]["name"]."=".$ku.mb_convert_encoding($rowx[$info[$i]["name"]],"UTF-8", "EUC-JP").$ku;
	   	}else{
			$SQLUPD=$SQLUPD.$info[$i]["name"]."=".$ku.mb_convert_encoding($rowx[$info[$i]["name"]],"UTF-8", "EUC-JP").$ku.",";
	   	}
	}


	$SQLUPD=$SQLUPD." where pet_id=".$rowx['pet_id'];
	//echo $SQLUPD."<br>";

	$rsz=$db->query($SQLUPD);


	//print_r($rowx);
	//	foreach($rowx as $key=>$val){
	//
	//		echo mb_convert_encoding($val, "UTF-8", "EUC-JP")."<br>";
	//	}
   }else{
   //pet_dkuが1のペットを削除処理
	$rsz=$db->query("delete from petm where pet_id=".$rowx['pet_id']);
   }

   $nickname=mb_substr(mb_convert_encoding($nickname,"UTF-8", "EUC-JP"),0,50);

    if($suu>3){
        //echo "update mt_author set author_nickname='".mb_convert_encoding($sei,"UTF-8", "EUC-JP").$nickname."..' where author_id=".$_GET['userid'];
        $rsz=$db->query("update mt_author set author_nickname='".mb_convert_encoding($sei,"UTF-8", "EUC-JP").$nickname."..' where author_id=".$_GET['userid']);
    }else{
        //echo "update mt_author set author_nickname='".mb_convert_encoding($sei,"UTF-8", "EUC-JP").$nickname."' where author_id=".$_GET['userid'];
        $rsz=$db->query("update mt_author set author_nickname='".mb_convert_encoding($sei,"UTF-8", "EUC-JP").$nickname."' where author_id=".$_GET['userid']);
    }

}
?>