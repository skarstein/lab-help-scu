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
            $sql = "SELECT UNIX_TIMESTAMP(t_stamp),username,question_content,answer_content FROM Question WHERE s_id='" .$_SESSION['sessionID']. "' ORDER BY ";



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

              </tr>
            </thead>
            <tbody>
            ';

            while($row = $result->fetch_assoc()){
              $date = date("g:ia m/d/y",$row['UNIX_TIMESTAMP(t_stamp)']);
              echo 
                "<tr>
                  <td>".$row['username']."</td>
                  <td>".$date."</td>
                  <td>".htmlspecialchars($row['question_content'])."</td>
                  <td>".htmlspecialchars($row['answer_content'])."</td>
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

