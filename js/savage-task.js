var task = {
	insertTask: function(taskName, checklistId, taskDivId, taskDate){
		$.ajax({
			url: "ajax/insertTask.php",
			type: "POST",
			data: {_taskName: taskName, _checklistId: checklistId, _taskDate: taskDate},
			async: true,
			success: function (result) {
                $("#" + taskDivId).attr("id", result);                                
            }
		});
	},
	deleteTaskToDay: function(taskId, taskDate){
		$.ajax({
			url: "ajax/deleteTaskToDay.php",
			type: "POST",
			data: {_taskId: taskId, _taskDate: taskDate},
			async: true,
			success: function (result) {
               
            }
		});	
	},
	createList: function(){
		var newChecklistId = 0;
		
		$.ajax({
			url: "ajax/createList.php",
			type: "POST",
			data: {},
			async: false,
			success: function (result) {
                newChecklistId = result;
            }
		});
		
		return newChecklistId;
	},
	getList: function(checklistId, checklistDate){
		var checklist;
	    	
    	$.ajax({
			url: "task-list.php",
			type: "POST",
			data: {_checklistId: checklistId, _checklistDate: checklistDate},
			async: false,
			success: function (result) {
                checklist = result;
            }
		});
    		    	
    	return checklist;
	},
	toggleTaskComplete: function(taskId, taskDate, taskIsComplete){		
		$.ajax({
			url: "ajax/toggleTaskComplete.php",
			type: "POST",
			data: {_taskId: taskId, _completionDate: taskDate, _taskIsComplete: taskIsComplete},
			async: true,
			success: function (result) {
				//alert(result);
        
            }
		});
	},
	init: function(){
		
	}
};