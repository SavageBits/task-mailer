<!doctype html>
<?php
	    		
if (ISSET($_GET['l'])) {
	$checklistId = $_GET['l'];									
}

if (ISSET($_GET['d'])) {
	$checklistDate = $_GET['d'];
}
else {
	$checklistDate = date("Y-m-d");
}

?>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>everyday.is</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->

	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="css/1140.css" type="text/css" media="screen" />
	
	<!-- Your styles -->
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
	
	<link href="http://fonts.googleapis.com/css?family=Reenie+Beanie|Oxygen" rel="stylesheet" type="text/css">
	
	<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
	<script type="text/javascript" src="js/css3-mediaqueries.js"></script>
	
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.effects.core.min.js"></script>
	<script type="text/javascript" src="js/savage-task.js"></script>
	<script type="text/javascript" src="js/task-ui.js"></script>
	<script type="text/javascript">	 
		<?php
		
		if (ISSET($checklistId)) {
				
			echo "var checklistId = $checklistId;";
		}
		else {
			echo 'var checklistId;';
		}
		
		?>
		
	    
	    $(document).ready(function() {	    		    		    		    	
	    	$('body').on("keydown", ".new-task-box" ,function(event) {
	    		if ((event.which == 13) && ($(this).val().length > 0)) {	    			   				    			
	    			var d = new Date();
	    			var taskDivId = "task" + d.getTime();
	    			
	    			//insert a new task using the task name in the textbox
	    			task.insertTask($(this).val(), checklistId, taskDivId, '<?= $checklistDate ?>');	    				    				    			
	    			
	    			$('#task-list').append("<div id='" + taskDivId + "' class='task'>"
						+ "<span class='task-name'>" + $(this).val() + "</span>"
					+ "</div>");
	    			
					/*
$(".new-task").after("<div id='" + taskDivId + "' class='task'>"
						+ "<span class='task-name'>" + $(this).val() + "</span>"
					+ "</div>");
*/
										    			
	    			$(this).val("").focus();					
	    		}
	    	});	    		    	
	    	
	    	$('body').on("click", ".task", function() {
	    		if (!$(this).hasClass("delete")) {
		    		//there's a timing issue for the animation of toggleClass
		    		// so this looks a little backwards
		    		var isComplete = true;
		    		
		    		if ($(this).hasClass('task-complete')) {
		    			//it's complete now, so we're switching it to incomplete
		    			isComplete = false;	
		    		}
		    		
					$(this).toggleClass('task-complete', 250);
					
					task.toggleTaskComplete($(this).attr('id'),'<?= $checklistDate ?>',isComplete);
				}
	    	});
	    	
	    	$("body").on("click", ".taskToDay-delete-button", function() {	    		
				$(this).parent().addClass("delete");
				
				//alert($(this).parent().attr("id"));
				
				task.deleteTaskToDay($(this).parent().attr("id"),'<?= $checklistDate ?>');
				
				$(this).parent().remove();
	    	});
	    	
	    	$("body").on("click", ".new-list", function() {
	    		$('#create-list').remove();
	    		
	    		checklistId = task.createList();
	    		
	    		var checklistUrl = "?l=" + checklistId;
	    		
	    		$("#checklistUrl").html('<a href="' + checklistUrl + '">' + checklistUrl + '</a>');	    		    			    		    		
	    		
	    		$("#placeholder").replaceWith(task.getList(checklistId,'<?= date("Y-m-d") ?>'));	    		
	    	});	    		    	
	    	
	    	window.scrollTo(0, 1);
	    });	   
	    	    
	</script>
</head>


<body>

<div id="header-container" class="container">
	<div class="row">
		<div class="twelvecol last">
			<span class="logo">everyday.is</span>			
		</div>
	</div>
</div>


<?php

if (isset($checklistId)) {
	include 'task-list.php';
}
else {
	echo "<div id=\"create-list\" class=\"container\">
			<div class=\"row\">
				<div class=\"twelvecol last\">
					<div class=\"new-list\">
						Create a new list
					</div>
				</div>
			</div>
		</div>";
}

?>		

<div id="placeholder"></div>	
						
</body>

</html>