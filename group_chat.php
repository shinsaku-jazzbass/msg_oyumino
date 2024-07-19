<?php

//group_chat.php

include('database_connection.php');

session_start();

if(isset($_SESSION['upnam'])){

}else{
    $_SESSION['upnam']='';
}

//if($_POST["action"] == "insert_data")の時イメージ添付メッセージの時
if($_POST["action"] == "insert_data")
{
	$data = array(
		':from_user_id'		=>	$_SESSION["user_id"],
		':chat_message'		=>	$_POST['chat_message'],
		':status'			=>	'1',
        ':to_krt_id'		=>	$_SESSION["krt_id"],
		':image_path'		=>	$_SESSION["upnam"],
        ':pet_id'		    =>	$_SESSION["petid"]
	);

	$query = "
	INSERT INTO chat_message 
	(from_user_id, chat_message, status, to_krt_id, image_path, pet_id) 
	VALUES (:from_user_id, :chat_message, :status, :to_krt_id, :image_path, :pet_id)
	";

	$statement = $connect->prepare($query);

	if($statement->execute($data))
	{
		echo fetch_group_chat_history($connect);
	}

}

if($_POST["action"] == "fetch_data")
{
	echo fetch_group_chat_history($connect);
}

?>