<?php
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
$username = $mysql_config["username"];
$password = $mysql_config["password"];
$hostname = $mysql_config["hostname"];
$port = $mysql_config["port"];
$db = $mysql_config["name"];
$link = mysql_pconnect("$hostname:$port", $username, $password);

if(!$link){
	echo "Could not connect to database.";
	error('Could not connect to database.');
}
else{
	//echo "We're connected to the database!";
}

$db_selected = mysql_select_db($db, $link);


function dbQuery($sql){
	$results = mysql_query($sql);
	if(!$results){
		return NULL;
	}
	$jk = 0;
	while($row = mysql_fetch_assoc($results)){
		$result[$jk++] = $row;
	}
	return $result;
}
?>
