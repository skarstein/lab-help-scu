<!doctype html>

<html>
  <title>Student page</title>

  <?php require './db_php/connect.php';?>
  <?php include './partials/head.php';?>

  <?php
    session_start();
    $_SESSION["username"]="sean";
    $_SESSION["className"]="Coen174L";
    $_SESSION["sessionID"]="123456";
    $_SESSION["userType"]="st";
  ?>

  <body>

    <div class="container">
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
    </div>

        <?php
        if (isset($_POST["question"])){

          $sql = "INSERT INTO Question (q_id,s_id,username,question_content)
          VALUES (" .$questionID. ",'" .$_SESSION["sessionID"]. "','" .$_SESSION["username"]. "','"
          .$_POST["question"]. "')";

          if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
              header('Location: '.$_SERVER['REQUEST_URI']);
               
          } else {
              echo "Error: " .$sql. "<br>" .$conn->error;
          }
        }

        $sql = "SELECT q_id FROM Question";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            echo "<br> question ID: ".$row['q_id']."<br>";
        }

        $conn->close();
        ?>

  </body>
</html>

