function deleteRow(row)
{
    var x = row.cells;
    var q_id = x[0].innerHTML;

    $.ajax({
        type: "POST",
        url:  "http://students.engr.scu.edu/~ngoodpas/php-cgi/delete_row_function.php",
        dataType: 'json',
        data: JSON.stringify({
            q_id: q_id,
        }),

        success: function (result) {
            console.log(result.status);
            location.reload(true);
        }
    });
}



function showModalWithData(row){
    var x = row.cells;
    console.log(row);
    var timestamp = x[1].innerHTML;
//    var username = x[1].innerHTML;
    var question_content = x[2].innerHTML;
    var answer_content = x[3].innerHTML;
    $('#questionModalTitle').html(timestamp);
    $('#question-content').html(question_content);
    $('#answer-content').html(answer_content);
//    $('#username').html("User: " + username);
    $('#questionModal').modal('show');
}



function updateQuestion(row){

    var q_id = document.getElementById('questionModalTitle').innerHTML;
    var question_content = document.getElementById('question-content').value;
    $.ajax({
        type: "POST",
        url:  "http://students.engr.scu.edu/~ngoodpas/php-cgi/update_question_function.php",
        dataType: 'json',
        data: JSON.stringify({
            q_id: q_id,
            question_content: question_content
        }),
        success: function () {
            location.reload();
        }
    });
}                

