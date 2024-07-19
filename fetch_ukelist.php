<?php
include('database_connect_pgsql.php');

session_start();
$_SESSION['sysdate']=date('Y-m-d');
//$_SESSION['krt_id']=$_GET['krtid'];

// $query = "
// SELECT * FROM uketuke
// WHERE uketuke_seisandate = '".$_SESSION['sysdate']."' order by uketuke_yoyakuno,uketuke_sttime 
// ";

if($_POST['doctid']!='0' and  isset($_POST['doctid'])){
	$query = "select uketuke.*,doctor.doctor_name from uketuke inner join doctor on doctor_id=uketuke_doctid 
	where UKETUKE_HSPID=0 and uketuke_doctid=".$_POST['doctid']."
	and UKETUKE_DATE = '".date('Y-m-d')."' and uketuke_ku<3 order by  UKETUKE_KU desc,UKETUKE_ID";
} else{
	$query = "select uketuke.*,doctor.doctor_name from uketuke inner join doctor on doctor_id=uketuke_doctid 
	where UKETUKE_HSPID=0 
	and UKETUKE_DATE = '".date('Y-m-d')."' and uketuke_ku<3 order by  UKETUKE_KU desc,UKETUKE_ID";
}


//echo $query;

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="70%">Username</td>
		<th width="20%">Doctor</td>
		<th width="10%">Action</td>
	</tr>
';

foreach ($dbh->query($query) as $row) {
    $ukedat='<a href="./pgsql_pdo_krtlist01.php?petid='.$row['uketuke_petid'].'&krtid='.$row['uketuke_id'].'">'.$row['uketuke_petid'].'</a>:'.mb_convert_encoding($row['uketuke_clntname'], "UTF-8", "EUC-JP").'/';
    $ukedat.=mb_convert_encoding($row['uketuke_petname'], "UTF-8", "EUC-JP");
    $ukedat.='/'.$row['uketuke_sttime'].'/'.$row['uketuke_yoyakuno'];
	if($row['uketuke_doctid']!=0){
		$doctname = mb_convert_encoding($row['doctor_name'], "UTF-8", "EUC-JP");
	} else {
		$doctname = '未設定';
	}
	
    $output .= '
	<tr>
		<td>'.$ukedat.'</td>
		<td class="abc">'.$doctname.'</td>
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-petid="'.$row['uketuke_petid'].'" data-krtid="'.$row['uketuke_id'].'">Start Chat</button></td>
	</tr>
	';
}
$output .= '</table>';

echo $output;
?>