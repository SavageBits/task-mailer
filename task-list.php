<?php 

require("include/global.php");

if (ISSET($_POST['_checklistId'])) {
	$checklistId = $_POST['_checklistId'];
}

if (ISSET($_POST['_checklistDate'])) {
	$checklistDate = $_POST['_checklistDate'];
}

$dayLinks = "";

//$dayToday = date("d");

//10 11 12 13 14 15 16 17 yesterday today

$from_unix_time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));			

$i = 3;

$selectedDayWasFound = 0;
$dayClass = '';

while ($i >= 1) {
	$day_before = strtotime("-$i day", $from_unix_time);
	$formatted = date('Y-m-d', $day_before);
	$formatted_day = date('d', $day_before);

		
	if ($checklistDate == $formatted) {
		$dayClass = ' class="selected"';
		$selectedDayWasFound = 1;
	}
		
	$dayLinks = $dayLinks . " <a href='?l=$checklistId&d=$formatted'$dayClass>$formatted_day</a>";
	
	$dayClass = '';
	$i--;
}

if (!$selectedDayWasFound) {
	$dayClass = ' class="selected"';
}

$dayLinks = $dayLinks . " <a href='?l=$checklistId'$dayClass>today</a> ";
										
if (ISSET($checklistId)) {				
	$checklistUrl = "?l=" . $checklistId;
}

//<img src=\"images/link.png\" alt=\"link\" width=\"30\" height=\"30\" id=\"link-image\" />

echo("<div id=\"day-bar-container\" class=\"container\">
		<div class=\"row\">
			<div class=\"twelvecol last\">
				<div id=\"day-bar\">
					$dayLinks
	  				<a href=\"$checklistUrl\" id=\"super-link\" class=\"last\"></a>
				</div>
			</div>		
		</div>
	</div>
	
	<div id=\"task-list-container\" class=\"container\">
		<div class=\"row\">			
			<div id=\"task-list\" class=\"twelvecol last\">
				<div class=\"new-task\">
					<input class='new-task-box' type='text'>
				</div>");
			
$link = mysql_connect($host,$usr,$pwd);

if (!$link) { 
	echo("ERROR: " . mysql_error() . "\n"); 
}

$db_selected = mysql_select_db($db, $link);

if (!$db_selected) {
    die ('Can\'t use $db : ' . mysql_error());
}

//check to see if there are any tasks already for the specified day
$sql = "SELECT task_to_day_id FROM task_to_day WHERE task_date = '$checklistDate' LIMIT 1";

$result = mysql_query($sql, $link);
$num_rows = mysql_num_rows($result);

if ($num_rows == 0) {
	//echo($num_rows);
	$sql = "insert into task_to_day (task_id,task_date)\n"
    . "select\n"
    . " T.task_id\n"
    . " ,'$checklistDate'\n"
    . "from checklist_to_task CtT\n"
    . " join task T\n"
    . " on CtT.task_id = T.task_id\n"
    . "where\n"
    . " CtT.checklist_id = $checklistId";
}

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}

$sql = "SELECT \n"
    . "T.task_id\n"
    . ",T.task_name\n"
    . ",TtD.is_complete\n"
    . "FROM `checklist_to_task` CtT\n"
    . "JOIN task T\n"
    . "ON CtT.task_id = T.task_id\n"
    . "LEFT JOIN task_to_day TtD\n"
    . "ON CtT.task_id = TtD.task_id\n"
    . "WHERE\n"
    . "checklist_id = $checklistId\n"
    . "and\n"
    . "TtD.task_date = '$checklistDate'";

$result = mysql_query($sql, $link);

if (!$result) { 
	echo( mysql_error()); 
}

while ($row = mysql_fetch_array($result)) {
	$taskId = $row["task_id"];
	$taskName = $row["task_name"];
	$isComplete = $row["is_complete"];
	
	$taskCompleteClass = $isComplete == 1 ? ' task-complete' : '';
	
	//echo($checklistDate);
	
	echo("<div id=\"$taskId\" class=\"task$taskCompleteClass\">
			<div class=\"task-name\">$taskName</div>
			<div class=\"taskToDay-delete-button\"></div>
		  </div>\n");  
}

echo("</div> <!-- end task-list-container -->");

?>