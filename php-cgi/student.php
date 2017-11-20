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
        $q_id = $_GET["delete"];
        $sql = mysqli_prepare($conn,"Delete from Question where q_id = ?");
        mysqli_stmt_bind_param($sql,"s",$q_id);
        $result = mysqli_execute($sql);
        header('Location: student.php');
    }

    if (! empty($_POST['question-content'])){
      if (! empty($_POST['q_id'])){
        $question_content = $_POST['question-content'];
        $q_id = $_POST['q_id'];
        $question_content = html_entity_decode($question_content);

        $sql = mysqli_prepare($conn,"Update Question SET question_content = ? where q_id = ?");
        mysqli_stmt_bind_param($sql,"ss",$question_content,$q_id);
        $result = mysqli_execute($sql);
      } else {
        echo "<script>console.log('No q_id')</script>";
      }
    } else {  
      echo "<script>console.log('No question')</script>";
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
              <textarea type="text" class="form-control monospace" name="question" placeholder="Question"/></textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" value="Submit" style="float: left;">Submit</button>
            </div>
          </form>
          <form>
            <button class="btn btn-success" type="submit" style="float: right;"/><i class="fa fa-refresh" aria-hidden="true"></i>
Refresh Questions</button>
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
            "<tr class='normal'>
              <td style='display:none;'>".$row['q_id']."</td>
              <td>".$date."</td>
              <td class='word-wrap monospace'>".htmlspecialchars($row['question_content'])."</td>
              <td class='word-wrap monospace'>".htmlspecialchars($row['answer_content'])."</td>
              <td>
                <form>
                    <input class='btn btn-primary' value='View' onclick='showModalWithData(this.parentNode.parentNode.parentNode)' style='width:80px; float: right;'/>
                </form>
                <form>
                    <button type='submit' class='btn btn-link text-danger' name='delete' value='".$row['q_id']."' style='width:80px; float: right;'><i class='fa fa-trash-o' aria-hidden='true' style='margin-right:4px;'></i>Delete</button>
                </form>
              </td>
            </tr>";
        }

        $conn->close();
         
        ?>
        </tbody>
      </table>




      <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="questionModalTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" id="question-form">
              <input form="question-form" class="modal-title" id="questionID" name="q_id" style='display:none;'>
              <div class="modal-body">
                <div class="form-group">
                  <label for="question-content" class="form-control-label">Question:</label>
                  <textarea form="question-form" class="form-control monospace" name="question-content" id="question-content"></textarea>
                </div>
                <div class="form-group">
                  <label for="answer-content" class="form-control-label">Answer:</label>
                  <textarea class="form-control monospace" id="answer-content" readonly></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <input class='btn btn-primary' type='submit' value='Save Question'>
              </div>
            </form>
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

