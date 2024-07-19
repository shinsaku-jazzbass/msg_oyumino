<?php
$connect = new PDO("mysql:host=localhost;dbname=chat_healthpet_db;charset=utf8mb4", "root", "A-QVPpTF7v8M");

date_default_timezone_set('Asia/Tokyo');

$userdat = fetch_user_last_activity('1',$connect);

echo $userdat;

$dsn = 'pgsql:dbname=animalnotehealthpet host=133.18.4.55 port=5432';
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

echo get_petdata('829853');




function fetch_user_last_activity($user_id, $connect)
{
	$query = "
	SELECT * FROM login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	//echo $query;
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['last_activity'];
	}
}

function get_petdata($petid){
    //alert("ok");
    global $dbh;

    foreach($dbh->query("select pet_name from petm where pet_id=".$petid) as $rowpet){
        $petname=$rowpet[0];
    }

    return $petname;
}
?>