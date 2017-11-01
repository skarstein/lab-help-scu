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
});
