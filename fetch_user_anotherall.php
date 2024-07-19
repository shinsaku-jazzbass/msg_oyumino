<?php
//fetch_user_anotherall.php

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

//print_r($result);

$output = '<SELECT name="kindname" onChange="kakunin(this.options[this.selectedIndex].value)">';
$output.='<OPTION value="none">user select</OPTION>';
    foreach($result as $row){
            $output.='<OPTION value="'.$row['user_id'].'">'.$row['username'].'</OPTION>';
    }
						
		
$output.='</SELECT>';
            

// $output = '
// <table class="table table-bordered table-striped">
// 	<tr>
// 		<th width="70%">Username</td>
// 		<th width="20%">Status</td>
// 		<th width="10%">Action</td>
// 	</tr>
// ';

// foreach($arr_user as $row)
// {

// 	$status = '<span class="label label-default">Offline</span>';

// 	$output .= '
// 	<tr>
// 		<td>'.$row[0].' </td>
// 		<td>'.$status.'</td>
// 		<td><button type="button" class="btn btn-info btn-xs start_chat">Start Chat</button></td>
// 	</tr>
// 	';
// }

// $output .= '</table>';

echo $output;

?>