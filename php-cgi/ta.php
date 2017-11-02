<!doctype html>

<html>
  <title>TA Help Seeking System | TA Questions</title>

  <?php require './partials/head.php';?>

  <?php
    session_start();
    if (! isset($_SESSION["username"])){
       header('Location: http://students.engr.scu.edu/~'.$DEV_WEB_HOME.'/php-cgi/ta_login.php'); 
    }
    if ($_SESSION["userType"]=="ST"){
      header('Location: student.php');
    }
  ?>

  <body>

    <div class="container main">
    <div class="page-header">
      <h1>
        <?php 
        echo "" .$_SESSION["className"]. " Q&A Session " .$_SESSION["sessionID"]. "<br>";
        echo "your username is: " .$_SESSION["username"]. "<br>";
        ?>
      </h1>
    </div>
      <div class="row">
        <div class="col">
        </div>
      </div>

        <?php
        $sql = "SELECT * FROM Question WHERE (s_id = '" .$_SESSION["sessionID"]. "') ORDER BY t_stamp DESC";
        $result = $conn->query($sql);
        ?>

      <table class="table">
        <thead>
          <tr>
            <th>Question ID</th>
            <th>Session ID</th>
            <th>Asker</th>
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
              <td>".$row['username']."</td>
              <td>".$row['t_stamp']."</td>
              <td>".$row['question_content']."</td>
              <td>".$row['answer_content']."</td>
            </tr>";
          
        }

        $conn->close();
         
        ?>
        </tbody>
      </table>
      <?php require './partials/footer.php';?>
    </div>
  </body>
</html>

