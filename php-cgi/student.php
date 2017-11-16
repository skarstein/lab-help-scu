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
    if(! empty($_GET["delete"])){
        $sql="DELETE FROM Question WHERE q_id = '" .$_GET['delete']. "'";
        $result = $conn->query($sql);
        header('Location: student.php');
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
              <button class="btn btn-primary" type="submit" value="Submit" style="float: left;">Submit</button>
            </div>
          </form>
          <form>
            <input class="btn btn-primary" type="submit" value="Refresh Questions" style="float: right;"/>
          </form>
          <br>
          <br>
          <br>
        </div>
      </div>

        <?php
        if (! empty($_POST["question"])){

          $questionID=rand(0,9999999);
          $question = $_POST["question"];

          $sql_insert = mysqli_prepare($conn,"INSERT INTO Question (q_id,s_id,username,question_content) VALUES (?,?,?,?)");
          mysqli_stmt_bind_param($sql_insert,"ssss",$questionID,$_SESSION["sessionID"],$_SESSION["username"],$question);

          if (mysqli_execute($sql_insert) === TRUE) {
              echo "New record created successfully";
              header('Location: '.$_SERVER['REQUEST_URI']);
               
          } else {
              echo "Error: " .$sql_insert. "<br>" .$conn->error;
          }
        }

        $sql = "SELECT q_id,UNIX_TIMESTAMP(t_stamp), question_content, answer_content FROM Question WHERE (username = '" .$_SESSION["username"]. "') 
        AND s_id='" .$_SESSION['sessionID']. "' ORDER BY ";
        

        if (!empty($_GET['sort'])){
            $sort = $_GET['sort']; 
        } else {
            $sort = "t_stamp";
        }

        if (!empty($_GET['dir'])){
            $dir = $_GET['dir'];
        } else {
            $dir = "DESC";
        }

        $sql .= $sort. " " .$dir;

        if ($dir == "DESC"){
            $dir = "ASC";
        } else {
            $dir = "DESC";
        }
 
        $result = $conn->query($sql);
        

        echo '
      <table class="table">
        <col width="80">
        <col width="500">
        <col width="500">
        <col width="100">
        <thead>
          <tr>
            <th><a href="student.php?sort=t_stamp&dir='.$dir.'">Time</th>
            <th><a href="student.php?sort=question_content&dir='.$dir.'">Question</th>
            <th><a href="student.php?sort=answer_content&dir='.$dir.'">Answer</th>
            <th></th>
          </tr>
        </thead>
        <tbody>';
        
        while($row = $result->fetch_assoc()){
          $date = date("g:ia m/d/y",$row['UNIX_TIMESTAMP(t_stamp)']);
          echo 
            "<tr>
              <td style='display:none;'>".$row['q_id']."</td>
              <td>".$date."</td>
              <td>".htmlspecialchars($row['question_content'])."</td>
              <td>".htmlspecialchars($row['answer_content'])."</td>
              <td>
                <form>
                    <input class='btn btn-primary' value='View' onclick='showModalWithData(this.parentNode.parentNode.parentNode)' style='width:80px; float: right;'/>
                </form>
                <form>
                    <button type='submit' class='btn btn-secondary' name='delete' value='".$row['q_id']."' style='width:80px; float: right;'>Delete</button>
                </form>
              </td>
            </tr>";
        }

        $conn->close();
         
        ?>
        </tbody>
      </table>




      <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="questionModalTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="question-content" class="form-control-label">Question:</label>
                  <textarea class="form-control" id="question-content"></textarea>
                </div>
                <div class="form-group">
                  <label for="answer_content" class="form-control-label">Answer:</label>
                  <textarea class="form-control" id="answer-content" readonly></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              <form>
                <input class='btn btn-primary' type='submit' value='Save Question' onclick='updateQuestion(this.parentNode.parentNode)'/>
              </form>
            </div>
          </div>
        </div>
      </div>




      <?php require './partials/footer.php';?>
      <form action="" method="POST">
        <div class="form-group" style="text-align:center;">
          <button class="btn btn-primary" type="submit" name="logout" value="logout">Logout</button>
        </div>
      </form>
    </div>

    <script src="assets/js/student_js.js"></script>
  </body>
</html>

