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
});
