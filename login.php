<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Everest - Log In/Register</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="css/login2.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />

<link rel="stylesheet" type="text/css" href="../css/header_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>



  <!-- HEADER -->
  <div id="header" style="z-index:1000;">
    <div style="float:left;height:50px;width:15%;min-width:120px;">
      <a href="/">
        <img type="everest_logo" src="/imgs/everest-logo.png" alt="Everest Logo" style="padding-left:28px;width: 107px;" />
      </a>
    </div>

    <a href="index.php" style="color:white;margin-left: 75%;position: absolute;top: 15px;"> <strong>X</strong> Cancel</span>
    </a>
    <!-- for modal login <a href="#"style="color:white;margin-left: 75%;position: absolute;top: 15px;" onclick="document.getElementById('id01').style.display='block'" ><span class="glyphicon glyphicon-log-in"> Login</span> </a> -->
  </div>
  <!-- End of Div header -->

  <!-- main page code -->

  <section>

    <div id="container">
      <a class="hiddenanchor" id="toregister"></a>
      <a class="hiddenanchor" id="tologin"></a>
      <div id="wrapper">
        <div id="login" class="animate form">
          <form action="" method="post" autocomplete="on">
            <h1>Log in</h1>
            <?php  

                if(isset($_COOKIE['kli']) != ""){//if a user previously selected to keep logged in
                  $val = $_COOKIE['kli'];
                  echo '
                      <p>
                        <label for="username" class="uname" data-icon="u"> Your email</label>
                        <input id="username" name="username" value = '.$val.' required="required" type="text" placeholder="eg. johndoe@everest.com" />
                      </p>

                  ';    

                }else{
                 echo' <p>
                    <label for="username" class="uname" data-icon="u"> Your email</label>
                    <input id="username" name="username" required="required" type="text" placeholder="eg. johndoe@everest.com" />
                  </p>
                ';
                }
            ?>
            
            <p>
              <label for="password" class="youpasswd" data-icon="p"> Your password </label>
              <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" />
            </p>
            <p class="keeplogin">
              <input type="checkbox" name="loginsupplier" id="loginsupplier" value="loginsupplier" />
              <label for="loginsupplier" style="margin-left: 6px;"> Login as supplier</label>
            </p>

            <?php  

                if(isset($_COOKIE['kli']) != ""){
                  echo'
                    <p class="keeplogin">
                      <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" checked = "checked" />
                      <label for="loginkeeping">Keep me logged in</label>
                    </p>
                  ';
                }else{
                  echo'
                    <p class="keeplogin">
                      <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" />
                      <label for="loginkeeping">Keep me logged in</label>
                    </p>
                  ';

                }

            ?>
            <p class="login button">
              <input type="submit" value="Log In" />
            </p>
            <?php
                  include("./configlogin.php");
                  session_start();
                  
                  if($_SERVER["REQUEST_METHOD"] == "POST") {
                      // username and password sent from form

                      $myusername = mysqli_real_escape_string($db,$_POST['username']);
                      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

                      if (isset($_POST['loginsupplier'])) { //if login as supplier is checked
                          $sql = "SELECT * FROM team_best_rds.tbl_supplier WHERE email = '$myusername' and pwd = '$mypassword'";
                          $result = mysqli_query($db,$sql);
                          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                          $name = $row['name']; 
                          $uid = $row['supplierID'];

                          $count = mysqli_num_rows($result);

                          if($count == 1) {
                            //session_register("myusername");
                            $_SESSION['login_user'] = $myusername;

                            setcookie(email, $myusername, time() + (1800), "/");
                            setcookie(name, $name, time() + (1800), "/");
                            setcookie(UID, $uid, time() + (1800), "/");
                            setcookie(sup, 1, time() + (1800), "/"); //if 1 => a supplier is logged in
                            
                            if (isset($_POST['loginkeeping'])){
                              setcookie(kli,$myusername, time() + (86400 * 90), "/" ); //if keep logged in is checked
                            }else{
                              setcookie(kli,"", time() + (86400 * 90), "/" );
                            }

                            header("location: /mysupplieraccount.php");
                          }else {
                            echo "<script type='text/javascript'>alert('Incorrect Email/Password Combination')</script>";
                          }
                        } else{//if logging in as a regular user
                          $sql = "SELECT * FROM team_best_rds.tbl_users WHERE email = '$myusername' and pwd = '$mypassword'";
                          $result = mysqli_query($db,$sql);
                          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                          //$active = $row['active'];
                          $name = $row['FirstName']; 
                          $uid = $row['userID'];
                          
                          $count = mysqli_num_rows($result);
                          
                          // If result matched $myusername and $mypassword, table row must be 1 row
                        
                          if($count == 1) {
                            //session_register("myusername");
                            $_SESSION['login_user'] = $myusername;

                            setcookie(email, $myusername, time() + (1800), "/");
                            setcookie(name, $name, time() + (1800), "/");
                            setcookie(UID, $uid, time() + (1800), "/");
                            
                            
                            if (isset($_POST['loginkeeping'])){
                              setcookie(kli,$myusername, time() + (86400 * 90), "/" ); //if keep logged in is checked
                            }else{
                              setcookie(kli,"", time() + (86400 * 90), "/" );
                            }
                            header("location: /index.php");
                          }else {
                            echo "<script type='text/javascript'>alert('Incorrect Email/Password Combination')</script>";
                          }
                        }
                  }
                ?>
              <p class="change_link">
                Not a member yet ?
                <a href="#toregister" class="to_register">Register Here</a>
              </p>
          </form>
        </div>

        <div id="register" class="animate form">
          <form action="register.php" method="post" autocomplete="on">

            <h1> Sign up </h1>
            <p>
              <label for="usernamesignup" class="uname" data-icon="u">First Name or Company Name</label>
              <input id="usernamesignup" name="fnamesignup" required="required" type="text" placeholder="John or Everest Inc" />
            </p>
            <p>
              <label for="usernamesignup" class="uname" data-icon="u">Last Name </label>
              <input id="usernamesignup" name="lnamesignup" type="text" placeholder="Doe (leave blank if registering as a supplier)" />
            </p>
            <p>
              <label for="emailsignup" class="youmail" data-icon="e"> Your email</label>
              <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="johndoe@everest.com" />
            </p>
            <p>
              <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
              <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="Please enter an alphanumeric password..."
              />
            </p>
            <p>
              <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
              <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="Please re-enter your password..."
              />
            </p>
            <p class="regsupplier">
              <input type="checkbox" name="regsupplier" id="regsupplier" value="regsupplier" />
              <label for="regsupplier">Register as supplier</label>
            </p>

            <p class="signin button">
              <input type="submit" value="Sign up" />
            </p>


            <p class="change_link">
              Already a member ?
              <a href="#tologin" class="to_register"> Go and log in </a>
            </p>
          </form>
        </div>

      </div>
    </div>
  </section>
  <!-- end of main code -->

  <script>
    /*script for password confirmation*/

    var password = document.getElementById("passwordsignup"),
      confirm_password = document.getElementById("passwordsignup_confirm");

    function validatePassword() {
      if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
  </script>

</body>

</html>