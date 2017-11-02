function clearData() {
    $("#form_popup").remove();
}

function showError(message) {
    clearData();
    $("#ta_login_form").before( '<div id="form_popup" class="alert alert-danger" role="alert">' + message + '</div>');
}

function showSuccess(message) {
    clearData();
    $("#ta_login_form").before( '<div id="form_popup" class="alert alert-success" role="alert">' + message + '</div>');
}

$(document).ready(function(){
    $('input[type="radio"]').click(function() {
        if($(this).attr('name') == 'ta_action') {
            if($(this).attr('value') == 'Join') {
                $('#session_form').show();
		$('#classname_form').hide();
            }
            else {
                $('#session_form').hide();
                $('#classname_form').show();
            }
        }
    });
    $("#ta_login_form").validate({
        focusCleanup: true,
        rules: {
            usernameInput: "required",
            passwordInput: "required"
        }
    });
   
});
