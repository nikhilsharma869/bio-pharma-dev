var loginRadiusHorizontalSharingTheme = document.getElementsByName('LoginRadius_settings[horizontalSharing_theme]');
var loginRadiusVerticalSharingTheme = document.getElementsByName('LoginRadius_settings[verticalSharing_theme]');
var loginRadiusHorizontalSharingProviders;
var loginRadiusVerticalSharingProviders;

function loginRadiusCheckElement(arr, obj){
	for(var i=0; i<arr.length; i++) {
		if (arr[i] == obj) return true;
	}
	return false
}

// toggle between login and registration form
function loginRadiusToggleForm(val){
	if(val == 'login'){
		document.getElementById('loginRadiusToggleFormLink').innerHTML = 'New to LoginRadius, Register Now!';
		document.getElementById('loginRadiusToggleFormLink').setAttribute('onclick', 'loginRadiusToggleForm("register")');
		//document.getElementById('loginRadiusSubmit').value = 'Login';
		document.getElementById('loginRadiusFormTitle').innerHTML = 'Login to your LoginRadius Account to change settings as per your requirements!';
		document.getElementById('loginRadiusLoginForm').style.display = 'block';
		document.getElementById('loginRadiusRegisterForm').style.display = 'none';
	}else{
		document.getElementById('loginRadiusToggleFormLink').innerHTML = 'Already have an account?';
		document.getElementById('loginRadiusToggleFormLink').setAttribute('onclick', 'loginRadiusToggleForm("login")');
		//document.getElementById('loginRadiusSubmit').value = 'Register';
		document.getElementById('loginRadiusFormTitle').innerHTML = 'Register LoginRadius Account to change settings as per your requirements!';
		document.getElementById('loginRadiusLoginForm').style.display = 'none';
		document.getElementById('loginRadiusRegisterForm').style.display = 'block';
	}
	var loginRadiusMessage = document.getElementById('loginRadiusMessage');
	if(loginRadiusMessage){
		loginRadiusMessage.innerHTML = '';
	}
}

window.onload = function(){
	loginRadiusAdminUI2();
	loginRadiusHorizontalSharingProviders = document.getElementsByName('LoginRadius_settings[horizontal_sharing_providers][]');
	loginRadiusVerticalSharingProviders = document.getElementsByName('LoginRadius_settings[vertical_sharing_providers][]');
	loginRadiusAdminUI();
}
function loginRadiusAdminUI(){
	for(var key in loginRadiusHorizontalSharingTheme){
		if(loginRadiusHorizontalSharingTheme[key].checked){
			loginRadiusToggleHorizontalShareTheme(loginRadiusHorizontalSharingTheme[key].value);
			break;
		}
	}
	for(var key in loginRadiusVerticalSharingTheme){
		if(loginRadiusVerticalSharingTheme[key].checked){
			loginRadiusToggleVerticalShareTheme(loginRadiusVerticalSharingTheme[key].value);
			break;
		}
	}
	// if rearrange horizontal sharing icons option is empty, show seleted icons to rearrange
	if(document.getElementsByName('LoginRadius_settings[horizontal_rearrange_providers][]').length == 0){
		for(var i = 0; i < loginRadiusHorizontalSharingProviders.length; i++){
			if(loginRadiusHorizontalSharingProviders[i].checked){
				loginRadiusRearrangeProviderList(loginRadiusHorizontalSharingProviders[i], 'Horizontal');
			}
		}
	}
	// if rearrange vertical sharing icons option is empty, show seleted icons to rearrange
	if(document.getElementsByName('LoginRadius_settings[vertical_rearrange_providers][]').length == 0){
		for(var i = 0; i < loginRadiusVerticalSharingProviders.length; i++){
			if(loginRadiusVerticalSharingProviders[i].checked){
				loginRadiusRearrangeProviderList(loginRadiusVerticalSharingProviders[i], 'Vertical');
			}
		}
	}
	// user activate/deactivate toggle
	var loginRadiusStatusOption = document.getElementsByName('LoginRadius_settings[LoginRadius_enableUserActivation]');
	for(var i = 0; i < loginRadiusStatusOption.length; i++){
		if(loginRadiusStatusOption[i].checked && loginRadiusStatusOption[i].value == '1'){
			document.getElementById('loginRadiusDefaultStatus').style.display = 'table-row'; 
		}else if(loginRadiusStatusOption[i].checked && loginRadiusStatusOption[i].value == '0'){
			document.getElementById('loginRadiusDefaultStatus').style.display = 'none'; 
		}
	}
	// email required
	var loginRadiusEmailRequired = document.getElementsByName('LoginRadius_settings[LoginRadius_dummyemail]');
	for(var i = 0; i < loginRadiusEmailRequired.length; i++){
		if(loginRadiusEmailRequired[i].checked && loginRadiusEmailRequired[i].value == 'notdummyemail'){
			document.getElementById('loginRadiusPopupMessage').style.display = 'table-row'; 
			document.getElementById('loginRadiusPopupErrorMessage').style.display = 'table-row';
		}else if(loginRadiusEmailRequired[i].checked && loginRadiusEmailRequired[i].value == 'dummyemail'){
			document.getElementById('loginRadiusPopupMessage').style.display = 'none'; 
			document.getElementById('loginRadiusPopupErrorMessage').style.display = 'none';
		}
	}
	// registration redirection
	var loginRadiusCustomRadio = document.getElementById('loginRadiusCustomRegRadio');
	if(loginRadiusCustomRadio){
		if(loginRadiusCustomRadio.checked){
			document.getElementById('loginRadiusCustomRegistrationUrl').style.display = 'block';
		}else{
			document.getElementById('loginRadiusCustomRegistrationUrl').style.display = 'none';
		}
	}
	// login redirection
	var loginRadiusLoginRedirection = document.getElementsByName('LoginRadius_settings[LoginRadius_redirect]');
	for(var i = 0; i < loginRadiusLoginRedirection.length; i++){
		if(loginRadiusLoginRedirection[i].checked){
			if(loginRadiusLoginRedirection[i].value == "samepage"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "homepage"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "dashboard"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "bp"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "custom"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'block';
			}
		}
	}
	// logout redirection
	var loginRadiusLogoutRedirection = document.getElementsByName('LoginRadius_settings[LoginRadius_loutRedirect]');
	for(var i = 0; i < loginRadiusLogoutRedirection.length; i++){
		if(loginRadiusLogoutRedirection[i].checked){
			if(loginRadiusLogoutRedirection[i].value == "homepage"){
				document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'none'; 
			}else if(loginRadiusLogoutRedirection[i].value == "custom"){
				document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'block';
			}
		}
	}
}

jQuery(function(){
    jQuery("#loginRadiusHorizontalSortable, #loginRadiusVerticalSortable").sortable({
      revert: true
    });
});
// prepare rearrange provider list
function loginRadiusRearrangeProviderList(elem, sharingType){
	var ul = document.getElementById('loginRadius'+sharingType+'Sortable');
	if(elem.checked){
		var listItem = document.createElement('li');
		listItem.setAttribute('id', 'loginRadius'+sharingType+'LI'+elem.value);
		listItem.setAttribute('title', elem.value);
		listItem.setAttribute('class', 'lrshare_iconsprite32 lrshare_'+elem.value.toLowerCase());
		// append hidden field
		var provider = document.createElement('input');
		provider.setAttribute('type', 'hidden');
		provider.setAttribute('name', 'LoginRadius_settings['+sharingType.toLowerCase()+'_rearrange_providers][]');
		provider.setAttribute('value', elem.value);
		listItem.appendChild(provider);
		ul.appendChild(listItem);
	}else{
		if(document.getElementById('loginRadius'+sharingType+'LI'+elem.value)){
			ul.removeChild(document.getElementById('loginRadius'+sharingType+'LI'+elem.value));
		}
	}
}
// limit maximum number of providers selected in horizontal sharing
function loginRadiusHorizontalSharingLimit(elem){
	var checkCount = 0;
	for(var i = 0; i < loginRadiusHorizontalSharingProviders.length; i++){
		if(loginRadiusHorizontalSharingProviders[i].checked){
			// count checked providers
			checkCount++;
			if(checkCount >= 10){
				elem.checked = false;
				document.getElementById('loginRadiusHorizontalSharingLimit').style.display = 'block';
				setTimeout(function(){ document.getElementById('loginRadiusHorizontalSharingLimit').style.display = 'none'; }, 2000);
				return;
			}
		}
	}
}
// limit maximum number of providers selected in vertical sharing
function loginRadiusVerticalSharingLimit(elem){
	var checkCount = 0;
	for(var i = 0; i < loginRadiusVerticalSharingProviders.length; i++){
		if(loginRadiusVerticalSharingProviders[i].checked){
			// count checked providers
			checkCount++;
			if(checkCount >= 10){
				elem.checked = false;
				document.getElementById('loginRadiusVerticalSharingLimit').style.display = 'block';
				setTimeout(function(){ document.getElementById('loginRadiusVerticalSharingLimit').style.display = 'none'; }, 2000);
				return;
			}
		}
	}
}
// show/hide options according to the selected horizontal sharing theme
function loginRadiusToggleHorizontalShareTheme(theme){
	switch(theme){
		case '32':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case '16':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case 'single_large':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'none';
		break;
		case 'single_small':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'none';
		break;
		case 'counter_vertical':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case 'counter_horizontal':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
	}
}

// display options according to the selected counter theme
function loginRadiusToggleVerticalShareTheme(theme){
	switch(theme){
		case '32':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'none';
		break;
		case '16':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'none';
		break;
		case 'counter_vertical':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'block';
		break;
		case 'counter_horizontal':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'block';
	}
}

// assign update code function onchange event of elements
function loginRadiusAttachFunction(elems){
	for(var i = 0; i < elems.length; i++){
		elems[i].onchange = loginRadiusToggleTheme;
	}
}
function loginRadiusGetChecked(elems){
	var checked = [];
	// loop over all 
	for(var i=0; i<elems.length; i++){
		if(elems[i].checked){
			checked.push(elems[i].value);
		}
	}
	return checked;
}
function loginRadiusInterfacePosition(checkVar, elemName){
	if(elemName == "LoginRadius_settings[LoginRadius_loginform]"){
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_loginformPosition]'); 
	}else if(elemName == "LoginRadius_settings[LoginRadius_regform]"){
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_regformPosition]'); 
	}else if(elemName == "LoginRadius_settings[LoginRadius_loginformPosition]"){ 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_loginform]'); 
	}else if(elemName == "LoginRadius_settings[LoginRadius_regformPosition]"){ 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_regform]'); 
	} 
	 
	if(!checkVar){ 
		elem[0].checked = false; 
		elem[1].checked = false; 
	}else{ 
		elem[0].checked = true; 
	} 
}