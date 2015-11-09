  	<?php
	error_reporting(0);
/*
		Webservice for get all comment list for a particular post.
		Project Name :  PetBestie
		Created By   : MD. Shamsad Ahmed
        Created Date : 04th August 2015
		Usage        : This file is used for login user with Book of Accounts .
		How it works : We simply take Username and Password from user and matches with our db entry 
		               and give success and error responses accordingly.
			Copyright@Techila Solutions
	*/
		
	//Database Connection
	//ini_set( "display_errors", 0);
	
	include_once('DBConnect.php');
	include_once('Abstract/classResponse.php');	
	
	function validateEmaiUser()
	{
		$rm=new Response_Methods();		
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
		$result=$rm->inValidServerMethod();
		return $result;
		}
		
		  //Check request url is https or not
       if(!empty($_SERVER["HTTPS"])){
			
			if($_SERVER["HTTPS"]!=="off") {
	 	
		$emailId = $rm->cleanData($_POST['emailId']);
		$userName = $rm->cleanData($_POST['userName']);
 //die();
       	
		$getArrayList = array();
		if($emailId == "" || $userName == "")
		{
			$result = $rm->fields_validation();
			return $result;
		}
		else
		{
			
			$checkUser=$rm->checkUserValidation($userName,'user_name_f');
			$checkEmail=$rm->checkUserValidation($emailId,'email_f');
			if($checkUser==0)
				{
					$result=$rm->userExistJson();
					return $result;
				}
			if($checkEmail==0)
				{
					$result=$rm->emailExistJson();
					return $result;
				}	
			
			if($checkUser==1 && $checkEmail==1)	
			{
					$result=$rm->userEmailAvailable();
					return $result;
			}
				
		  
		  
		}// end of else first
		
		}
		else {
			
				$result = $rm->ssl_error();
			    return $result;
			}
			
		} 
		else {
		      
			  $result = $rm->ssl_error();
			  return $result;
		}
									
		
   }	
	
	echo validateEmaiUser();
?>