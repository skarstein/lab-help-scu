<!doctype html>

<html>
  <title>Student page</title>

  <?php require './partials/head.php';?>

  <?php
    session_start();
    //$_SESSION["className"]="Coen174L";
    //$_SESSION["sessionID"]="123456";
    //$_SESSION["userType"]="st";
    //$_SESSION["username"]="sean";
    if (! isset($_SESSION["username"])){
       header('Location: http://students.engr.scu.edu/~'.$DEV_WEB_HOME.'/student_login.php'); 
    }
    if ($_SESSION["userType"]=="TA"){
        header('Location: ta.php');
    }
  ?>

  <body>

    <div class="container main">
    <div class="page-header">
      <h1>
        <?php 
        echo "your username is: " .$_SESSION["username"]. "<br>";
        echo "your class name is: " .$_SESSION["className"]. "<br>";
        ?>
      </h1>
    </div>
      <div class="row">
        <div class="col">
          <form action="" method="POST">
            <div class="form-group">
              <label for="question">Question:</label>
              <input type="text" class="form-control" name="question" placeholder="Question"/>
            </div>
            <div class="form-group">
              <input type="submit" value="Submit">
            </div>
          </form>
        </div>
      </div>

        <?php
        if (isset($_POST["question"])){

          $questionID=rand(0,9999999);
          $sql = "INSERT INTO Question (q_id,s_id,username,question_content)
          VALUES (" .$questionID. ",'" .$_SESSION["sessionID"]. "','"
          .$_SESSION["username"]. "','" .$_POST["question"]. "')";

          if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
              header('Location: '.$_SERVER['REQUEST_URI']);
               
          } else {
              echo "Error: " .$sql. "<br>" .$conn->error;
          }
        }

        $sql = "SELECT * FROM Question WHERE (username = '" .$_SESSION["username"]. "') 
        AND s_id='" .$_SESSION['sessionID']. "' ORDER BY t_stamp DESC";
        $result = $conn->query($sql);
        ?>

      <table class="table">
        <thead>
          <tr>
            <th>Question ID</th>
            <th>Session ID</th>
            <th>Time</th>
            <th>Question</th>
            <th>Answer</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()){
          echo 
            "<tr>
              <td>".$row['q_id']."</td>
              <td>".$row['s_id']."</td>
              <td>".$row['t_stamp']."</td>
              <td>".$row['question_content']."</td>
              <td>".$row['answer_content']."</td>
            </tr>";
        }

        $conn->close();
         
        ?>
        </tbody>
      </table>
    </div>
  </body>
</html>

