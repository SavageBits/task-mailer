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

$taskName = $_POST['_taskName'];
$checklistId = $_POST['_checklistId'];
$taskDate = $_POST['_taskDate'];



/*****************************************
* insert new task
*/
$sql = " INSERT INTO task (task_name) VALUES ('$taskName'); ";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}
/*****************************************/



/******************************************
* get new task id
*/
$sql = " SELECT MAX(task_id) 'new_task_id'  FROM task ";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}

while ($row = mysql_fetch_array($result)) {
    $newTaskId = $row["new_task_id"];
}	      
/*****************************************/



/******************************************
* insert checklist to task
*/
if (!$checklistId) {
	
}

$sql = " INSERT INTO checklist_to_task (checklist_id, task_id) VALUES ($checklistId, $newTaskId); ";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}
/*****************************************/



/******************************************
* insert task to day
*/
$sql = "REPLACE INTO task_to_day(task_id, task_date, is_complete) VALUES ($newTaskId, '$taskDate', 0);";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}
/*****************************************/


mysql_close($link);

echo $newTaskId;

?>