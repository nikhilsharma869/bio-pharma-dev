jQuery(function($) {

	/***** STEP 1 *****/
	$('#OptionsFramework-import-file').change(function() {
		if ($('#OptionsFramework-import-file').val()) {
			$('#optionsForm input[type="submit"]').removeAttr('disabled');
		} else {
			$('#optionsForm input[type="submit"]').attr('disabled','disabled');
		}
	});

	function foo() {
		if (($('.import-options-settings').closest('#wpbody-content').find('div').hasClass('error')) == false) {
			$('.progress').addClass('active').show().find('.bar').stop().animate({width:'34%'}, {duration:1500});
		};
	}

	$('#optionsForm input[type="submit"]').click(function() {
		foo();
	});

	/***** STEP 2 *****/
	$('#upload-file').change(function() {
		if ($('#upload-file').val()) {
			$('#upload-widget-data input[type="submit"]').removeAttr('disabled');
		} else {
			$('#upload-widget-data input[type="submit"]').attr('disabled','disabled');
		}
	});

	$('#import-widgets').click(function() {
		$('.import-widget-settings').closest('#wpbody-content').find('.progress').addClass('active').show().find('.bar').delay(1000).stop().animate({width:'67.5%'}, {duration:2500});
	});

	$('.import-widget-settings').closest('#wpbody-content').find('.progress').show().find('.bar').css({width: '34%'});
	$('.import-widget-settings').closest('#wpbody-content').find('.progress .step2').addClass('in-progress');
	$('.import-widget-settings').closest('#wpbody-content').find('.progress .step1').removeClass('in-progress').addClass('success');

	/***** STEP 3 *****/
	$('#import-upload-form input[type="submit"]').attr('disabled','disabled');
	$('#upload').change(function() {
		if ($('#upload').val()) {
			$('#import-upload-form input[type="submit"]').removeAttr('disabled');
		} else {
			$('#import-upload-form input[type="submit"]').attr('disabled','disabled');
		}
	});

	$('#user-wrap select').change(function() {
		currSelectText = $('#user-wrap select :selected').text();
		selectText = $('#user-wrap option:first-child').text();
		if (selectText != currSelectText) {
			$('#dataForm input[type="submit"]').removeAttr('disabled');
		} else {
			$('#dataForm input[type="submit"]').attr('disabled','disabled');
		}
	});

	$('#dataForm input[type="submit"]').click(function() {
		$('.import-data').closest('#wpbody-content').find('.progress').addClass('active').show().find('.bar').stop().css({width: '67.5%'}).animate({width:'100%'}, {duration:150000});
	});

	if (location_func()) {
		$('.import-data').closest('#wpbody-content').find('.progress').show().find('.bar').css({width: '100%'});
		$('.import-data').closest('#wpbody-content').find('.progress .step1').removeClass('in-progress').addClass('success');
		$('.import-data').closest('#wpbody-content').find('.progress .step2').removeClass('in-progress').addClass('success');
		$('.import-data').closest('#wpbody-content').find('.progress .step3').removeClass('in-progress').addClass('success');
	} else {
		$('.import-data').closest('#wpbody-content').find('.progress').show().find('.bar').css({width: '67.5%'});
		$('.import-data').closest('#wpbody-content').find('.progress .step1').removeClass('in-progress').addClass('success');
		$('.import-data').closest('#wpbody-content').find('.progress .step2').addClass('success');
		$('.import-data').closest('#wpbody-content').find('.progress .step3').addClass('in-progress');
	}

	
	if (isPermalinksSettings()) {
		if ($('#message').hasClass('updated')) {
			redirect_to_cherry_options();
		};
	};

	function location_func() {
		var strLoc = window.location.href;	
		if (strLoc.indexOf('step=4') + 1) {
			return true;
		} else {
			return false;
		}
	}

	function isPermalinksSettings() {
		var str = window.location.href;	
		if (str.indexOf('options-permalink.php') + 1) {
			return true;
		} else {
			return false;
		}
	}

	function redirect_to_cherry_options() {
		window.location.replace('admin.php?page=options-framework');
	}
});