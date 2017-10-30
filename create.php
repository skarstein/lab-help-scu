<!doctype html>

<html>
  <title>Create Account</title>

  <?php include './partials/head.php';?>

  <body>
    Student
    <label class="switch">
      <input type="checkbox" onclick="toggle()">
      <span class="slider round"></span>
    </label>
    TA
    <form action="/create.html">
      Username:
      <input type="text" name="username"/>
      <br>
      Password:
      <input type="password" name="password"/>
      <br>
      Confirm Passowrd:
      <input type="password" name="confpassword"/>
      <br>
      <div id="myDIV" style="display:none;">
        TA Cridential:
        <input type="text" name="TA Cridential"/>
      </div>
    </form>

    <script src="/~blee/assets/js/create_js.js"></script>
  </body>
</html>