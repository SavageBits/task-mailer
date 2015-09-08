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
$completionDate = $_POST['_completionDate'];
$taskIsComplete = $_POST['_taskIsComplete'];

$sql = "REPLACE INTO task_to_day(task_id, task_date, is_complete) VALUES ($taskId, '$completionDate', $taskIsComplete);";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}

?>