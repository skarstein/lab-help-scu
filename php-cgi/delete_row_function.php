<?php
    header('Content-Type: application/json');
    require './partials/head.php';

    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $question_content = $data->question_content;
    
    //echo $username. " " .$question_content;

    //echo "<script>console.log('Logggggggged');</script>";

    $sql = mysqli_prepare($conn,"Delete from Question where username = ? AND question_content = ?");
    mysqli_stmt_bind_param($sql,"ss",$username,$question_content);
    $result = mysqli_execute($sql);

    //$result = $conn->query($sql);
     
    //header('Location: http://students.engr.scu.edu/~'.$DEV_WEB_HOME.'/php-cgi/ta.php'); 
    /*if ($result === TRUE){
        echo '{message:"Successful"}';
    } else {
        echo '{messgae:"Fail"}';
    }*/
?>

