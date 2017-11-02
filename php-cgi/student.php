<!doctype html>

<html>

  <title>TA Help Seeking System | Student Home</title>

  <title>Student page</title>

  <?php require './partials/head.php';?>

  <?php
    session_start();
    if (! isset($_SESSION["username"])){
       header('Location: http://students.engr.scu.edu/~'.$DEV_WEB_HOME.'/php-cgi/student_login.php'); 
    }
    if ($_SESSION["userType"]=="TA"){
        header('Location: ta.php');
    }
    if(! empty($_POST["logout"])){
        session_destroy();
        header('Location: student_login.php');
    }
  ?>

  <body>

    <div class="container main">
      <div class="row">
        <div class="home-top col-12 col-md-5 center">
          <h1>
            <?php 
            echo "Username: " .$_SESSION["username"]. "<br>";
            echo "Class Name: " .$_SESSION["className"]. "<br>";
            echo "Session ID: " .$_SESSION["sessionID"]. "<br>";
            ?>
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <form action="" method="POST">
            <div class="form-group">
              <label for="question">Question:</label>
              <textarea type="text" class="form-control" name="question" placeholder="Question"/></textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" value="Submit">Submit</button>
            </div>
          </form>
        </div>
      </div>

        <?php
        if (isset($_POST["question"])){

          $questionID=rand(0,9999999);
          $question = $_POST["question"];
          $question = strip_tags($question);
          $question = str_replace('"', "'", $question);
          $sql = "INSERT INTO Question (q_id,s_id,username,question_content)
          VALUES (" .$questionID. ",\"" .$_SESSION["sessionID"]. "\",\""
          .$_SESSION["username"]. "\",\"" .$question. "\")";

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
      <form action="" method="POST">
        <div class="form-group" style="text-align:center;">
          <button class="btn btn-primary" type="submit" name="logout" value="logout">Logout</button>
        </div>
      </form>
    </div>
  </body>
</html>

