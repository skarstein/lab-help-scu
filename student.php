<!doctype html>

<html>
  <title>Student page</title>

  <?php include './partials/head.php';?>

  <?php
    session_start();
    $_SESSION["username"]="sean";
    $_SESSION["className"]="Coen174L";
    $_SESSION["sessionID"]="123456";
    $_SESSION["userType"]="st";

    //check if session variables are set, if not redirect to login screen

      $servername = "dbserver.engr.scu.edu";
      $username = "skarstei";
      $password = "00001015034";
      $dbname = "sdb_skarstei";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error){
          die("Connection failed: " .$conn->connect_error);
      }
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
          <form action="/~skarstei/student.php" method="POST">
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
      echo "your question is: " .$_POST["question"]. "<br>";
      $questionID=rand(0,9999999);
      echo "your question ID is: " .$questionID. "<br>";

      $sql = "INSERT INTO Question (q_id,s_id,username,question_content)
      VALUES (" .$questionID. ",'" .$_SESSION["sessionID"]. "','" .$_SESSION["username"]. "','"
      .$_POST["question"]. "')";

      if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
          
      } else {
          echo "Error: " .$sql. "<br>" .$conn->error;
      }
    }

    $sql = "SELECT q_id FROM Question WHERE s_id=" .$;
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        echo "<br> question ID: ".$row['q_id']."<br>";
    }

    $conn->close();
    ?>

  </body>
</html>

