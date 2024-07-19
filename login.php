<!--
//login.php
!-->

<?php

include('database_connection.php');

session_start();

$message = '';

//$_SESSION['user_id']が存在すればindex.phpへ遷移
if(isset($_SESSION['user_id']))
{
	header('location:index.php');
}

if(isset($_POST['login']))
{
	$query = "
		SELECT * FROM login 
  		WHERE username = :username
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':username' => $_POST["username"]
		)
	);	
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if(password_verify($_POST["password"], $row["password"]))
			{
				//userが存在したらlogin_detailsに登録
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['nickname'] = $row['nickname'];
				$sub_query = "
				INSERT INTO login_details 
	     		(user_id) 
	     		VALUES ('".$row['user_id']."')
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				//$_SESSION['login_details_id']にlogin時の自分のlogin_detailsのidをセットする。
				$_SESSION['login_details_id'] = $connect->lastInsertId();
				//index.phpへ遷移
				header('location:pgsql_pg_querytest01.php');
			}
			else
			{
				$message = '<label>Wrong Password</label>';
			}
		}
	}
	else
	{
		$message = '<label>Wrong Username</labe>';
	}
}


?>

<html>  
    <head>  
        <title>Chat Application using PHP Ajax Jquery</title>  
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
			<br />
			
			<h1 align="center">Vetss Messenger App</h1><br />
			<br />
			<div class="panel panel-default">
  				<div class="panel-heading">ログイン</div>
				<div class="panel-body">
					<p class="text-danger"><?php echo $message; ?></p>
					<form method="post">
						<div class="form-group form-group-lg">
							<label><h1>Enter Username</h1></label>
							<input type="text" name="username" class="form-control" required />
						</div>
						<div class="form-group form-group-lg">
							<label><h1>Enter Password</h1></label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group form-group-lg">
							<input type="submit" name="login" class="btn btn-info" value="Login" />
						</div>
					</form>
					<br />
					<p><img src="./images/qr20240718145805688.png"></p>
					<br />
					<br />
					<br />
				</div>
			</div>
		</div>

    </body>  
</html>