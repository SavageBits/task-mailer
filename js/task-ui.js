$(document).ready(function() {	    		    	
	$('body').on("click", ".new-task", function() {	    		    		
		$('.new-task-box').focus();	    			    		
	});

   	//event delegation example - bind has been deprecated
	$("body").on("mouseover mouseout", ".task", function() {
		$(this).toggleClass("task-hover");
	});
		    			    		    		    	   		    	
});