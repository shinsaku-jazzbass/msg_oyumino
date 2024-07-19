<?php

//logout.php

include('database_connection.php');

session_start();

$query = "
DELETE FROM login_details
WHERE user_id = '".$_SESSION['user_id']."' 
";
//echo $query;

$statement = $connect->prepare($query);

if($statement->execute($data))
{
	//echo "login_details delete ok!!";
}

//sessionを消しlogin.phpへ遷移
session_destroy();

//echo '<a href="./login.php">Loginへ戻る！！</a>';
header('location:login.php');

?>