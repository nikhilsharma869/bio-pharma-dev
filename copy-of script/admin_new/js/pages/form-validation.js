$(document).ready(function() {
 	//------------- Form validation -------------//
 	$('#select1').select2({placeholder: "Select"});

 	$("#validate").validate({
 		ignore: null,
    	//ignore: 'input[type="hidden"]',
 		rules: {
 			//select1: "required",
 			banner_title: {
				required: true,
				minlength: 5
			},
			
 		},
 		messages: {
 			banner_title: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			
 		}
 	});
});