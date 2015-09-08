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

$taskId = $_POST['_taskId'];
$taskDate = $_POST['_taskDate'];



/*****************************************
* insert new task
*/
$sql = " DELETE FROM task_to_day WHERE task_id = $taskId and task_date = '$taskDate' ";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}
/*****************************************/

mysql_close($link);

?>