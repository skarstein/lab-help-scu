<!doctype html>

<html>

  <title>TA Help Seeking System | Create Account</title>

  <?php require './partials/head.php';?>

  <body>

    <div class="container main">
      <div class="row">
        <div class="col-sm-12 col-md-7 mx-auto">
          <h1 class="form-header">Create a New Account</h1>
          <form id="create_account_form" action="" method="POST">
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
              <div class="invalid" id="invalid-usernameempty"></div>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
            </div>
            <div class="form-group">
              <label for="confpassword">Confirm Password:</label>
              <input type="password" class="form-control" name="confpassword" placeholder="Retype Password"/>
            </div>
            <div id="tacred_form" class="form-group" style="display:none">
              <label for="tacred">TA Credential:</label>
              <input type="password" class="form-control" name="tacred" placeholder="TA Credential"/>
            </div>
            <button id="#create_submit" type="submit" class="btn btn-primary center">Create Account</button>
          </form>
        </div>
      </div>
      <?php require './partials/footer.php';?>
    </div>


    <script type="text/javascript" src="assets/js/create_js.js"></script>

    <?php 
      if(isset($_GET['success'])){
        $status = $_GET['success'];
        if($status == 'true') {
          $message = "'New account created successfully'";
          echo "<script>showSuccess($message);</script>";
        }
<<<<<<< HEAD
      }
    ?>


    <?php

    $validated = false;



    if (isset($_POST["username"], $_POST["password"], $_POST["confpassword"], $_POST["student_type"])) {
      if ($_POST["password"] !== $_POST["confpassword"]) {
         $message = "Passwords do not match.";
         echo $message;
      }
      else {
        //Password Hashing:
        //start by generating salt
        $salt = openssl_random_pseudo_bytes(22);
        $options = [
          'salt' => $salt,
        ];
        //generate hashed password
        $hashed = password_hash($_POST["password"],  PASSWORD_BCRYPT, $options);
        //heck if ta cred is filled in
        if ($_POST["tacred"] !== '') {
          //if tacred is correct, create ta account
          if($_POST["tacred"] == "tempkey") {
            //insert hashed password and salt into User table for TA
            $sql = "INSERT INTO User VALUES ('" .$_POST["username"]. "','" .$salt. "','" .$hashed. "','" .$_POST["student_type"]. "')";
=======
        else {
          //Password Hashing:
          //start by generating salt
          $salt = openssl_random_pseudo_bytes(22);
          $options = [
            'salt' => $salt,
          ];
          //generate hashed password
          $hashed = password_hash($_POST["password"],  PASSWORD_BCRYPT, $options);
          //heck if ta cred is filled in
          $username = ($_POST["username"]);
          if ($_POST["tacred"] !== '') {
            //if tacred is correct, create ta account
            if($_POST["tacred"] == "tempkey") {
              //insert hashed password and salt into User table for TA
              $sql = "INSERT INTO User VALUES ('" .$username. "','" .$salt. "','" .$hashed. "','" .$_POST["student_type"]. "')";
              $validated = true;
            }
            $message = "TA Credential Incorrect.";
            echo $message;
          }
          //if tacred is blank, create student accoutn:
          else {
            //insert hashed password and salt into User table for student
            $sql = "INSERT INTO User VALUES ('" .$username. "','" .$salt. "','" .$hashed. "','" .$_POST["student_type"]. "')";
>>>>>>> 442f9cc4fd9d91cbe1d6bb53c0d09eb03114dc96
            $validated = true;
          }
          else {
            $message = "'TA Credential Incorrect.'";
            echo "<script>showError($message);</script>";
          }
        }
        //if tacred is blank, create student accoutn
        else {
          //insert hashed password and salt into User table for student
          $sql = "INSERT INTO User VALUES ('" .$_POST["username"]. "','" .$salt. "','" .$hashed. "','" .$_POST["student_type"]. "')";
          $validated = true;
        }
      }
    }
    if ($validated) {
      if ($conn->query($sql) === TRUE) {
        header('Location: create.php?success=true');
      } 
      else {
        $message = "'Error: could not create account'";
        echo "<script>showError($message);</script>";
      }
    }
    $sql = "SELECT username, password, type FROM User";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        echo "<br> username: ".$row['username']." ".$row['password']."<br>"." ".$row['type']."<br>";
    }

    $conn->close();
    ?>
  </body>
</html>
