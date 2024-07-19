<?php

//remove_chat.php

include('database_connection.php');

//chat_message 削除せずstatusに2を設定
if(isset($_POST["chat_message_id"]))
{
	$query = "
	UPDATE chat_message 
	SET status = '2' 
	WHERE chat_message_id = '".$_POST["chat_message_id"]."'
	";

	$statement = $connect->prepare($query);

	$statement->execute();
}

?>
