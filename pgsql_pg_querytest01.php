<?php
session_start();
echo $_SESSION['login_details_id'];

//session切れたらlogin.phpへ遷移
if(!isset($_SESSION['user_id']))
{
	header("location:login.php");
}
if(isset($_GET['doctid'])){
    $listmsg = $_SESSION['nicname'].'先生受付一覧(<a href="pgsql_pg_querytest01.php">全受付切替</a>)';
}else{
    $listmsg = '全受付一覧';
}

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
			
			<h3 align="center">受付一覧</h3><br />
			<br />
            <div class="row">
				<div class="col-md-8 col-sm-6">
					<h4><?php echo $listmsg; ?></h4>
				</div>
				<div class="col-md-2 col-sm-3">
					<input type="hidden" id="is_active_group_chat_window" value="no" />
					<button type="button" name="group_chat" id="group_chat" onclick="location.href='./userlist.php'" class="btn btn-warning btn-xs">病院スタッフメッセージ</button>
				</div>
				<div class="col-md-4 col-sm-3">
					<p align="right">Login User Name - <?php echo '<a href="./pgsql_pg_querytest01.php?doctid='.$_SESSION['username'].'">'.$_SESSION['nickname']; ?></a> - <a href="logout.php">Logout</a></p>
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
				<div id="data_details"></div>
			</div>
			<br />
			<br />
			
</div>
    
</body>
</html>
<style>

</style>
<script>


    fetch_ukelist();

    function fetch_ukelist()
    {

        // URLを取得
        let url = new URL(window.location.href);

        //URLSearchParamsオブジェクトを取得
        let params = url.searchParams;
            var doctid = 0;
        if(params.get('doctid')){
            doctid = params.get('doctid');
        }
            //alert(doctid);
        $.ajax({
            url:"fetch_ukelist.php",
            method:"POST",
            data: { "doctid" : doctid },
            success:function(data){
                $('#data_details').html(data);
            }
        })
    }
    //fetch_ukelist.phpを読み込んでいるので、$(document).onにてclickイベントを有効とする。
    $(document).on('click', '.abc', function(){
        alert("クリックされました");
    });

    // const BUTTON_CLICK_EVENT= document.getElementById('start_chat');
    //     BUTTON_CLICK_EVENT.addEventListener('click', () => {
    //         alert("ボタンがクリックされました");
    // });
    //fetch_ukelist.phpを読み込んでいるので、$(document).onにてclickイベントを有効とする。
    $(document).on('click', '.start_chat', function(){
        var petid = $(this).data('petid');
        var krtid = $(this).data('krtid');
        location.href = './pgsql_pdo_krtlist01.php?petid='+petid+'&krtid='+krtid;
    });



</script>