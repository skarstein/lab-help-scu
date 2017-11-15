<?php
    header('Content-Type: application/json');
    require './partials/head.php';

    $data = json_decode(file_get_contents("php://input"));

    $q_id = $data->q_id;
    $answer_content = $data->answer_content;

    $answer_content = html_entity_decode($answer_content);

    $sql = mysqli_prepare($conn,"Update Question SET answer_content = ? where q_id = ?");
    mysqli_stmt_bind_param($sql,"ss",$answer_content,$q_id);
    $result = mysqli_execute($sql);
?>

