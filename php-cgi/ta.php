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
                        <button class='btn btn-link text-danger' type='submit' name='delete' value='".$row['q_id']."' style='width:80px; float: right;'><i class='fa fa-trash-o' aria-hidden='true' style='margin-right:4px;'></i>Delete</button>
                    </form>
                    
                  </td>
                </tr>";
              
//                <form>
//                    <input class='btn btn-primary' type='submit' value='Answer' style='float: right;'/>
//                </form>"; 
            }

            $conn->close();
             
            ?>
            </tbody>
          </table>
        </div>
      </div>



      <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="answerModalTitle"></h5>
              <h6 class="modal-title" id="questionID" style='display:none;'></h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id='username'></p>
              <form>
                <div class="form-group">
                  <label for="question-content" class="form-control-label">Question:</label>
                  <textarea class="form-control monospace" id="question-content" readonly></textarea>
                </div>
                <div class="form-group">
                  <label for="answer_content" class="form-control-label">Answer:</label>
                  <textarea class="form-control monospace" id="answer-content"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              <form>
                <input class='btn btn-primary' type='submit' value='Save Answer' onclick='updateAnswer(this.parentNode.parentNode)'/>
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
    <script src="assets/js/ta_js.js"></script>
  </body>
</html>

