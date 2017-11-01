<!doctype html>

<html>
  <title>Create Account</title>

  <?php require './db_php/connect.php';?>
  <?php include './partials/head.php';?>

  <body>

    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Create a New Account</h1>
          <form action="" method="POST">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="student_type" value="ST" checked="checked"> Student
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="student_type" value="TA"> TA
              </label>
            </div>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="username" placeholder="Username"/>  
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" placeholder="Password"/>
            </div>
            <div class="form-group">
              <label for="confpassword">Confirm Password:</label>
              <input type="password" class="form-control" name="confpassword" placeholder="Retype Password"/>
            </div>

            <div id="tacred_form" class="form-group" style="display:none">
              <label for="tacred">TA Credential:</label>
              <input type="password" class="form-control" name="tacred" placeholder="TA Credential"/>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
          </form>
        </div>
      </div>
    </div>

      <?php

      $validated = false;
      if (isset($_POST["username"], $_POST["password"], $_POST["confpassword"], $_POST["student_type"])) {
        if ($_POST["password"] !== $_POST["confpassword"]) {
           $message = "Passwords do not match.";
           echo $message;
        }
        else {
          if ($_POST["tacred"] !== '') {
            if($_POST["tacred"] == "tempkey") {
              $sql = "INSERT INTO User VALUES ('" .$_POST["username"]. "','" .$_POST["password"]. "','" .$_POST["student_type"]. "')";
              $validated = true;
            }
            $message = "TA Credential Incorrect.";
            echo $message;
          }
          else {
            $sql = "INSERT INTO User VALUES ('" .$_POST["username"]. "','" .$_POST["password"]. "','" .$_POST["student_type"]. "')";
            $validated = true;
          }
        }
      }
      if ($validated) {
        if ($conn->query($sql) === TRUE) {
          echo "New account created successfully";
          header('Location: '.$_SERVER['REQUEST_URI']);   
        } 
        else {
          echo "Error: could not create account";
        }
      }

      $sql = "SELECT username, password, type FROM User";
      $result = $conn->query($sql);

      while($row = $result->fetch_assoc()){
          echo "<br> username: ".$row['username']." ".$row['password']."<br>"." ".$row['type']."<br>";
      }

      $conn->close();
      ?>

    <script type="text/javascript" src="assets/js/create_js.js"></script>
  </body>
</html>
