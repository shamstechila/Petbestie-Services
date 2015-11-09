<?php
//$show = 'recoverForm';

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
$pwd1=$_POST['pwd1'];
$pwd2=$_POST['pwd2'];
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

     

<script type="text/javascript">

   
  function checkForm(form)
  {
    
    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 8) {
        alert("Error: Password must contain at least six characters!");
        form.pwd1.focus();
        return false;
      }
	  
	
      re = /[0-9]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.pwd1.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.pwd1.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.pwd1.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

    //alert("You entered a valid password: " + form.pwd1.value);
    return true;
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
			                    <form role="form" action="ForgotPassword.php" method="post" onSubmit="return checkForm(this);">
			                    	
                                    <!--
                                    <div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username" title="Username must not be blank and contain only letters, numbers and underscores." required pattern="\w+">
			                        </div>
                                    -->
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">New Password</label>
			                        	<input type="password" name="pwd1" placeholder="New Password..." class="form-password form-control" id="form-password" /> <span style="font-size:13px; color:white;">Enter atleast 8 characters, including one uppercase, one lowercase letter and one digit.</span>
			                        </div>
                                    
                                      <div class="form-group">
			                        	<label class="sr-only" for="form-password">Confirm Password</label>
			                        	<input type="password" name="pwd2" placeholder="Confirm Password..." class="form-password form-control" id="form-cpassword" />
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