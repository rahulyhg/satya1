<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;


class PostsController extends AppController
{
	public function indexAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "select tbl_post.*,tbl_postcategory.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post 
        inner join tbl_user on tbl_post.user_id=tbl_user.id 
        inner join tbl_postcategory on tbl_post.post_category=tbl_postcategory.id 

        where (tbl_post.IsActive=1) order by tbl_post.id DESC";
                        
         $AllData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

         // print_r($AllData);die;
    	if($this->params()->fromRoute('id')==1){
            $msg = "Message sent successfully";
        }
        else $msg = "";	
        $filters_data = $this->sidebarFilters();

        // print_r($filters_data);die;

		return new ViewModel(array("message"=>$msg,"AllPosts"=>$AllData,"filters_data"=>$filters_data));
       
    }
	
	public function ViewAction()
    {
        return new ViewModel();
    }

     public function sidebarFilters()
    {
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("category"=>"tbl_postcategory");

        foreach($filters_array as $key =>$table){
            $filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function postfiltersAction()
    {
        
        $from = $this->convertdate($_POST['from']);
        $to = $this->convertdate($_POST['to']);
        
        if(!empty($_POST['category']))
        {
            // $category = implode(",", $_POST['category']);
            $catfield = "and tbl_post.post_category IN (".$_POST['category'].")";
        }   
        else $catfield = "";    

        $sql = "select tbl_post.*,tbl_postcategory.*,tbl_user.*,tbl_post.id as postid,tbl_post.created_date as postdate from tbl_post 
        inner join tbl_user on tbl_post.user_id=tbl_user.id 
        inner join tbl_postcategory on tbl_post.post_category=tbl_postcategory.id 
        where (tbl_post.created_date BETWEEN '".$from."' AND '".$to."' ".$catfield." AND tbl_post.IsActive=1) order by tbl_post.id DESC";
        


             
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $AllData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
        $view = new ViewModel(array('AllPosts'=>$AllData));
        $view->setTerminal(true);
        return $view;

        // echo $sql;
            // print_r($sql);
        // exit();
    }

    public function convertdate($date){

            $timestamp = strtotime($date);
            $date = date("Y/m/d h:i:s",$timestamp);
            return $date;
    }


}
?>
