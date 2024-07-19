<?php

include('database_connection.php');

session_start();
//echo $_SESSION['krt_id'];

//session切れたらlogin4.phpへ遷移
if(!isset($_SESSION['user_id']))
{
	header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  		<script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
		<!--
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        !-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <title>Document</title>
</head>

<style>
.chat_message_area
{
	position: relative;
	width: 100%;
	height: auto;
	background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

#group_chat_message
{
	width: 100%;
	height: auto;
	min-height: 180px;
	overflow: auto;
	padding:6px 24px 6px 12px;
}

.image_upload
{
	position: absolute;
	top:3px;
	right:3px;
}
.image_upload > form > input
{
    display: none;
}

.image_upload img
{
    width: 24px;
    cursor: pointer;
}

</style>

<body>
<div class="container">
<br>
			<div class="row">
				<div class="col-md-8 col-sm-6">
					<h4>グループチャットメッセージ</h4>
				</div>
				<div class="col-md-4 col-sm-3">
					<p align="right">Login User Name - <?php echo $_SESSION['username']; ?> - <a href="pgsql_pdo_krtlist01.php">戻る</a></p>
				</div>
			</div>
<div id="group_chat_dialog" title="Group Chat Window">
	<div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;">

	</div>
	<div class="form-group">
		<!--<textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea>!-->
		<div class="chat_message_area">
			<div id="group_chat_message" contenteditable class="form-control">

			</div>
			

				<div class="image_upload">
				<form id="uploadImage" method="post" action="upload2.php">
					<label for="uploadFile"><img src="upload.png" /></label>
					<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .jpeg, .png" />
				</form>
				</div>
				<!--
				<div>
				<form action="#" method="POST">
  					<img id="upimage">
  					<div>
    				<input type="file" id="upfile">
    				<button type="submit">送信する</button>
  					</div>
				</form>
				</div>
				!-->
			</div>
		</div>
	</div>
	<div class="form-group" align="right">
		<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info">Send</button>
	</div>
</div>
</div>
</body>
</html>
<script>

fetch_group_chat_history();

setInterval(function(){
		//update_last_activity();
		fetch_group_chat_history();
	}, 5000);

$(function(){
  $('#upfile').change(function(e){
    var file = e.target.files[0];
    var reader = new FileReader();
    if(file.type.indexOf('image') < 0){
      alert("画像ファイルを指定してください。");
      return false;
    }
    reader.onload = (function(file){
      return function(e){
        $('#upimage').attr('src', e.target.result);
        $('#upimage').attr('title', file.name);
      };
    })(file);
    reader.readAsDataURL(file);
  });
});

// $(function(){
//   $('#uploadFile').change(function(e){
//     var file = e.target.files[0];
//     var reader = new FileReader();
//     if(file.type.indexOf('image') < 0){
//       alert("画像ファイルを指定してください。");
//       return false;
//     }
//     reader.onload = (function(file){
//       return function(e){
//         $('#upimage').attr('src', e.target.result);
//         $('#upimage').attr('title', file.name);
//       };
//     })(file);
//     reader.readAsDataURL(file);
//   });
// });

$('#uploadFile').on('change', function(){
		$('#uploadImage').ajaxSubmit({
			target: "#group_chat_message",
			resetForm: true
		});
});

	function fetch_group_chat_history()
	{
	$.ajax({
        url:"group_chat_disp.php",
        method:"POST",
        success:function(data){
            $('#group_chat_history').html(data);
        }
    })
			// $.ajax({
			// 	url:"group_chat.php",
			// 	method:"POST",
			// 	data:{action:action},
			// 	success:function(data)
			// 	{
			// 		$('#group_chat_history').html(data);
			// 	}
			// })

	}

	$('#send_group_chat').click(function(){
		//upload.phpから$('#group_chat_message').html()のレスポンスをvar chat_messageに取得
		var chat_message = $.trim($('#group_chat_message').html());
		var action = 'insert_data';
		if(chat_message != '')
		{
			//alert("ok");
			$.ajax({
				url:"group_chat.php",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data){
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
				}
			})
		}
		else
		{
			alert('Type something1');
		}
	});

	$(document).on('click', '.remove_chat', function(){
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?"))
		{
			$.ajax({
				url:"remove_chat.php",
				method:"POST",
				data:{chat_message_id:chat_message_id},
				success:function(data)
				{
					update_chat_history_data();
				}
			})
		}
	});

</script>