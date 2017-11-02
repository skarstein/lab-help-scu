function clearData() {
    $("#form_popup").remove();
}

function showError(message) {
    clearData();
    $("#student_login_form").before( '<div id="form_popup" class="alert alert-danger" role="alert">' + message + '</div>');
}

function showSuccess(message) {
    clearData();
    $("#student_login_form").before( '<div id="form_popup" class="alert alert-success" role="alert">' + message + '</div>');
}

$(document).ready(function(){
	$("#student_login_form").validate({
        focusCleanup: true,
        rules: {
	    	usernameInput: "required",
        	passwordInput: "required",
        	sessionIdInput: "required"
        }
    });
   
});
