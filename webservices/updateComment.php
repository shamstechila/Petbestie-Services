  	<?php
	error_reporting(0);
/*
		Webservice for update comments.
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
	function updateComment()
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
			
			
		$comment =  $rm->cleanData($_POST['comment']); //Get Request From Device		
		$commentId =  $rm->cleanData($_POST['commentId']); 
		       	
		$getArrayList = array();
		//echo $ENCRYPTEDPWD = md5($PASSWORD);	
		//echo $ENCRYPTEDPWD = base64_decode($PASSWORD);	
		//$ENCRYPTEDPWD=$PASSWORD;
		if( $comment == "" || $commentId == "")
		{
			$result = $rm->fields_validation();
			return $result;
		}
		else
		{
		  
		  
		  	$getInsertFieldValue['comment_text_f']=$comment;			
			$affectedRowsUpdateComment=$rm->update_record($getInsertFieldValue,'comments_t','comment_id',$commentId);					
		
			if($affectedRowsUpdateComment>0)
			{
		    $result = $rm->updateCommentSuccessJson($commentId);
		    return $result;
			}
			else
			{
			$result=$rm->updateCommentFailJson();
			return $result;	
			}
		}
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
	
	echo updateComment();
?>