<!doctype html>

<html>

    <?php require './db_php/connect.php';?>
    <?php include './partials/head.php';?>

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
        /*
        $sql = "SELECT * from User WHERE username = 'sean'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            foreach($row as $cname => $cval){
                echo " " .$cname. ": " .$cval. "\n";
            }
        }
         */

        $username = $_POST["usernameInput"];
        
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $sessionId = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 10; $i++) {
            $sessionId .= $characters[mt_rand(0, $max)];
        }

        $password = $_POST["passwordInput"];

        $sql = "SELECT * FROM User WHERE username = '" .$username. "'";
        $result = $conn->query($sql);

        if ($result->num_rows != 1){
            echo "Username Not Found\n";
            //echo $result->fetch_assoc()["username"];
        } else {
            if ($result->fetch_assoc()["type"] == "TA") {
                if ($result->fetch_assoc()["password"] == $password){


          $sql = "INSERT INTO Session (s_id,class_name) VALUES (" .$questionID. ",'" .$_SESSION["sessionID"]. "','" .$_SESSION["username"]. "','"
          .$_POST["question"]. "')";

          if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
              header('Location: '.$_SERVER['REQUEST_URI']);
               
          } else {




                    $sql = "SELECT * FROM Session WHERE s_id = '" .$sessionId. "'";
                    $result = $conn->query($sql);
                
                    if ($result->num_rows == 1){
                        echo "SUCESS";
                        $valid = true;
                        $_SESSION["className"] = $result->fetch_assoc()["class_name"];
                    } else {
                        echo "Session Not Found";
                    }
                } else {
                    echo "Password Incorrect";
                } 
            } else {
                echo "This login form is for ta's only";
            }
        }

        if ($valid){
            $_SESSION["username"] = $username;
            $_SESSION["sessionId"] = $sessionId;
            $_SESSION["className"] = "st";
             
            header('Location: http://students.engr.scu.edu/~skarstei/student.php');
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
