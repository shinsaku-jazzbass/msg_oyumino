<?php
include('database_connect_pgsql.php');

session_start();
if(isset($_GET['petid'])){
    $_SESSION['petid']=$_GET["petid"];
}
if(isset($_GET['krtid'])){
    $_SESSION['krt_id']=$_GET["krtid"];
}

if(file_exists('/var/www/html/chat_healthpet/imgdata'.$_SESSION['petid'])){

}else{
    mkdir ('/var/www/html/chat_healthpet/imgdata'.$_SESSION['petid'],0777);
}

echo $_SESSION['login_details_id'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>PHP pgsql pg_query bootstraps によるサンプル</title>
</head>
<body>
<div class="container">
			<br />
			
			<h3 align="center">PHP Pgsql pg_query Bootstrapによるアプリ</h3><br />
			<br />
            <div class="row">
				<div class="col-md-8 col-sm-6">
					<h4>登録済ユーザ</h4>
				</div>
				<div class="col-md-2 col-sm-3">
					<input type="hidden" id="is_active_group_chat_window" value="no" />
                    <button type="button" name="enqu_sys" id="enqu_sys" class="btn btn-warning btn-xs"><a href="../vetssenqsys_healthpet/enqulist1.php">Enqusys</a></button>
					<button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs"><a href="index.php">ANoteチャット</a></button>
				</div>
				<div class="col-md-4 col-sm-3">
					<p align="right">Login User Name - <?php echo $_SESSION['username']; ?> - <a href="pgsql_pg_querytest01.php">戻る</a></p>
				</div>
			</div>
			<!--
			//user_details下記のdivタグにユーザ一覧表示
			//user_model_detailsはポップアップチャットダイアログを表示
			!-->
			<div class="table-responsive">
                <!--
				//以下のdivタグ内にデータベースからのデータ表示
                !-->
				<?php
         
                 test_connect_krtmei($_SESSION['petid']);
                 
                 
                 ?>
			</div>
			<br />
			<br />
			
</div>
    
</body>
</html>
<style>

</style>
<script>
    //アクセス時実行される今は非推奨
    // $(document).ready(function(){
    // })
    //fetch_user.phpにリクエストし、html形式データのレスを#user_details<div id="user_details"></div>のdivタグに出力する。
    // $(document).ready(function(){
    // })
    // fetch_kind();

    // function fetch_kind()
    // {
        
    //     $.ajax({
    //         url:"fetch_ukelist.php",
    //         method:"POST",
    //         success:function(data){
    //             $('#data_details').html(data);
    //         }
    //     })
    // }
    fetch_group_chat_history();

	function fetch_group_chat_history()
	{
        $.ajax({
        url:"group_chat_disp.php",
        method:"POST",
        success:function(data){
            $('#gchatdata').html(data);
        }
    })
    }

    

</script>