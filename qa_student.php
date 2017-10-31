<!doctype html>

<html>

    <?php include './partials/head.php';?>
    <?php require './db_php/connect.php';?>

  <body>

    <div class="container">
      <div class="row">
        <div class="col">
          <h1>TA Help Seeking System</h1>
        </div>
      </div>
      <form role="form" action = "qa_student.php" method ="post">
        <div class="form-group">
          <label for="usernameInput">Username</label>
          <input type="text" class="form-control" name="usernameInput" placeholder="Enter Username">
        </div>
        <div class="form-group">
          <label for="passwordInput">Password</label>
          <input type="password" class="form-control" name="passwordInput" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="sessionIdInput">Session Id</label>
          <input type="password" class="form-control" name="sessionIdInput" placeholder="Session Id">
        </div>
        <!-- <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input type="file" id="exampleInputFile">
          <p class="help-block">Example block-level help text here.</p>
        </div> -->
<!--         <div class="checkbox">
          <label>
            <input type="checkbox"> Check me out
          </label>
        </div> -->
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <p id = "p"></p>  
    </div>

    <?php 
        session_start();

        $valid = false;
        
        
        
        //    $_SESSION["username"] 
        $username = $_POST["usernameInput"];
        //$_SESSION["sessionId"] 
        $sessionId = $_POST["sessionIdInput"];
        $password = $_POST["passwordInput"];

        $sql = "SELECT username,password FROM User WHERE username = (" .$username. ")";
        $result = $conn->query($sql);

        if ($result->num_rows != 1){
            echo "Username Not Found";
        } else {
            if ($result->fetch_assoc()["password"] == $password){
                $sql = "SELECT * FROM Session WHERE s_id = (" .$sessionId. ")";
                $result = $conn->query($sql);
                
                if ($result->num_rows == 1){
                    echo "SUCESS";
                    $valid = true;
                } else {
                    echo "Session Not Found";
                }
            } else {
                echo "Password Incorrect";
            } 
        }

        if ($valid){
            $_SESSION["username"] = $username;
            $_SESSION["sessionId"] = $sessionId;
             
            header('Location: students.engr.scu.edu/~skarstei/student.php');
            exit();
        }

    ?>

    Welcome <?php echo $_SESSION["username"]; ?><br>
    Your session is: <?php echo $_SESSION["sessionId"]; ?> 


<!--    <script>
        var p = document.getElementById("p")
        var password = document.getElementById("passwordInput")
        var username = document.getElementById("usernameInput")
        var sessionId = document.getElementById("sessionIdInput")

        function handleSubmitButtonClick(){
            p.innerHTML = username + " : " + password + " : " + sessionId
            //Check if credentials are accurate
            //Hide Form, and load Questions
            //
        }
    </script> -->
  </body>

</html>
