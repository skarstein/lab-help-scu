<!doctype html>

<html>
  <title>TA Help Seeking System | TA Questions</title>

  <?php require './partials/head.php';?>

  <?php
    echo "<script>console.log('Hello')</script>";
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

    if (! empty($_POST["delete"])){
      if (! empty($_POST["delete-id"])){
        $sql="DELETE FROM Question WHERE q_id = '" .$_POST["delete-id"]. "'";
        $result = $conn->query($sql);
        header('Location: student.php');
      } else {
        echo "<script>console.log('No q_id')</script>";
      }
    } else {
      echo "<script>console.log('No delete')</script>";
    }

    if (! empty($_POST['answer-content'])){
      if (! empty($_POST['q_id'])){
        $answer_content = $_POST['answer-content'];
        $q_id = $_POST['q_id'];
        $answer_content = html_entity_decode($answer_content);

        $sql = mysqli_prepare($conn,"Update Question SET answer_content = ? where q_id = ?");
        mysqli_stmt_bind_param($sql,"ss",$answer_content,$q_id);
        $result = mysqli_execute($sql);
      } else {
        echo "<script>console.log('No q_id')</script>";
      }
    } else {  
      echo "<script>console.log('No answer')</script>";
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
      <form>
        <button class="btn btn-success" type="submit" style="float: right;"/><i class="fa fa-refresh" aria-hidden="true"></i>
Refresh Questions</button>
      </form> 
      <br>
      <br>
      <br>
      <div class="row">
        <div class="col-12">
          <?php
            $sql = "SELECT q_id,UNIX_TIMESTAMP(t_stamp),username,question_content,answer_content FROM Question WHERE s_id='" .$_SESSION['sessionID']. "' ORDER BY ";



        if (!empty($_GET['sort'])){// == 'time')
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
                <th><a href="ta.php?sort=username&dir='.$dir.'">Student</th>
                <th><a href="ta.php?sort=t_stamp&dir='.$dir.'">Time</th>
                <th><a href="ta.php?sort=question_content&dir='.$dir.'">Question</th>
                <th><a href="ta.php?sort=answer_content&dir='.$dir.'">Answer</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            ';

            while($row = $result->fetch_assoc()){
              $ans_button = "Answer";
              if ($row['answer_content'] != null){
                  $ans_button = "View";
              }
              $date = date("g:ia m/d/y",$row['UNIX_TIMESTAMP(t_stamp)']);
              echo 
                "<tr class='normal'>
                  <td style='display:none;'>".$row['q_id']."</td>
                  <td>".$row['username']."</td>
                  <td>".$date."</td>
                  <td class='word-wrap monospace'>".htmlspecialchars($row['question_content'])."</td>
                  <td class='word-wrap monospace'>".htmlspecialchars($row['answer_content'])."</td>
                  <td>
                    <form>
                        <input class='btn btn-primary' value='".$ans_button."' onclick='showModalWithData(this.parentNode.parentNode.parentNode)' style='width:80px; float: right;'/>
                    </form>
                    <form>
                        <button class='btn btn-link text-danger' value='Delete' onclick='showDeleteModal(".$row['q_id'].")' style='width:80px; float: right;'><i class='fa fa-trash-o' aria-hidden='true' style='margin-right:4px;'>Delete</button>
                    </form>
                  </td>
                </tr>";
            }

            $conn->close();
             
            ?>
            </tbody>
          </table>
        </div>
      </div>


      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalTitle">Confirm Deletion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <p>Are you sure you want to delete this question?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="" method="POST"id="new-form">
                  <input form ="new-form" type="text" id="deleteQuestionID" name="delete-id" style='display:none;'>
                  <input class='btn btn-primary' type='submit' name="delete" value='Delete Question'>
                </form>
              </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="answerModalTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" id="answer-form">
              <input form="answer-form" class="modal-title" id="questionID" name="q_id" style='display:none;'>
              <div class="modal-body">
                <p id='username'></p>
                <div class="form-group">
                  <label for="question-content" class="form-control-label">Question:</label>
                  <textarea class="form-control monospace" id="question-content" readonly></textarea>
                </div>
                <div class="form-group">
                  <label for="answer-content" class="form-control-label">Answer:</label>
                  <textarea form="answer-form" class="form-control monospace" name="answer-content" id="answer-content"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input class='btn btn-primary' type='submit' value='Save Answer'>
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
    <script src="assets/js/ta_js.js"></script>
  </body>
</html>

