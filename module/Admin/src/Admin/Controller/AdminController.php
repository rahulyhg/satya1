<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;
use Zend\Mail;
use Zend\Mime;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

class AdminController extends AppController {

    public function indexAction() {
        
    }

    public function dashboardAction() {
        $totalusercount = $this->getUserTable()->getInfo(array(1));
        $totaluserpending = $this->getUserTable()->getInfo(array('IsActive=0'));
        $totalIndiaUser = $this->getUserTable()->getInfo(array("tbl_user_info.country=1"));
        $matrimonyusercount = $this->getUserTable()->getInfo(array('tbl_user_info.user_type_id=2'));
        $matrimonyuserpending = $this->getUserTable()->getInfo(array('tbl_user_info.user_type_id=2 && IsActive=0'));
        $BridesUser = $this->getUserTable()->getInfo(array("tbl_user_info.user_type_id=2 && tbl_user_info.gender='Female'"));
        $BridesUserPending = $this->getUserTable()->getInfo(array('tbl_user_info.user_type_id=2 && tbl_user_info.gender="Female" && IsActive=0'));
        $GroomsUser = $this->getUserTable()->getInfo(array("tbl_user_info.user_type_id=2 && tbl_user_info.gender='Male'"));
        $GroomsUserPending = $this->getUserTable()->getInfo(array('tbl_user_info.user_type_id=2 && tbl_user_info.gender="Male" && IsActive=0'));


        $members = array("Total Users" => array("World Members" => $totalusercount, "India Members" => $totalIndiaUser, "Pending Approvals" => $totaluserpending),
            "Matrimony Users" => array("Matrimonials Members" => $matrimonyusercount, "Pending Approvals" => $matrimonyuserpending),
            "Brides Users" => array("Brides" => $BridesUser, "Pending Approvals" => $BridesUserPending),
            "Grooms Users" => array("Grooms" => $GroomsUser, "Pending Approvals" => $GroomsUserPending),
        );
        // $TopNewUsers = $this->getUserinfoTable()->TopNew();

        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $TopNewUsers = $adapter->query("select tui.*,tbl_user.*,tbl_family_info.*,tbl_user.IsActive as userstatus
         from tbl_user_info tui LEFT JOIN tbl_user on tui.user_id = tbl_user.id 
         LEFT JOIN tbl_family_info on tui.user_id = tbl_family_info.user_id 
         ORDER BY tui.user_id DESC limit 0, 10 ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        return new ViewModel(array("Members" => $members, "TopNewUsers" => $TopNewUsers));
    }

    public function loginAction() {

        if ($this->getRequest()->isPost()) {

            $request = $this->getRequest();

            $username = $request->getPost('username');

            $login_password = md5($request->getPost('userpass'));



            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $QUERY = "SELECT tbl_admin_login.* FROM tbl_admin_login

		WHERE tbl_admin_login.username='$username'  AND tbl_admin_login.password='$login_password' ";

            $user = $adapter->query($QUERY, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


            if ($user->count()) {

                $result = $user->current();

                if (!empty($result)) {

                    $admin_session = new Container('admin');

                    foreach ($user->current() as $u => $v)
                        $admin_session->offsetSet($u, $v);

                    // echo "test";die; 
                    return $this->redirect()->toRoute('admin', array(
                                'controller' => 'admin',
                                'action' => 'dashboard'));
                }
            } else {

                return $this->redirect()->toRoute('admin', array(
                            'controller' => 'admin',
                            'action' => 'index'
                ));
            }
        }

        return new ViewModel();
    }

    public function logoutAction() {

        $auth = new AuthenticationService();



        $auth->clearIdentity();

        session_destroy();

        return $this->redirect()->toRoute('admin', array('controller' => 'admin', 'action' => 'index'));
    }

    public function changestatusAction() {

        $data = (object) $_POST;
        $return = $this->getUserTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        // print_r($_POST);
        //exit();
    }

    public function sendotpAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $chkuser = $adapter->query("select * from `tbl_admin_login` where mobile_no=" . $_POST['number'] . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        foreach ($chkuser as $user) {
            $userid = $user->id;
        }

        $size = $chkuser->count();
        if ($size == 1) {
            $number = $_POST['number'];
            $code = rand(1111, 9999);
            date_default_timezone_set('Asia/Kolkata');
            $time = date('H:i');

            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $adapter->query(" insert into `tbl_mobile`(`user_id`, `mobile`, `time`, `code`) VALUES ($userid,$number,'" . $time . "',$code)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            $arrdef = $adapter->query("select * from tbl_sms_template where msg_sku='forgot_password'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            // $link="http://".$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF']."login/index/resetpassword?id=$token"
            // $msg_query=mysqli_fetch_array($res);
            foreach ($arrdef as $arr) {
                $msg = $arr->message;
            }
            $array = explode('<variable>', $msg);
            $array[0] = $array[0] . $number;
            $array[1] = $array[1] . $code;
            $text = rawurlencode(implode("", $array));
            // echo $time;
            file_put_contents("mssg.txt", $text);
            $succarr = array("userid" => $userid, "time" => $time, "mobile" => $number, "code" => $code);



            $url = "http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=helloalt&pass=helloalt&appid=helloalt&subappid=helloalt&msgtype=1&contenttype=1&selfid=true&to=$number&from=Helocb&dlrreq=true&text=$text&alert=1";
            file_get_contents($url);
            // print_r($arrdef);
            // die;


            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array('resp' => 1, 'success' => $succarr)));

            return $response;
        } else {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 0, "error" => "sorry your number doesn't exists")));

            return $response;
        }

        exit();
    }

    public function confirmotpAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $arrdef = $adapter->query("select * from tbl_mobile where (code=" . $_POST['otp'] . " && mobile=" . $_POST['number'] . " &&
        time='" . $_POST['time'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $size = $arrdef->count();

        foreach ($arrdef as $user) {
            $userid = $user->user_id;
        }
        $succarr = array("userid" => $userid);


        if ($size == 1) {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 1, "success" => $succarr)));

            return $response;
        } else {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode(array("resp" => 0, "error" => "otp doesn't match")));

            return $response;
        }
        exit();
    }

    public function chgpassAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');



        if ($_POST["pass"] != $_POST["rpass"]) {
            $response->setContent(json_encode(array("resp" => 0, "error" => "password doesn't match please try again")));
        } else {

            $pass = md5($_POST["pass"]);

            $arrdef = $adapter->query("update tbl_admin_login set password='" . $pass . "' where (id='" . $_POST['userid'] . "')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            $response->setContent(json_encode(array("resp" => 1, "success" => "password changed successfully please login to continue")));
        }
        return $response;
    }

//     public function SendMailAction()
//     {
// //     	$message = new \Zend\Mail\Message();
// // $message->setBody('This is the body');
// // $message->setFrom('myemail@mydomain.com');
// // $message->addTo('phpdevp22@gmail.com');
// // $message->setSubject('Test subject');
// // $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();  
// // $smtpOptions->setHost('smtp.gmail.com')
// //             ->setConnectionClass('login')
// //             ->setName('smtp.gmail.com')
// //             ->setConnectionConfig(array(
// //                 'username' => 'funstartswithyou15@gmail.com',
// //                 'password' => 'watchmyvideos',
// //                 'ssl' => 'tls',
// //             ));
// // $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
// // $transport->send($message);
//     	// setup SMTP options  
// $options = new Mail\Transport\SmtpOptions(array(  
//             'name' => 'localhost',  
//             'host' => 'smtp.gmail.com',  
//             'port'=> 587,  
//             'connection_class' => 'login',  
//             'connection_config' => array(  
//                 'username' => 'funstartswithyou15@gmail.com',  
//                 'password' => 'watchmyvideos',  
//                 'ssl'=> 'tls',  
//             ),  
// ));  
// $fileContents = fopen("/usr/share/pixmaps/faces/sky.jpg", 'r');
// $attachment = new Mime\Part($fileContent);
// $attachment->type = 'image/jpg';
// $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
// // $this->renderer = $this->getServiceLocator()->get('ViewRenderer');  
// $content = "gdgdfgdfgdfgddfg";  
// // make a header as html  
// $html = new MimePart($content);  
// $html->type = "text/html";  
// $body = new MimeMessage();  
// $body->setParts(array($html,$attachment));  
// // instance mail   
// $mail = new Mail\Message();  
// $mail->setBody($body); // will generate our code html from template.phtml  
// $mail->setFrom('munanshu.madaank23@gmail.com','Sender Name');  
// $mail->setTo('phpdevp22@gmail.com');  
// $mail->setSubject('Your Subject');  
// $transport = new Mail\Transport\Smtp($options);  
// $transport->send($mail);
// 	die;
//     }	      
}
