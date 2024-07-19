<?php
session_start();
//upload.php
// if(!isset($_SESSION['petid'])){
//     header("location:login5.php");
// }
$_SESSION['upnam']=time();
//echo $_SESSION['upnam'];
if(!empty($_FILES))
{
	if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
	{
		$ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
		$allow_ext = array('jpg', 'jpeg', 'png');
		if(in_array($ext, $allow_ext))
		{
			$_source_path = $_FILES['uploadFile']['tmp_name'];
            $_SESSION['upnam'] = $_SESSION['upnam'].'.'.$ext;
			$target_path = 'imgdata'.$_SESSION['petid'].'/' . $_SESSION['upnam'];
			if(move_uploaded_file($_source_path, $target_path))
			{
				echo '<p><img src="'.$target_path.'" class="img-thumbnail" width="200" height="160" /></p><br />';
			}
			//echo $ext;
		}
	}
}

?>