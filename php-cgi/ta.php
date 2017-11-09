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
    if(! empty($_POST["logout"])){
        session_destroy();
        header('Location: ta_login.php');
    }
  ?>

  <body>

    <div class="container main">
      <div class="row">
        <div class="home-top col-12 col-md-5 center">
          <h1>
            <?php 
            echo "" .$_SESSION["className"]. " Q&A Session " .$_SESSION["sessionID"]. "<br>";
            echo "your username is: " .$_SESSION["username"]. "<br>";
            ?>
          </h1>
        </div>
      </div>
      <form>
        <input class="btn btn-primary" type="submit" value="Refresh Questions" style="float: right;"/>
      </form> 
      <br>
      <div class="row">
        <div class="col-12">
          <?php
          $sql = "SELECT * FROM Question WHERE (s_id = '" .$_SESSION["sessionID"]. "') ORDER BY t_stamp DESC";
          $result = $conn->query($sql);
          ?>

          <table class="table">
            <thead>
              <tr>
                <th>Student</th>
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
        </div>
      </div>


      <?php require './partials/footer.php';?>
      <form action="" method="POST">
        <div class="form-group" style="text-align:center;">
          <button class="btn btn-primary" type="submit" name="logout" value="logout">Logout</button>
        </div>
      </form>
    </div>
  </body>
</html>

