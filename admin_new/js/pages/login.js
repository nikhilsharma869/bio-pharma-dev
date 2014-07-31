$(document).ready(function() {

	//------------- Login page simple functions -------------//
 	$("html").addClass("loginPage");

 	wrapper = $(".login-wrapper");
 	barBtn = $("#bar .btn");

 	//change the tabs
 	barBtn.click(function() {
	  btnId = $(this).attr('id');
	  wrapper.attr("data-active", btnId);
	  $("#bar").attr("data-active", btnId);
	});

 	//show register tab
	$("#register").click(function() {
	  btnId = "reg";
	  wrapper.attr("data-active", btnId);
	  $("#bar").attr("data-active", btnId);
	});

	//check if user is change remove avatar
	var userField = $("input#user");
	var avatar = $("#avatar>img");

	//if user change email or username change avatar
	userField.change(function() {
		if($(this).val() === '') {
			avatar.attr('src', 'images/logo.png')
		} else {
			avatar.attr('src', 'images/logo.png')
		}
	});

	//-------------Login  Validation -------------//
	$("#login-form1").validate({
	 
		rules: {
			user: {
				required: true,
				//minlength: 3
			}, 
			password: {
				required: true,
				//minlength: 6
			},
		code: {
				required: true,
				
			}	
		}, 
		messages: {
			user: {
				required: "Please provide a username",
				//minlength: "Username must be at least 3 characters long"
			},
			password: {
				required: "Please provide a password",
				//minlength: "Your password must be at least 5 characters long"
			},
			code: {
				required: "Please provide a Security Code",
				
			}
		},
		submitHandler: function(form){
	        var btn = $('#loginBtn');
	        btn.removeClass('btn-primary');
	        btn.addClass('btn-danger');
	        btn.text('Checking ...');
	        btn.attr('disabled', 'disabled');
	        setTimeout(function() {
	        	btn.removeClass('btn-danger');
	        	btn.addClass('btn-success');
	        	btn.text('User find ...');
	        }, 1500);
	        setTimeout(function () {
	        	form.submit();
	        }, 2000);
		}
	});
	
	//-------------Forgot Validation ----------------//
	
	$("#forgotpass").validate({ 
		rules: {
			username: {
				required: true,
				//minlength: 3
			}, 
			emailid: {
				required: true,
				email:true,
				
			},
			
		}, 
		messages: {
			username: {
				required: "Please provide a username",
				//minlength: "Username must be at least 3 characters long"
			},
			emailid: {
				required: "Please provide a emailid",
				
			},
			
		},
		submitHandler: function(form){
	        var btn = $('#loginBtn');
	        btn.removeClass('btn-primary');
	        btn.addClass('btn-danger');
	        btn.text('Checking ...');
	        btn.attr('disabled', 'disabled');
	        setTimeout(function() {
	        	btn.removeClass('btn-danger');
	        	btn.addClass('btn-success');
	        	btn.text('User find ...');
	        }, 1500);
	        setTimeout(function () {
	        	form.submit();
	        }, 2000);
		}
	});
	
	

});
