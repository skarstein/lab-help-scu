function deleteRow(row)
{
    var x = row.cells;
    var username = x[0].innerHTML;
    var question_content = x[2].innerHTML;
    var response;
    $.ajax({
        type: "POST",
        url:  "http://students.engr.scu.edu/~ngoodpas/php-cgi/delete_row_function.php",
        dataType: 'json',
        data: JSON.stringify({
            username: username,
            question_content: question_content
        }),

        success: function () {
            location.reload();    
        }
    });
}            
