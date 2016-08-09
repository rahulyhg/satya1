<?php
namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mail;  
use Zend\Mime;  
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage; 

use Zend\Session\Container;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UserController extends AppController
{
    public function signupAction()
    {

    	$uri = $this->getRequest()->getUri();
    $scheme = $uri->getScheme();
    $host = $uri->getHost();
    $base = sprintf('%s://%s', $scheme, $host).baseurlserve;
		    



    // echo ;die;
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$user_typeList=$this->getUserTypeTable()->selectList(array('id', 'user_type'));
		 $gothraList=$this->getGothraTable()->selectList(array('id', 'gothra_name'));
		$professionList=$this->getProfessionTable()->selectList(array('id', 'profession'));
		$country_name=$this->getCountryTable()->selectList(array('id', 'country_name'));
		//$rustagi_branches=$this->getRustagiBranchTable()->selectList(array('branch_id', 'branch_name'));
		$name_Title=$this->GetNameTitle();		
		\Application\Form\SignupForm::$userTypeList=$user_typeList;
	    \Application\Form\SignupForm::$gothraGothramList=$gothraList;
		\Application\Form\SignupForm::$professionTypeList=$professionList;
		\Application\Form\SignupForm::$country_nameList=$country_name;	
		//\Application\Form\SignupForm::$rustagi_branchList=$rustagi_branches;	
        \Application\Form\SignupForm::$name_TitleList=$name_Title;

        $action = $this->getEvent()->getRouter()->assemble(array(), array('name'=>'home', 'force_canonical'=>true))."user/chkduplicate";

        \Application\Form\SignupForm::$chkduplicateurl=$action;


		$signupform = new \Application\Form\SignupForm();
		$request=$this->getRequest();
		if($request->isPost()){	          	
		  $user=$this->getUserTable()->select(function(Select $select) use($request){
                                               $select->where->nest
														->equalTo('email',$request->getPost('email'))->or
														->equalTo('mobile_no',$request->getPost('mobile_no'));
											}); 
          if(!$user->count()){
			$page = new \Application\Model\Entity\User();
			$signupform->setInputFilter($page->getInputFilter());
			$signupform->setData($request->getPost());
			$data = (array) $request->getPost();			
			if ($signupform->isValid()) {
				$page->exchangeArray($data);				
				unset($page->inputFilter);								
				$SaveUserData["id"]=$page->id;
				$SaveUserData["user_type_id"]=$page->user_type_id;
				$SaveUserData["username"]=$page->username;
				$SaveUserData["password"]=$page->password;
				$SaveUserData["mobile_no"]=$page->mobile_no;
				$SaveUserData["email"]=$page->email;





				$act_code = md5($page->email);
				$id=$this->getUserTable()->saveUser($SaveUserData,$act_code);				
				//********User Mail********
				if($id>0){
						/******Generate User Unique Reference Number*************/
					$dateYear=date('y');
						if($dateYear>26){
							$dateYear=$dateYear-26;
							$dateYear=64+$dateYear;
							$dateYear=chr($dateYear);
						   $dateYear="A".$dateYear;
						}
						else{
							$dateYear=64+$dateYear;
							$dateYear=chr($dateYear);
						}
					$full_nameArray=explode(' ',$page->full_name);
					if(count($full_nameArray)>1){
						$first=strtoupper(substr($full_nameArray[0],0,1));
						$last=strtoupper(substr($full_nameArray[1],0,1));
						$referenceNo=$dateYear.$first.$last.$id;
					}else{
						$first=strtoupper(substr($full_nameArray[0],0,2));						
						$referenceNo=$dateYear.$first.$id;
					}					
					/**************end generate reference number and update to userTable*****************/
				    $adapter->query("UPDATE tbl_user SET ref_no='$referenceNo' where id='$id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
					$msg="Account Created Successfully";
					$this->getEmailLogsTable()->saveEmailLogs($id,$msg);
					$user=$this->getUserTable()->select(array('id' =>(int) $id));
					foreach($user as $currentUser);
					$SaveUserInfo["id"]=$page->id;
					$SaveUserInfo["user_id"]=$id;
					$SaveUserInfo["ref_no"]=$currentUser->ref_no;
					$SaveUserInfo["user_type_id"]=$page->user_type_id;
					$SaveUserInfo["name_title_user"]=$page->name_title_user;
					$SaveUserInfo["full_name"]=$page->full_name;
					$SaveUserInfo["gender"]=$page->gender;
					$SaveUserInfo["native_place"]=$page->native_place;
					$SaveUserInfo["gothra_gothram"]=$page->gothra_gothram;
					$SaveUserInfo["address"]=$page->address;
					$SaveUserInfo["country"]=$page->country;
					$SaveUserInfo["state"]=$page->state;
					$SaveUserInfo["city"]=$page->city;
					$SaveUserInfo["profession"]=$page->profession;
					$SaveUserInfo["gothra_gothram_other"]=$page->gothra_gothram_other;
					$SaveUserInfo["branch_ids_other"]=$page->rustagi_branch_other;
					$SaveUserInfo["profession_other"]=$page->profession_other;
					$SaveUserInfo["branch_ids"]=$page->rustagi_branch;

					$SaveFamilyInfo["id"]=$page->id;
					$SaveFamilyInfo["user_id"]=$id;
					$SaveFamilyInfo["name_title_father"]=$page->name_title_father;
					$SaveFamilyInfo["father_name"]=$page->father_name;
					
					$LastId=$this->getUserInfoTable()->saveUserInfo($SaveUserInfo);
					
					$lastFamilyId=$this->getFamilyInfoTable()->savefamilyInfo($SaveFamilyInfo);
					$objmail= new Mail\Message();
					//$bodyPart = new \Zend\Mime\Message(); 
					//$bodyMessage = new \Zend\Mime\Part($body);
					//$bodyMessage->type = 'text/html';
					//$bodyPart->setParts(array($bodyMessage));
					$bodyPart="Hi ".$page->email.",<br/><br/>".
					"You have Successfully Registered. Here below is your activation link.<br/>".
					"<strong>Please Copy and paste the link below in browser </strong> to activate your account.<br/><br/>";
					$bodyPart.="<a href='$base"."user/activate?active=0&user=$id&token=$act_code'>'$base"."user/activate?active=0&user=$id&token=$act_code'</a>";
					$bodyPart.="<br/><br/>";
					$bodyPart.="Thanks & Regards<br/>";
					$bodyPart.="Rustagi Samaj Team<br/>";
					$bodyPart.="<br/><br/>";


				$number = $SaveUserData["mobile_no"];
    			$code = rand(1111,9999);
                date_default_timezone_set('Asia/Kolkata');
                $time = date('H:i');

    			 // $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                  $adapter->query(" insert into `tbl_mobile`(`user_id`, `mobile`, `time`, `code`) VALUES ($id,$number,'".$time."',$code)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                 // $arrdef =  $adapter->query("select * from tbl_sms_template where msg_sku='forgot_password'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


					$msg_query = $adapter->query("SELECT * FROM tbl_sms_template WHERE msg_sku='welcome_msg'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
					$msg_query = $msg_query[0];
					// $otpmsg = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', "<a href='/rustagi/user/activate?active=0&user=$id&token=$act_code'>'$base/rustagi/user/activate?active=0&user=$id&token=$act_code'</a>");
					// $otpmsg = "$base"."user/activate?active=0&user=$id&token=$act_code";

			 // $otpmsg = addslashes("<a href='$base/rustagi/user/activate?active=0&user=$id&token=$act_code'>'$base/rustagi/user/activate?active=0&user=$id&token=$act_code'</a>");
			$array=explode('<variable>',$msg_query['message']);
			$array[0]=$array[0].$number;
			$array[1]=$array[1].$code;
			$text=  urlencode(implode("",$array));

			file_put_contents("mssg.txt",$text);
			// echo $text;die;	
			$url="http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$number&from=Helocb&dlrreq=true&text=$text&alert=1";
			file_get_contents($url);


			// echo $text;die;

				    // $msg_query = $adapter->query("SELECT * FROM tbl_sms_template WHERE msg_sku='welcome_msg'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

					// $sql="SELECT * FROM tbl_sms_template WHERE msg_sku='welcome_msg'"; //die;
     //     	$res = mysqli_query($this->con,$sql);
		   //  $msg_query=mysqli_fetch_array($res); 
			// 	    $userEmailId = $SaveUserData["mobile_no"];
			// $array=explode('<variable>',$msg_query['message']);
			// $array[0]=$array[0].$userEmailId;
			// $array[1]=$array[1]."<a href='$base/rustagi/user/activate?active=0&user=$id&token=$act_code'>'$base/rustagi/user/activate?active=0&user=$id&token=$act_code'</a>";
			// $text=  urlencode(implode("",$array));

			// file_put_contents("mssg.txt",$text);
			// // echo $text;die;	
			// $url="http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$userEmailId&from=Helocb&dlrreq=true&text=$text&alert=1";
			// file_get_contents($url); 
			// /// Code for SMS Going to the particular user Ends here ////
			
					// print_r($SaveUserInfo);die;
					//echo $bodyPart;exit;
					/*$objmail->setBody($bodyPart);
					$objmail->setFrom("info@rustagisamaj.com","Neeraj Rustagi");
					$objmail->addTo($page->email, $page->email);
					$objmail->setSubject("Activate Account");
					$objmail->setEncoding('UTF-8');
					$transportObj = new Mail\Transport\Sendmail();
					$transportObj->send($objmail);*/					
					// $headers = "MIME-Version: 1.0" . "\r\n";
					// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// $headers .= 'From: <admin@rustagisamaj.com>' . "\r\n";
					// $headers .= 'Cc: admin@rustagisamaj.com' . "\r\n";
					// $subject='Activate Rustagi Samaj Account';
					// // mail($page->email,$subject,$bodyPart,$headers);	
					// $this->sendmail($bodyPart,$page->email,"admin@rustagisamaj.com",$subject);
					// echo "dfg";die;			
					
					// return $this->redirect()->toRoute('application/default', array(
					// 		'action' => 'index',
					// 		'controller' => 'index'
					// ));
            // $succarr = array("userid"=>$userid,"time"=>$time,"mobile"=>$number,"code"=>$code);

					header("Location:$base"."user/confimotpsignup?userid=$id&number=$number&code=$code&time=$time");

					echo "nahi hua"; die;
				}
				//********Redirect *********
				return $this->redirect()->toRoute('application/default', array(
							'action' => 'index',
							'controller' => 'index'
				));
			 }
		  }else{
			  exit("User Already Registered");
			  //********Redirect *********
				return $this->redirect()->toRoute('application/default', array(
							'action' => 'index',
							'controller' => 'index'
				));
		  }
		}		        
        return new ViewModel(array("form"=>$signupform));
    }

    public function confimotpsignupaction()
    {
		  $data['userid']= (int) $this->getRequest()->getQuery('userid');
		  $data['number']= (int) $this->getRequest()->getQuery('number');
		  $data['code']= (int) $this->getRequest()->getQuery('code');
		  $data['time']= $this->getRequest()->getQuery('time');

		  return new ViewModel(array("data"=>$data));
    		// echo $active ; die;
    }

    public function Profileaction($val='')
    {
    	echo "Fdgdfg";die;
    }

	public function activateAction(){
		  $active= (int) $this->getRequest()->getQuery('active');
		  $user= (int) $this->getRequest()->getQuery('user');
          $act_code=   $this->getRequest()->getQuery('token');		  
		if($active==0 && $user!="" && $act_code!=""){
			$row=$this->getUserTable()->getRegisteredUser($user,$act_code);
			if($row !=''){				
				$update=$this->getUserTable()->activateUser($row->id);
				if($update==1){
					return $this->redirect()->toRoute('application/default');
				}
			}			
		}
		return new ViewModel();
	}
	public function loginAction(){
		  if ($this->getRequest()->isPost()) {			  
		    $request=$this->getRequest();
			$login_email=$request->getPost('login_email');
			$login_password=md5($request->getPost('login_password'));
			// print_r($login_password);die;

		  /* $user=$this->getUserTable()->select(function(Select $select) use($request){
							   $select->where->nest
											->equalTo('email',$request->getPost('login_email'))->or
											->equalTo('mobile_no',$request->getPost('login_email'))
											->unnest
											->and
											->equalTo('password',md5($request->getPost('login_password')))
											->and
										   ->equalTo('IsActive',1)
										   ->and
										   ->equalTo('IsUsed',1);
							}); */ 
							
									
		 $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		 $QUERY="SELECT tbl_user.*,tbl_user_info.full_name,tbl_family_info.father_name,tbl_user_info.address,tbl_user_info.profile_photo,
		 tbl_profession.profession FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
		INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		WHERE ((tbl_user.email='$login_email' OR tbl_user.mobile_no='$login_email') AND tbl_user.password='$login_password' AND tbl_user.IsActive='1')";
		$user=$adapter->query($QUERY, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
			// print_r($user->count());die;
			
              if($user->count()){
				  $result = $user->current();
				  if(!empty($result))
				  {
					  $user_session = new Container('user');
					  foreach($user->current() as $u=>$v)$user_session->offsetSet($u,$v);
						return $this->redirect()->toRoute('application/default', array(
													'action' => 'memberbasic',
													'controller' => 'account'
											   ));					  
				  }
			  }else{
				  return $this->redirect()->toRoute('application/default', array(
							'action' => 'index',
							'controller' => 'index'
				       ));				  
			  }
          }
	}
	/******Ajax Call******/
	public function getStateNameAction(){
		$Request=$this->getRequest();
		if ($Request->isPost()) {
			$Country_ID=$Request->getPost("Country_ID");
			$state_name=$this->getStateTable()->getStateListByCountryCode($Country_ID);
			if(count($state_name))
				return new JsonModel(array("Status"=>"Success","statelist"=>$state_name));
			else
				return new JsonModel(array("Status"=>"Failed","statelist"=>NULL));
		}
	}
	/******Ajax Call******/
	public function getCityNameAction(){
		$Request=$this->getRequest();
		if ($Request->isPost()) {
			$State_ID=$Request->getPost("State_ID");
			$city_name=$this->getCityTable()->getCityListByStateCode($State_ID);
			if(count($city_name))
				return new JsonModel(array("Status"=>"Success","statelist"=>$city_name));
			else
				return new JsonModel(array("Status"=>"Failed","statelist"=>NULL));
		}
	}
	/******Ajax Call******/
	public function getRustagiBranchAction(){
		$Request=$this->getRequest();
		if ($Request->isPost()) {
			$City_ID=$Request->getPost("City_ID");
			$branch_name=$this->getRustagiBranchTable()->getBrachListByCity($City_ID);
			if(count($branch_name))
				return new JsonModel(array("Status"=>"Success","statelist"=>$branch_name));
			else
				return new JsonModel(array("Status"=>"Failed","statelist"=>NULL));
		}
	}
	/******Ajax Call******/
	public function chkduplicateAction()
	{
		 $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		 $sql = "select ".$_POST['id']." from tbl_user where ".$_POST['id']." like '".$_POST['value']."%'";
		  $data = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		 $size = $data->count();
		 if($size == 0){
				return new JsonModel(array("id"=>$_POST['id'],"message"=>"<p style='color:green;'>Available</p>"));
		 }
			else 
				 return new JsonModel(array("id"=>$_POST['id'],"message"=>"<p style='color:red;'>Aleardy Exists</p>"));
		
		exit();
	}

	 
	public function sendotpAction()
    {
    	$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

    	 $chkuser = $adapter->query("select * from `tbl_user` where mobile_no=".$_POST['number']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    		
            foreach ($chkuser as $user) {
                $userid = $user->id;
            }

            $size = $chkuser->count();
    		if($size==1){
    			$number = $_POST['number'];
    			$code = rand(1111,9999);
                date_default_timezone_set('Asia/Kolkata');
                $time = date('H:i');

    			 $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                  $adapter->query(" insert into `tbl_mobile`(`user_id`, `mobile`, `time`, `code`) VALUES ($userid,$number,'".$time."',$code)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                 $arrdef =  $adapter->query("select * from tbl_sms_template where msg_sku='forgot_password'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

    			  // $link="http://".$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF']."login/index/resetpassword?id=$token"
    			   // $msg_query=mysqli_fetch_array($res);
                  foreach ($arrdef as $arr) {
                    $msg = $arr->message;
                  }
			$array=explode('<variable>',$msg);
            $array[0]=$array[0].$number;
            $array[1]=$array[1].$code;
            $text=  rawurlencode(implode("",$array));
                // echo $time;
            file_put_contents("mssg.txt",$text); 
            $succarr = array("userid"=>$userid,"time"=>$time,"mobile"=>$number,"code"=>$code);
    			  

    			  
    			$url="http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$number&from=Helocb&dlrreq=true&text=$text&alert=1";
            file_get_contents($url); 
            // print_r($arrdef);
            // die;

		 return new JsonModel(array('resp'=>1,'success'=>$succarr));

    			// $response = $this->getResponse();
       //      $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
       //      $response->setContent(json_encode(array('resp'=>1,'success'=>$succarr)));

    			// return $response;
    		}
    		else  {

		 return new JsonModel(array("resp"=>0,"error"=>"sorry your number doesn't exists"));

    			// $response = $this->getResponse();
       //      $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
       //      $response->setContent(json_encode(array("resp"=>0,"error"=>"sorry your number doesn't exists")));

    			// return $response;
    		}
		 // return new JsonModel(array("Status"=>"Success","statelist"=>$_POST));

    	exit();
    }

    public function confirmotpAction()
    {	
    	$isreg = $_POST['is_reg'];
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $arrdef =  $adapter->query("select * from tbl_mobile where (code=".$_POST['otp']." && mobile=".$_POST['number']." && time='".$_POST['time']."')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();

        $uid = $arrdef->toArray()[0]['user_id'];

        // echo $uid;die;
        // foreach ($arrdef as $user) {
        //         $userid = $user->user_id;
        //     }

            if($isreg ==1){

				$update=$this->getUserTable()->activateUser($uid);
				if($update) 
					$msg = "Congratulations Registration successful You can proceed to login";
            	else $msg = "Their is some internal error occured . Please try later";
            } 
        		
            $succarr = array("userid"=>$userid,"is_reg"=>$isreg,"msg"=>$msg);

        if($size == 1){
		 return new JsonModel(array("resp"=>1,"success"=>$succarr));

            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            // $response->setContent(json_encode(array("resp"=>1,"success"=>$succarr)));

            //     return $response;
        }
    else
        {
		 return new JsonModel(array("resp"=>0,"error"=>"otp doesn't match"));

            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            // $response->setContent(json_encode(array("resp"=>0,"error"=>"otp doesn't match")));

            //     return $response;
        }
        exit();
    }


    public function chgpassAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        


        if($_POST["pass"] != $_POST["rpass"]){
		 return new JsonModel(array("resp"=>0,"error"=>"password doesn't match please try again"));

            // $response->setContent(json_encode(array("resp"=>0,"error"=>"password doesn't match please try again")));
        }
        else {

            $pass = md5($_POST["pass"]);

            $arrdef =  $adapter->query("update tbl_user set password='".$pass."' where (id='".$_POST['userid']."')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		 return new JsonModel(array("resp"=>1,"success"=>"password changed successfully please login to continue"));

            // $response->setContent(json_encode(array("resp"=>1,"success"=>"password changed successfully please login to continue")));

        }
                // return $response;
        
    }

     
    public function sendmail($content,$to,$from,$subject)
    {

        $options = new Mail\Transport\SmtpOptions(array(  
            'name' => 'localhost',  
            'host' => 'smtp.gmail.com',  
            'port'=> 587,  
            'connection_class' => 'login',  
            'connection_config' => array(  
                'username' => 'funstartswithyou15@gmail.com',  
                'password' => 'watchmyvideos',  
                'ssl'=> 'tls',  
            ),  
        ));  

        $html = new MimePart($content);  
        $html->type = "text/html";  
        $body = new MimeMessage();  
        $body->setParts(array($html));  
  
// instance mail   
$mail = new Mail\Message();  
$mail->setBody($body); // will generate our code html from template.phtml  
$mail->setFrom($from,'Sender Name');  
$mail->setTo($to);  
$mail->setSubject($subject);  
  
$transport = new Mail\Transport\Smtp($options);  
$status = $transport->send($mail);


    }


    public function checklivemailaction()
    {
 	
 	$content = "dsfisgdf";
 	$to = "php1@hello42cab.com";
 	$from = "phpdevp22@gmail.com";
 	$subject = "fgdfgdfg";
//     	ini_set("display_errors", 1);
//     	 $your_name = 'Mario Awad';
//  $your_email = 'funstartswithyou15@gmail.com'; //Or your_email@gmail.com for Gmail
//  $your_password = 'watchmyvideos';
//  $send_to_name = 'My Friend';
//  $send_to_email = 'php1@hello42cab.com';

//  //SMTP server configuration
//  $smtpHost = 'smtp.gmail.com';
//  $smtpConf = array(
//   'auth' => 'login',
//   'ssl' => 'ssl',
//   'port' => '465',
//   'username' => $your_email,
//   'password' => $your_password
//  );

//  $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);

//  //Create email
//  $mail = new Zend_Mail();
//  $mail->setFrom($your_email, $your_name);
//  $mail->addTo($send_to_email, $send_to_name);
//  $mail->setSubject('Hello World');
//  $mail->setBodyText('This is the body text of the email.');

//  //Send
//  $sent = true;
//  try {
//   $mail->send($transport);
//  }
//  catch (Exception $e) {
//   $sent = false;
//  }

//  //Return boolean indicating success or failure
//  print_r($sent);
// die;
    	$options = new Mail\Transport\SmtpOptions(array(  
            'name' => 'localhost',  
            'host' => 'smtp.gmail.com',  
            'port'=> 587,  
            'connection_class' => 'login',  
            'connection_config' => array(  
                'username' => 'funstartswithyou15@gmail.com',  
                'password' => 'watchmyvideos',  
                'ssl'=> 'tls',  
            ),  
        ));  

        $html = new MimePart($content);  
        $html->type = "text/html";  
        $body = new MimeMessage();  
        $body->setParts(array($html));  
  
// instance mail   
$mail = new Mail\Message();  
$mail->setBody($body); // will generate our code html from template.phtml  
$mail->setFrom($from,'Sender Name');  
$mail->setTo($to);  
$mail->setSubject($subject);  
  
$transport = new Mail\Transport\Smtp($options);  
$status = $transport->send($mail);
	
		echo "1";die;
    }

}
?>