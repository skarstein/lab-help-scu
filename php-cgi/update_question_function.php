<?php
    header('Content-Type: application/json');
    require './partials/head.php';

    $data = json_decode(file_get_contents("php://input"));

    $q_id = $data->q_id;
    $question_content = $data->question_content;

    $question_content = html_entity_decode($question_content);

    $sql = mysqli_prepare($conn,"Update Question SET question_content = ? where q_id = ?");
    mysqli_stmt_bind_param($sql,"ss",$question_content,$q_id);
    $result = mysqli_execute($sql);
?>

