<?php

//fetch_user.php

include('database_connection.php');

session_start();

//自分以外の全ユーザをloginテーブルから検索
$query = "
SELECT * FROM login 
WHERE user_id != '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="70%">Username</td>
		<th width="20%">Status</td>
		<th width="10%">Action</td>
	</tr>
';

//自分以外のユーザがログインしているループしてチェック
//これが問題と思われる、自分以外のログインを直接、login_detailsに存在するかチェックすれば良いと思われる。
foreach($result as $row)
{
	//1日前のログインまで有効に変更
	$status = '';
	//$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 1 day');
	//$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	//上記記述は問題あり下記に変更
	//$current_timestamp = date("Y/m/d H:i:s", strtotime(date("Y-m-d H:i:s") . "-10 second"));
	//更に変更一日前にのログインまで有効
	$current_timestamp = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "-1 day"));
	//database_connection.phpのfetch_user_last_activityにてログイン中のloginユーザサーチ
	$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
	if($user_last_activity > $current_timestamp)
	{
		//onlineユーザにはbootstrap緑のOnLineボタン表示 http://bootstrap3.cyberlab.info/components/labels.html
		$status = '<span class="label label-success">Online</span>';
	}
	else
	{
		//onlineユーザには赤のOffLineボタン表示
		$status = '<span class="label label-danger">Offline</span>';
		//onlineユーザにはbootstrap灰色のOffLineボタン表示に変更！！
		$status = '<span class="label label-default">Offline</span>';
	}
	$output .= '
	<tr>
		<td>'.$row['username'].'('.$row['nickname'].') '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td>
		<td>'.$status.'</td>
		<td><button type="button" id="start_chat" class="btn btn-info btn-xs start_chatx" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
	</tr>
	';
}

$output .= '</table>';

echo $output;

?>