<!doctype html>

<html>
  <title>Create Account</title>

  <?php include './partials/head.php';?>

  <body>

    <div class="container">
      <div class="row">
        <div class="col">

        <!--
          Student
          <label class="switch">
            <input type="checkbox" onclick="toggle()">
            <span class="slider round"></span>
          </label>
          TA
          -->

  

          <form action="/create.php" method="POST">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="student_type" value="student" checked="checked"> Student
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="student_type" value="ta"> TA
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

            <?php if(isset($student_type) && $student_type=="ta") { ?> 
              <div id="myDIV" class="form-group">
                <label for="tacred">TA Cridential:</label>
                <input type="text" class="form-control" name="tacred"/>
              </div>
            <?php } ?>

          </form>

        </div>
      </div>
    </div>

    <script src="/~blee/assets/js/create_js.js"></script>
  </body>
</html>