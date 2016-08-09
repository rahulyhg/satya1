<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Model\Entity\Userinfos;
// use Admin\Model\Entity\Newscategories;
// use Admin\Form\NewsForm;
// use Admin\Form\NewscategoryForm;
// use Admin\Form\NewsFilter;
// use Admin\Form\NewscategoryFilter;

class MatrimonyuserController extends AppController
{
    
    public function matrimonyuserindexAction()
    {   
         
  // echo $this->getRequest()->getUri()->getHost();die;

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $userinfos=$adapter->query("select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_family_info.*,tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,
        tbl_user.IsActive as userstatus from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id LEFT JOIN tbl_family_info on tui.user_id=tbl_family_info.user_id 
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id
        where tui.user_type_id='2' ORDER BY tui.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        return new ViewModel(array(
            'userinfos' => $userinfos));
    }

    public function memberuserindexAction()
    {   
        if($this->params()->fromRoute('id')==100){
            $msg = "User Assigned ";
        }
        else if($this->params()->fromRoute('id')==101){
            $msg = "Could not update Some internal Error";
        }
         else if($this->params()->fromRoute('id')==102){
            $msg = "User Already Assigned";
        }
        else $msg = "";



        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $userinfos=$adapter->query("select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,tbl_rustagi_branches.*,    
        tbl_family_info.*,tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,
        tbl_user.IsActive as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id LEFT JOIN tbl_family_info on tui.user_id=tbl_family_info.user_id 
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id
        LEFT JOIN tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id
         ORDER BY tui.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        // foreach ($communities as $comms) {
        //    $commtypes[$comms->id] = $comms->category_name;
        // }

        $usertype = $this->getUsertypeTable()->fetchAllActive();
        foreach ($usertype as $utypes) {
           $usertypes[$utypes->id] = $utypes->user_type;
        }


        // foreach ($usertypes as $key => $value) {
            

        // }
        // echo "<pre>";
            // print_r($communities);die;
        return new ViewModel(array(
            'userinfos' => $userinfos,"usertypes"=>$usertypes,"commtypes"=>$communities,"msg"=>$msg));
    }

    public function usertypeinfoAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sqlsingle = "select tui.*,tbl_height.*,tbl_profession.*,tbl_country.*,tbl_state.*,
        tbl_city.*,tbl_caste.*,tbl_religion.*,tbl_star_sign.*,tbl_zodiac_sign_raasi.*,tbl_gothra_gothram.*,tbl_user_type.*,    
        tbl_family_info.*,tbl_education_field.*,tbl_education_level.*,tbl_designation.*,tbl_user.*,tbl_communities.*,
        tbl_user.IsActive as userstatus,tui.user_id as uid from tbl_user_info tui LEFT JOIN tbl_user on 
        tui.user_id=tbl_user.id LEFT JOIN tbl_family_info on tui.user_id=tbl_family_info.user_id 
        LEFT JOIN tbl_country on tui.country=tbl_country.id 
        LEFT JOIN tbl_state on 
        tui.state=tbl_state.id LEFT JOIN tbl_city on 
        tui.city=tbl_city.id LEFT JOIN tbl_profession on 
        tui.profession=tbl_profession.id  LEFT JOIN tbl_education_field on 
        tui.education_field=tbl_education_field.id LEFT JOIN tbl_height on 
        tui.height=tbl_height.id LEFT JOIN tbl_user_type on 
        tui.user_type_id=tbl_user_type.id LEFT JOIN tbl_caste on 
        tui.caste=tbl_caste.id LEFT JOIN tbl_religion on 
        tui.religion=tbl_religion.id LEFT JOIN tbl_star_sign on 
        tui.star_sign=tbl_star_sign.id LEFT JOIN tbl_zodiac_sign_raasi on 
        tui.zodiac_sign_raasi=tbl_zodiac_sign_raasi.id LEFT JOIN tbl_gothra_gothram on 
        tui.gothra_gothram=tbl_gothra_gothram.id LEFT JOIN tbl_education_level on 
        tui.education_level=tbl_education_level.id LEFT JOIN tbl_designation on 
        tui.designation=tbl_designation.id LEFT JOIN tbl_communities on 
        tui.comm_mem_id=tbl_communities.id LEFT JOIN tbl_user_roles on 
        tui.user_id=tbl_user_roles.user_id
        where tbl_user_roles.".$_POST['id']."='1'
         ORDER BY tui.id DESC";

         $userinfos = $adapter->query($sqlsingle, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            

             $usertype = $this->getUsertypeTable()->fetchAllActive();
        foreach ($usertype as $utypes) {
           $usertypes[$utypes->id] = $utypes->user_type;
        }

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

             $view = new ViewModel(array(
            'userinfos' => $userinfos,"usertypes"=>$usertypes,"commtypes"=>$communities));
        $view->setTerminal(true);
        return $view;
        exit();    
         
    }

    /* ajax function call */
    public function changestatusAction()
    {   

        $data = (object)$_POST;
        $return = $this->getUserTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();

    }
    /* ajax function call */

    public function updateusertypeAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $result1 = $adapter->query("update tbl_user_info set user_type_id=".$_POST['usertype']."
             where user_id=".$_POST['uid']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            $result2 = $adapter->query("update tbl_user set user_type_id=".$_POST['usertype']."
             where id=".$_POST['uid']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
         
        if($result1 && $result2){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return new JsonModel($respArr);
        

        exit();

    }

    public function updatecommtypeAction()
    {   

        $user_id = $_POST['uid'];
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $catid = (empty($_POST['cid']))? 0: $_POST['cid'];

        if($_POST['cid']==0){
            $sql = "update tbl_user_info set comm_mem_id=".$catid.", financial_year='0000-00-00' ,comm_mem_status='0'  where user_id=".$_POST['user_id']."";
            $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

            $mngmnt = $adapter->query("select * from tbl_community_mngmnt where ( agent_id=".$_POST['user_id']." && status=1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

             if(count($mngmnt)>0){

              $adapter->query("update tbl_community_mngmnt set status='0'  where (agent_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
              // $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        
            foreach ($mngmnt as $key => $value) {

                $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_id='0'  where (user_id=".$value['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                // echo $value['sub_agent_id'];
                }

            }

            echo "<p id='closeCatBox' onclick='closeme()'>X</p><br>Updated SuccessFully";
            exit();
        }
        else {
                $communities = $adapter->query("select * from tbl_communities where id=".$_POST['cid']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
                $SubComm = $adapter->query("select * from tbl_communities where parent_id=".$communities[0]['id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
                
                $category = array($communities[0],$SubComm);
            }

            // print_r($category);
            $view = new ViewModel(array('categories' => $category,'user' => $_POST ));
        $view->setTerminal(true);
        return $view;
        exit();   
    }

    public function updateusercommAction()
    {   
        $subagentid = $_POST['user_id'];    
        $subagentcatid = $_POST['catid'];    

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $parent = $adapter->query("select * from tbl_communities where id=".$_POST['catid']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $LoneParent = $adapter->query("select * from tbl_communities where id=".$parent[0]['parent_id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $Financial = $adapter->query("select financial_year,comm_mem_id from tbl_user_info where user_id=".$_POST['user_id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
            $today = date("Y-m-d");


        if($parent[0]['parent_id']==1 && $parent[0]['Head']==2){

            $respArr = array("status"=>1,"Content"=>"This is not a category you can choose its sub");
            // echo "";
        }
        else if(($LoneParent[0]['Head']==2 ) OR ($parent[0]['parent_id']==1 && $parent[0]['Head']==1)){

        
        // echo strtotime($Financial[0]['financial_year']);
            if($Financial[0]['financial_year'] == '0000-00-00'){

                $result = $adapter->query("update tbl_user_info set comm_mem_id='".$_POST['catid']."', financial_year='".$today."' ,comm_mem_status=1
                    where user_id='".$_POST['user_id']."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                if($result)
                    $respArr = array("status"=>2,"Content"=>"Updated SuccessFully");

                     
                else $respArr = array("status"=>2,"Content"=>"Couldn't Update");

            }
            else {

               $msg =  $this->updateFinancialYear($Financial[0]['financial_year'],$_POST['catid'],$_POST['user_id']);
                
               $respArr = $msg;

            }
        }       
        else {

            $isHead = $adapter->query("select comm_mem_status from tbl_user_info where user_id=".$subagentid."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();


            if($isHead[0]['comm_mem_status']==0){

            $HeadCategoryName = $adapter->query("select * from tbl_communities where id=".$parent[0]['parent_id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
// for testing purpose
//            $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/assignuser";
//for Live Purpose
            $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/assignuser";



            $result = $adapter->query("select tui.user_id,tui.comm_mem_id,tui.financial_year,tui.full_name,tbl_user.* from tbl_user_info as tui inner join tbl_user
                on tui.user_id=tbl_user.id
             where (tui.comm_mem_id='".$parent[0]['parent_id']."' && tui.user_id NOT IN($subagentid))", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

            if(count($result)){

            $output[] = "<p id='closeCatBox' onclick='closeme()'>X</p><br>";
            $output[] = "<center><h3>Category '".$HeadCategoryName[0]['category_name']."'</h3>";
            $output[] = "<h5>Choose Your Head</h5></center>";
            $output[] = "<form id='AssignUserForm' method='post' action=$action>";
            $output[] = "<input type='hidden' name='subagent' value=$subagentid>";
            $output[] = "<input type='hidden' name='subagentcatid' value=$subagentcatid>";

            foreach ($result as $key => $value) {
                $output[] = "<div style='border:2px solid black;'>Name :  ".$value['full_name']." <br> 
                    Mobile No. : ".$value['mobile_no']." <br> 
                    Financial Year. : ".$value['financial_year']." <br> 
                    <input type='radio' checked='checked' name='Agent' value = ".$value['user_id'].">
                    </div><br>";
            }
                    
            $output[] = "<input type='submit' value='update'></form>" ;
            $content = join("",$output);

            $respArr = array("status"=>4,"Content"=>$content);
        }
        else 
            $respArr = array("status"=>5,"Content"=>"You Need to Assign a head first");
       }
       else {
// for testing purpose
//                $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/unassignparent";
// for live purpose
  $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/admin/matrimonyuser/unassignparent";

                        $nextaction = array("action"=>$action,"user_id"=>$subagentid,"callback"=>"unassignparentres");
                        $respArr = array("status"=>8,"Content"=>"You need to unassign this user first","nextaction"=>$nextaction);
       }
    }


        $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode($respArr));
            return $response;

        // print_r($parent[0]['parent_id']);
        exit();
    }


    public function updateFinancialYear($Fyear,$catid,$uid)
    {
        # code...
        $d1 = strtotime($today);
                $d2 = strtotime($Fyear);
                $diff = $d1-$d2;
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    
                    if($days >= 365)
                    {
                         $result = $adapter->query("update tbl_user_info set comm_mem_id='".$catid."', financial_year='".$today."' 
                    where user_id='".$uid."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                        if($result)
                           return array("status"=>3,"Content"=>"Financial Year Renewed from today");
                        else return array("status"=>3,"Content"=>"Couldn't Update");
                    }
                    else {
//for Testing Purpose
//                       $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/admin/matrimonyuser/unassignparent";
//for Live Purpose
     $action = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/admin/matrimonyuser/unassignparent";
                        $nextaction = array("action"=>$action,"user_id"=>$uid,"callback"=>"unassignparentres","fyear"=>$Fyear,"catid"=>$catid);
                        return array("status"=>3,"Content"=>"The Financial Period is not over for this user","nextaction"=>$nextaction);
                    }

        // return $Fyear.$catid.$uid;
    }

    public function assignuserAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

       $result = $adapter->query("select * from tbl_community_mngmnt 
        where (agent_id=".$_POST['Agent']." && sub_agent_id=".$_POST['subagent']." && status=1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        if(count($result)==1){
            $msgid = 102;
        }
        else {

            $adapter->query("update tbl_user_info set comm_mem_id='".$_POST['subagentcatid']."',financial_year='".date("Y-m-d")."',comm_mem_status='1'  where user_id=".$_POST['subagent']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


             $result = $adapter->query("INSERT INTO `tbl_community_mngmnt`(`agent_id`, `sub_agent_id`, `status`)
                  VALUES (".$_POST['Agent'].",".$_POST['subagent'].",1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                 if($result){
                        $msgid = 100;
                    }
                    else $msgid = 101;

        }


        return $this->redirect()->toRoute('admin', array(
                            'action' => 'memberuserindex',
                            'controller' => 'matrimonyuser',
                            'id' => $msgid
                ));       
    }


    public function viewassignedAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $subagent = $adapter->query("select * from tbl_community_mngmnt where (sub_agent_id=".$_POST['sub_id']." && status=1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $Agentdetails = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.*,tbl_user.* from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where tui.user_id=".$subagent[0]['agent_id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

            $Agentdetails[0]['user_id'] = $subagent[0]['agent_id'];
            $Agentdetails[0]['subagentid'] = $subagent[0]['sub_agent_id'];
            $Agentdetails[0]['subagentname'] = $_POST['subname'];

        $communities = $adapter->query("select * from tbl_communities where parent_id=1", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();


        $view = new ViewModel(array('Agentdetails' => $Agentdetails[0],'communities' => $communities ));
        $view->setTerminal(true);
        return $view;
        exit();  
    }

     public function viewloneassignedAction()
    {   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');


        $Agentdetails = $adapter->query("select tui.full_name,tui.user_id as uid,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.*,tbl_user.* from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where tui.user_id=".$_POST['sub_id']."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $subagent = $adapter->query("select category_name,Head from tbl_communities where (id=".$Agentdetails[0]['parent_id']." && Head=2)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();


        $view = new ViewModel(array('Agentdetails' => $Agentdetails[0],'subagent' => $subagent[0]));
        $view->setTerminal(true);
        return $view;
        // print_r($subagent);
        exit();  
    }


    public function UnassignCommPosAction()
    {   
        $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        // $mngmnt = $adapter->query("delete from tbl_community_mngmnt where ( agent_id=".$_POST['agent_id']." && sub_agent_id=".$_POST['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if($_POST['Head']!=2){
            $mngmnt = $adapter->query("update tbl_community_mngmnt set status=0 where ( agent_id=".$_POST['agent_id']." && sub_agent_id=".$_POST['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        else $mngmnt = true;
        
        $userinfo = $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        if($mngmnt && $userinfo){
            $resp = array("Status"=>1,"msg"=>"Unassigned SuccessFully");
        }
        else $resp = array("Status"=>0,"msg"=>"Sorry Couldn't Un-Assign");
            
            $response->setContent(json_encode($resp));

            return $response;
    }

    public function unassignparentAction()
    {
         $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $mngmnt = $adapter->query("select * from tbl_community_mngmnt where ( agent_id=".$_POST['user_id']." && status=1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        
        $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


        if(count($mngmnt)>0){

              $adapter->query("update tbl_community_mngmnt set status='0'  where (agent_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
              // $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$_POST['user_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        
            foreach ($mngmnt as $key => $value) {

                $adapter->query("update tbl_user_info set comm_mem_id='0',financial_year='0000-00-00',comm_mem_status='0'  where (user_id=".$value['sub_agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

                // echo $value['sub_agent_id'];
            }

        }
        echo "updated SuccessFully"; 
        exit();
    }


        
    public function showuserrolesAction()
        {
            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $user_id = $_POST['user_id'];

            $UserRoles = $this->getUsersRolesTable()->userrole($user_id);
            $UserRoles[0]['uid'] = $user_id;

        $view = new ViewModel(array('UserRoles' => $UserRoles[0]));
        $view->setTerminal(true);
        return $view;
        }  
        


        public function manageroleAction()
          {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

            $userinfo = $adapter->query("select tui.user_id,tui.comm_mem_id,tui.comm_mem_status,tbl_user_roles.* from tbl_user_info as tui 
                LEFT JOIN tbl_user_roles on tui.user_id=tbl_user_roles.user_id
                where tui.user_id='".$_POST['user_id']."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
            
            if($userinfo[0]['IsExecutive'] ==1 && $_POST['IsExecutive'] == ""){
                if($userinfo[0]['comm_mem_id']>0 && $userinfo[0]['comm_mem_status']==1){

                 $respArr = array("status"=>1,"Content"=>"This user is Our Community Member and occupies a designation.You need to unassign it first . Then only You can change its Role");
                }
            }
            else { 

            $chkstatus = $this->getUsersRolesTable()->SaveRole($_POST);
                $respArr = array("status"=>2,"Content"=>$chkstatus);
            }



                $response->setContent(json_encode($respArr));
                return $response;
          } 


          public function memberlistingAction()
           {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

                $Mtype = $_POST['Mtype'];

                    if($_POST['fieldname']=="full_name"){
                        if($Mtype == "all"){
                            $sql = "select ".$_POST['fieldname']." from ".$_POST['table']." where ".$_POST['fieldname']." LIKE '".$_POST['value']."%' ";
                        }
                        else {
                            $sql = "select tbl.".$_POST['fieldname'].",tur.".$_POST['Mtype']." from ".$_POST['table']." as tui 
                        inner join tbl_user_roles as tur on tui.user_id = tur.user_id
                        where ( tur.".$_POST['Mtype']."='1'  and ".$_POST['fieldname']." LIKE '".$_POST['value']."%' )";
                        }
                    }

            else {
                
                $sql = "select * from ".$_POST['table']." where ".$_POST['fieldname']." LIKE '".$_POST['value']."%' ";
            }


                $list = $adapter->query($sql,\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
                $output[] = '<table  width="100%" style="border:none !important;">
                            <tbody>';
             
                    if(count($list)>0){
                             
                            foreach ($list as $row) {
                                $output[] = '<tr>
                                                <td>
                                                    <a href="">aaa</a>
                                                </td>
                                            </tr>';
                                }
                        }
                        else $output[] = '<p>No matched search</p>';

                        $output[] = '</tbody></table>';
    
                       $data = join("",$output);     
            $respArr = array("status"=>1,"Content"=>$data);

                $response->setContent(json_encode($respArr));
                return $response;
          } 


          public function addtositeAction()
          {
            $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $date = date("Y-m-d h:i:s");
            $field = $_POST['fieldname'];
            // $response = $this->getResponse();
            // $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
                $sql = "insert into ".$_POST['table']." (".$_POST['fieldname'].",IsActive,created_date,modified_date,modified_by) values('".$_POST['value']."',1,'$date','$date',1)";
               
               $result = $adapter->query($sql,\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

               $insertid = $adapter->getDriver()->getLastGeneratedValue();

               if($field == "branch_name")
               $upsql = "update tbl_user_info set branch_ids='$insertid',branch_ids_other='' where user_id ='".$_POST['uid']."'";
                    
                if($field == "profession")
               $upsql = "update tbl_user_info set profession='$insertid',profession_other='' where user_id ='".$_POST['uid']."'";

                if($field == "gothra_name")
               $upsql = "update tbl_user_info set gothra_gothram='$insertid',gothra_gothram_other='' where user_id ='".$_POST['uid']."'";
                


               $updateuser = $adapter->query($upsql,\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                
               if($updateuser)
                  echo "Updated SuccessFully";
              else echo "couldn't update";
            // print_r($upsql);
            die;
          }
    
   
}
