<?php
$username = 'eecs394orange';
$password = 'Save me some money';

$db = mysql_connect(localhost,$username,$password);
if(!$db){
	echo "Could not connect to database.";
	error('Could not connect to database.');
}
else{
	//echo "We're connected to the database!";
}

mysql_select_db('makemerecipe'); 


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
