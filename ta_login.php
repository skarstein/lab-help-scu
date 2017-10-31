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
      <form role="form" action = "ta_login.php" method ="post">
        <div class="form-group">
          <label for="usernameInput">Username</label>
          <input type="text" class="form-control" name="usernameInput" placeholder="Enter Username">
        </div>
        <div class="form-group">
          <label for="passwordInput">Password</label>
          <input type="password" class="form-control" name="passwordInput" placeholder="Password">
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="ta_action" value="Create" checked="checked"> Create
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="ta_action" value="Join"> Join
          </label>
        </div>
        <div id="session_form" class="form-group"style="display:none">
          <label for="sessionIdInput">Session Id</label>
          <input type="text" class="form-control" name="sessionIdInput" placeholder="Session Id">
        </div>
        <div id="classname_form" class="form-group">
          <label for="classNameInput">Class Name</label>
          <input type="text" class="form-control" name="classNameInput" placeholder="Class Name">
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
        if (isset($_POST["username"], $_POST["password"], $_POST["confpassword"], $_POST["student_type"])) {
            $valid = false;
            $username = $_POST["usernameInput"];
            $action = $_POST["ta_action"];
            if ($action == "Join"){
        	    if (isset($_POST["sessionIdInput"])) {
                    $sessionID = $_POST["sessionIdInput"];    
	    	    } else {
		            echo "Please Enter a Session Key";
		            exit();		
		        }
            } else {
        	    if (isset($_POST["classNameInput"])) {
		            $className = $_POST["classNameInput"]; 
                    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                    $sessionID = '';
                    $max = strlen($characters) - 1;
                    for ($i = 0; $i < 10; $i++) {
                	    $sessionID .= $characters[mt_rand(0, $max)];
                    }
            	} else {
		            echo "Please Enter a Class Name";
		            exit();
                }
            } 
            echo "session: " .$sessionID;           
            $password = $_POST["passwordInput"];
            $sql = "SELECT * FROM User WHERE username = '" .$username. "'";
            $result = $conn->query($sql);
            if ($result->num_rows != 1){
                echo "Username Not Found\n";
                //echo $result->fetch_assoc()["username"];
            } else {
                if ($result->fetch_assoc()["type"] == "TA") {
	                if ($result->fetch_assoc()["password"] == $password){
		                if ($action == "Join"){
			                $sql = "SELECT * FROM Session WHERE s_id = '" .$sessionID. "'";
                            $result = $conn->query($sql);
                            if ($result->num_rows == 1){
                                echo "SUCESS";
		                        session_start();
                                $valid = true;
                                $_SESSION["className"] = $result->fetch_assoc()["class_name"];
                            } else {                            
				                echo "Session Not Found";
	                        }    
    			        } else {
			                $sql = "INSERT INTO Session (s_id,class_name) VALUES ('" .$sessionID. "','" .$className. "')";
			                if ($conn->query($sql) === TRUE) {
				                echo "New record created successfully";
                         	    session_start();
			    	            $valid = true;
			                    $_SESSION["className"] = $className;
                            } else {
				                echo "Error Creating Record";
			                }
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
                $_SESSION["type"] = "TA";
                header('Location: http://students.engr.scu.edu/~skarstei/ta.php');
                exit();
            }
        }
    ?>

    <!--Welcome <?php echo $_SESSION["username"]; ?><br>
    Your session is: <?php echo $_SESSION["sessionId"]; ?> -->


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

    <script type="text/javascript" src="assets/js/ta_login_js.js"></script>
  </body>

</html>
