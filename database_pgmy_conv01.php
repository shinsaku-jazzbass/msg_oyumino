<?php
session_start();



$user = 'postgres';
$password = '';

try{
    $dbh = new PDO($dsn, $user, $password);
    //print('okpgsql!!');
    date_default_timezone_set('Asia/Tokyo');

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}




foreach($dbh->query("select * from doctor where doctor_ku=1 order by doctor_id") as $rowdoct){
        $passwd=$rowdoct['doctor_hint']*100;
        $passwd=$passwd+$rowdoct['doctor_id'];
        echo $rowdoct['doctor_id'].": ".mb_convert_encoding($rowdoct['doctor_name'], "UTF-8", "EUC-JP").": ".$passwd."<br>";


        // $data = array(
        //     ':username'		=>	$rowdoct['doctor_id'],
        //     ':password'		=>	password_hash($passwd, PASSWORD_DEFAULT),
        //     ':nickname'		=>	mb_convert_encoding($rowdoct['doctor_name'], "UTF-8", "EUC-JP")
        // );

        // $query = "
        // INSERT INTO login 
        // (username, password, nicname) 
        // VALUES (:username, :password, :nickname)
        // ";
        // $statement = $connect->prepare($query);
        // if($statement->execute($data))
        // {
        //     $message = "<label>Registration Completed</label>";
        // }

}



?>