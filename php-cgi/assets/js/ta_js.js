function deleteRow(row)
{
    var x = row.cells;
    var q_id = x[0].innerHTML;

    var response;
    $.ajax({
        type: "POST",
        url:  "http://students.engr.scu.edu/~ngoodpas/php-cgi/delete_row_function.php",
        dataType: 'json',
        data: JSON.stringify({
            q_id: q_id,
        }),

        success: function () {
            location.reload(forceGet);    
        }
    });
}           

function showModalWithData(row){
    var x = row.cells;
    console.log(row);
    var timestamp = x[2].innerHTML;
    var q_id = x[0].innerHTML;
    var username = x[1].innerHTML;
    var question_content = x[3].innerHTML;
    var answer_content = x[4].innerHTML;
    $('#questionID').html(q_id);
    $('#answerModalTitle').html(timestamp);
    $('#question-content').html(question_content);
    $('#answer-content').html(answer_content);
    $('#username').html("User: " + username);
    $('#answerModal').modal('show');
}    

function updateAnswer(row){

    var q_id = document.getElementById('questionID').innerHTML;
    var answer_content = document.getElementById('answer-content').value;

    $.ajax({
        type: "POST",
        url:  "http://students.engr.scu.edu/~ngoodpas/php-cgi/update_answer_function.php",
        dataType: 'json',
        data: JSON.stringify({
            q_id: q_id,
            answer_content: answer_content
        }),

        success: function () {
            location.reload(forceGet);    
        }
    });


}
    
