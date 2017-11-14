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

        success: function () {
            location.reload();    
        }
    });
}            
