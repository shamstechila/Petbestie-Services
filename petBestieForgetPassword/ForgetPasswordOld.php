<?php
error_reporting(0);
include("../petbestieServices/DBConnect.php");
include_once('../petbestieServices/Abstract/classResponse.php');
$rm=new Response_Methods();	
if(isset($_GET['status']) && isset($_GET['u']) && isset($_GET['email']))
{

$show = 'invalidKey';
$result = $rm->checkEmailKey($_GET['email'],urldecode(base64_decode($_GET['u'])));
if($result['status']== true)
{
$show = 'recoverForm';	
}

}


if(isset($_GET['pass']) && $_GET['pass']=="success")
{
$show = 'passUpdateSuccess';	
}
else if(isset($_GET['pass']) && $_GET['pass']=="fail")
{
$show = 'passUpdateFail';	
}

//echo $show;
if($_POST['update'])
{
$user_id=$_POST['user_id'];
//die('test');
$pwd1=$_POST['form-password'];
$pwd2=$_POST['form-cpassword'];
$key=$_POST['key'];

$updatePwd=$rm->updateUserPassword($user_id,$pwd1,$key);
if($updatePwd==true)
{
echo "<meta http-equiv='refresh' content='0;url=ForgotPassword.php?pass=success'>";
}
else
{
echo "<meta http-equiv='refresh' content='0;url=ForgotPassword.php?pass=fail'>";
}


}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Petbestie Reset Password</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
<!--
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
-->
        
        <script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation

    var checkPassword = function(str)
    {
      var re = /^(?=.*[A-Z]).{6,}$/;
      return re.test(str);
    };

    var checkForm = function(e)
    {
      if(this.form-username.value == "") {
        alert("Error: Username cannot be blank!");
        this.form-username.focus();
        e.preventDefault(); // equivalent to return false
        return;
      }
      re = /^\w+$/;
      if(!re.test(this.form-username.value)) {
        alert("Error: Username must contain only letters, numbers and underscores!");
        this.form-username.focus();
        e.preventDefault();
        return;
      }
      if(this.form-password.value != "" && this.form-password.value == this.form-cpassword.value) {
        if(!checkPassword(this.form-password.value)) {
          alert("The password you have entered is not valid!");
          this.form-password.focus();
          e.preventDefault();
          return;
        }
      } else {
        alert("Error: Please check that you've entered and confirmed your password!");
        this.form-password.focus();
        e.preventDefault();
        return;
      }
      alert("Both username and password are VALID!");
    };

    var myForm = document.getElementById("myForm");
    myForm.addEventListener("submit", checkForm, true);

    // HTML5 form validation

    var supports_input_validity = function()
    {
      var i = document.createElement("input");
      return "setCustomValidity" in i;
    }

    if(supports_input_validity()) {
      var usernameInput = document.getElementById("form-username");
      usernameInput.setCustomValidity(usernameInput.title);

      var pwd1Input = document.getElementById("form-password");
      pwd1Input.setCustomValidity(pwd1Input.title);

      var pwd2Input = document.getElementById("form-cpassword");

      // input key handlers

      usernameInput.addEventListener("keyup", function() {
        usernameInput.setCustomValidity(this.validity.patternMismatch ? usernameInput.title : "");
      }, false);

      pwd1Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd1Input.title : "");
        if(this.checkValidity()) {
          pwd2Input.pattern = this.value;
          pwd2Input.setCustomValidity(pwd2Input.title);
        } else {
          pwd2Input.pattern = this.pattern;
          pwd2Input.setCustomValidity("");
        }
      }, false);

      pwd2Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd2Input.title : "");
      }, false);

    }

  }, false);

</script>

<script type="text/javascript">
window.onload = function () {
	document.getElementById("form-password").onchange = validatePassword;
	document.getElementById("form-cpassword").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("form-cpassword").value;
var pass1=document.getElementById("form-password").value;
if(pass1!=pass2)
	document.getElementById("form-cpassword").setCustomValidity("Passwords Don't Match");
else
	document.getElementById("form-cpassword").setCustomValidity('');	 
//empty string means no validation error
}
</script>

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">

<?php if($show=="recoverForm" || $show=="passUpdateFail")
{
?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                       
                            <h1><strong>PetBesties</strong> Reset Password</h1>
                            <div class="description">
                            	<p>
	                            	You can reset your password below, then return to your app to login.
	                            
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
<?php if($show=="passUpdateFail")
{
echo "<h3 style='color:#f3765e !important;'>Password Reset Failed.Try Again.</h3>";
}
else
echo "<h3>Reset Your Password</h3>";
?>
                        			
                            		<p>Enter new password and confirm password to reset:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="ForgotPassword.php" method="post" class="login-form" id="myForm">
			                    	
                                    <!--
                                    <div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username" title="Username must not be blank and contain only letters, numbers and underscores." required pattern="\w+">
			                        </div>
                                    -->
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">New Password</label>
			                        	<input type="password" name="form-password" placeholder="New Password..." class="form-password form-control" id="form-password"  title="Password must contain at least 6 characters, including one UPPER case letter"  required pattern="(?=.*[A-Z]).{6,}" >
			                        </div>
                                    
                                      <div class="form-group">
			                        	<label class="sr-only" for="form-password">Confirm Password</label>
			                        	<input type="password" name="form-cpassword" placeholder="Confirm Password..." class="form-password form-control" id="form-cpassword" title="Please enter the same Password as above." required pattern="(?=.*[A-Z]).{6,}">
			                        </div>
 <input type="hidden" name="user_id" value="<?php echo urldecode(base64_decode($_GET['u'])); ?>" />
 <input type="hidden" name="key" value="<?php echo $_GET['email']; ?>" />
			                        <input type="submit" class="btn" name="update" value="RESET" /> 
			                    </form>
		                    </div>
                        </div>
                    </div>
</div>
                   <?php
}

if($show=="passUpdateSuccess")
{
?>

 <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                       
                            <h1><strong>PetBesties</strong> Reset Password</h1>
                            <div class="description">
                            	<p>
	                            	<strong><span style="font-size:20px;">Success!!!!</span> Your new password has been set.Return to your app to login.</strong>
	                            
                            	</p>
                            </div>
                        </div>
                    </div>
</div>

<?php
}

if($show=="invalidKey")
{
?>

 <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                       
                            <h1><strong>Invalid Key</strong></h1>
                            <div class="description">
                            	<p>
	                            	The key that you entered was invalid. Either you did not copy the entire key from the email, you are trying to use the key after it has expired (1 day after request), or you have already used the key in which case it is deactivated.
	                            
                            	</p>
                            </div>
                        </div>
                    </div>
</div>

<?php
}
?>
                
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>