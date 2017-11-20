function showModalWithData(row){
    var x = row.cells;
    console.log(row);
    var timestamp = x[2].innerHTML;
    var q_id = x[0].innerHTML;
    var username = x[1].innerHTML;
    var question_content = x[3].innerHTML;
    var answer_content = x[4].innerHTML;
    $('#questionID').val(q_id);
    $('#answerModalTitle').html(timestamp);
    $('#question-content').html(question_content);
    $('#answer-content').html(answer_content);
    $('#username').html("User: " + username);
    $('#answerModal').modal('show');
}    

function showDeleteModal(q_id){
    console.log(q_id);
    $('#deleteQuestionID').val(q_id);
    $('#deleteModal').modal('show');
}
