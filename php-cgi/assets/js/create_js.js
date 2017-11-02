function clearData() {
    $("#form_popup").remove(); 
}

function showError(message) {
    clearData();
    $("#create_account_form").before( '<div id="form_popup" class="alert alert-danger" role="alert">' + message + '</div>');
}

function showSuccess(message) {
    clearData();
    $("#create_account_form").before( '<div id="form_popup" class="alert alert-success" role="alert">' + message + '</div>');
}

$(document).ready(function(){

    $('input[type="radio"]').click(function() {
        if($(this).attr('name') == 'student_type') {
            if($(this).attr('value') == 'TA') {
                $('#tacred_form').show();
            }
            else {
                $('#tacred_form').hide();
            }
        }
    });

    $("#create_account_form").validate({
        focusCleanup: true,
        rules: {
            // simple rule, converted to {required:true}
            username: {
                required: true,
                rangelength: [5,20]
            },
            // compound rule
            password: {
                required: true,
                rangelength: [5,20]
            },
            confpassword: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            username: {
                required: "Please define a username.",
                rangelength: "Username is not the correct length (5-20 characters)."
            },
            // compound rule
            password: {
                required: "Please define a password.",
                rangelength: "password is not the correct length (5-40 characters)."
            },
            confpassword: {
                required: "Please retype your password.",
                equalTo: "Passwords do not match.",
            }
        }
    });

});
