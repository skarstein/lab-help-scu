function showModalWithData(row){
    var x = row.cells;
    var timestamp = x[1].innerHTML;
    var q_id = x[0].innerHTML;
    var question_content = x[2].innerHTML;
    var answer_content = x[3].innerHTML;
    $('#questionID').val(q_id);
    $('#questionModalTitle').html(timestamp);
    $('#question-content').html(question_content);
    $('#answer-content').html(answer_content);
    $('#questionModal').modal('show');
}

function showStudentDeleteModal(q_id){
    $('#stDeleteQuestionID').val(q_id);
    $('#stDeleteModal').modal('show');
}
