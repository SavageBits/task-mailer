<?php 

include("../include/global.php");

$link = mysql_connect($host,$usr,$pwd);

if (!$link) { 
	echo("ERROR: " . mysql_error() . "\n"); 
}

$db_selected = mysql_select_db($db, $link);

if (!$db_selected) {
    die ('Can\'t use $db : ' . mysql_error());
}
/*****************************************
* insert checklist
*/
$sql = " INSERT INTO checklist (checklist_name) VALUES (''); ";

//$result = mysql_db_query($db, $sql, $link);
$result = mysql_query($sql, $link);

if (!$result) { 
	echo(mysql_error()); 
}
/*****************************************/



/******************************************
* get new checklist id
*/
$sql = " SELECT MAX(checklist_id) 'new_checklist_id'  FROM checklist ";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}

while ($row = mysql_fetch_array($result)) {
    $newId = $row["new_checklist_id"];
}	      
/*****************************************/

mysql_close($link);

/*
define('SALT', 'whateveryouwant'); 

function encrypt($text) 
{ 
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
} 

function decrypt($text) 
{ 
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))); 
} 

$encryptedId = encrypt($newId); 
//echo decrypt($encryptedmessage);
*/ 


echo $newId;

?>