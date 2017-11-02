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
                rangelength: "Username is not the correct length (4-20 characters max)."
            },
            // compound rule
            password: {
                required: "Please define a password.",
                rangelength: "password is not the correct length (4-40 characters max)."
            },
            confpassword: {
                required: "Please retype your password.",
                equalTo: "Passwords do not match.",
            }
        }
    });

    function showError(message) {
        $("#form_error").remove();
        $("#create_account_form").before( '<div id="form_error" class="alert alert-danger" role="alert">${message}</div>');
    }
    
});
