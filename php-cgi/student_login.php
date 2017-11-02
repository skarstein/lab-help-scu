<!doctype html>

<html>
  <title>TA Help Seeking System | Student Login</title>

  <?php require './partials/head.php';?>

  <body>

    <div class="container main">
      <div class="row">
        <div class="col-sm-12 col-md-7 mx-auto">
          <h1 class="form-header">TA Help Seeking System<br />Student Login</h1>
          <form role="form" id="student_login_form" action = "student_login.php" method ="post">
            <div class="form-group">
              <label for="usernameInput">Username</label>
              <input type="text" class="form-control" name="usernameInput" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="passwordInput">Password</label>
              <input type="password" class="form-control" name="passwordInput" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="sessionIdInput">Session ID</label>
              <input type="password" class="form-control" name="sessionIdInput" placeholder="Session Id">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    
      <p id = "p"></p>
      <?php require './partials/footer.php';?>
    </div>

    <script src="assets/js/student_login_js.js"></script>
    <?php
        if (!empty($_POST["usernameInput"]) && !empty($_POST["passwordInput"]) && !empty($_POST["sessionIdInput"])) {
            session_start();

            $valid = false;
            
            $username = $_POST["usernameInput"];
            $sessionID = $_POST["sessionIdInput"];
            $password = $_POST["passwordInput"];
    
            $sql = "SELECT * FROM User WHERE username = '" .$username. "'";
            $result = $conn->query($sql);
    
            if ($result->num_rows != 1){
                $message = "'Username Not Found'";
                echo "<script>showError($message);</script>";
            } else {
                if ($result->fetch_assoc()["type"] == "ST") {
    		    mysqli_data_seek($result,0);
                    $salt = $result->fetch_assoc()["salt"];
                    $options = [
                        'salt' => $salt,
                    ];
                    //generate hashed password
                    $hashed = password_hash($password,  PASSWORD_BCRYPT, $options);
    		    mysqli_data_seek($result,0);
                    if ($result->fetch_assoc()["password"] == $hashed){
    		        mysqli_data_seek($result,0);
                        $sql = "SELECT * FROM Session WHERE s_id = '" .$sessionID. "'";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows == 1){
                            $valid = true;
                            $_SESSION["className"] = $result->fetch_assoc()["class_name"];
                        } else {
                            $message = "'Session Not Found'";
                            echo "<script>showError($message);</script>";
                        }
                    } else {
                        $message = "'Password Incorrect'";
                        echo "<script>showError($message);</script>";
                    } 
                } else {
                    $message = "'This login form is for students only'";
                    echo "<script>showError($message);</script>";
                }
            }
          
            if ($valid){
                $_SESSION["username"] = $username;
                $_SESSION["sessionID"] = $sessionID;
                $_SESSION["userType"] = "ST";
                 
                header('Location: student.php');
                exit();
            }
        }
    ?>


  </body>

</html>
