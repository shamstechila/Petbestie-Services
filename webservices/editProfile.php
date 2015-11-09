	<?php
	error_reporting(0);
	/**
		* Get User Details and Add into database.
		* Created by: MD. Shamsad Ahmed
	
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('Abstract/classResponse.php');//
	function editProfile()
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
		
		$userId = $rm->cleanData(trim($_POST['userId']));
		$username = $rm->cleanData(trim($_POST['username']));
		
		
		$petType = $rm->cleanData(trim($_POST['petType']));
		$petBio = $rm->cleanData(trim($_POST['petBio']));
		$petName =$rm->cleanData(trim($_POST['petName']));
		$petDob = trim($_POST['petDob']);
		$petSpecies = $rm->cleanData(trim($_POST['petSpecies']));
		

				
		if($userId == "" || $petType=="" || $petBio == "" || $petName == "" || $petDob=="" || $petSpecies=="")
		{
			
			$result = $rm->fields_validation();		
			return $result;
		}
		
		else
		{
					$getList = array();
					$IMAGEURLBASEURL=BASEURL.'/images/';					
					$userImageBaseURL="images/$username";
					
					if (!is_dir($userImageBaseURL)) 
						// is_dir - tells whether the filename is a directory
						{
							//mkdir - tells that need to create a directory
							
							mkdir($userImageBaseURL);
							mkdir($userImageBaseURL.'/profile_pics/');
							//mkdir($userImageBaseURL.'/post_photos/');
						}
						
					$rand=rand(00,99999);
					//$_REQUEST['profile_pic']=21;
					
					//echo 'test';
					if(isset($_POST['profile_pic']) and $_POST['profile_pic']!="")
					{
					$profile_pic = trim($_POST['profile_pic']); //blob image data

					$img = 'data:image/png;base64,'.$profile_pic.'';
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$image ='petbestie_user_'.$rand.'.png';
					
		            $target_dir = $userImageBaseURL."/profile_pics/";
					$test=$rm->emptyDirectory($target_dir);
					file_put_contents($userImageBaseURL.'/profile_pics/'.$image, $data);	
					//file_put_contents($userImageBaseURL.'/profile_pics/'.$image, $data);	
					$IMAGEURL = $IMAGEURLBASEURL.$username.'/profile_pics/'.$image;		
					
					$getUpdateProfilePic['profile_pic_f']=$IMAGEURL;	
					}
					
					//echo $getUpdateProfilePic['profile_pic_f'];
					$getUpdateProfilePic['pet_type_f']=$petType;	
					$getUpdateProfilePic['pet_name_f']=$petName;
					$getUpdateProfilePic['pet_dob_f']=$petDob;
			        $getUpdateProfilePic['description_f']=$petBio;	
					$getUpdateProfilePic['species_f']=$petSpecies;	
			
					$updateResult=$rm->update_record($getUpdateProfilePic,'user_details_t','user_id',$userId);	
					if($updateResult>0)
					{				
					$result=$rm->userRegisterSuccessJson($userId);
					return $result;	
					}
					else
					{
						$result=$rm->userUpdateProfileFail();
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
	
	echo editProfile();
?>