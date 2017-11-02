<!doctype html>

<html>

  <title>TA Help Seeking System | TA Login</title>

  <?php require './partials/head.php';?>

  <body>

    <div class="container main">
      <div class="row">
        <div class="col-sm-12 col-md-7 mx-auto">
          <h1 class="form-header">TA Help Seeking System<br />TA Login</h1>
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
              <label for="sessionIdInput">Session ID</label>
              <input type="text" class="form-control" name="sessionIdInput" placeholder="Session Id">
            </div>
            <div id="classname_form" class="form-group">
              <label for="classNameInput">Class Name</label>
              <input type="text" class="form-control" name="classNameInput" placeholder="Class Name">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          <p id = "p"></p>
        </div>
      </div>
    
      <?php require './partials/footer.php';?>
    </div>

    <?php
        if (!empty($_POST["usernameInput"]) && !empty($_POST["passwordInput"]) && !empty($_POST["ta_action"]) && (!empty($_POST["classNameInput"]) || !empty($_POST["sessionIdInput"]))) {
            $allSet = true;
            $valid = false;
            $username = $_POST["usernameInput"];
            $action = $_POST["ta_action"];
            if ($action == "Join"){
        	    //if (isset($_POST["sessionIdInput"])) {
                    $sessionID = $_POST["sessionIdInput"];    
	    	    //} else {
		    //        echo ("Please Enter a Session Key");
                    //$allSet = false;
                    //exit();		
		    //    }
            } else {
         	    $className = $_POST["classNameInput"]; 
                    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                    $sessionID = '';
                    $max = strlen($characters) - 1;
                    for ($i = 0; $i < 10; $i++) {
                	    $sessionID .= $characters[mt_rand(0, $max)];
                }      
            }
            //if ($allSet){ 
                $password = $_POST["passwordInput"];
                $sql = "SELECT * FROM User WHERE username = '" .$username. "'";
                $result = $conn->query($sql);
    	
    
                if ($result->num_rows != 1){
                    echo "Username Not Found\n";
                } else {
                    if ($result->fetch_assoc()["type"] == "TA") {
    		        mysqli_data_seek($result,0);
                        $salt = $result->fetch_assoc()["salt"];
                        $options = [
                                'salt' => $salt,
                        ];
                        //generate hashed password
                        $hashed = password_hash($password,  PASSWORD_BCRYPT, $options);
                        echo "hashed is: " .$hashed. "<br>";
                        mysqli_data_seek($result,0);
                        echo "password is: " .$result->fetch_assoc()["password"]. "<br>";
                        mysqli_data_seek($result,0);
    	                if ($result->fetch_assoc()["password"] == $hashed){
    		                mysqli_data_seek($result,0);
    		                if ($action == "Join"){
    			                $sql = "SELECT * FROM Session WHERE s_id = '" .$sessionID. "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows == 1){
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
                    $_SESSION["sessionID"] = $sessionID;
                    $_SESSION["userType"] = "TA";
                    header('Location: ta.php');
                    exit();
                }
            //}
        } else {
            echo "Please Fill In Every Box";
        }
?>


    <script type="text/javascript" src="assets/js/ta_login_js.js"></script>
  </body>

</html>
