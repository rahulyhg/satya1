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

class NewsController extends AbstractActionController
{
	public function indexAction()
    {
        
    		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		/******Fetch all Members Data from db*********/				
		 $NewsData=$adapter->query("select * from tbl_news ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
      	// $filters_data = $this->sidebarFilters();
      	$filters_data = $this->sidebarFilters();

        return new ViewModel(array("NewsData"=>$NewsData,"filters_data"=>$filters_data));
    }
	
	public function ViewAction()
    {
    	if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
        }
        else $id = Null;

       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "select tn.*,tal.username from tbl_news as tn
        inner join tbl_admin_login as tal on tn.modified_by=tal.id
        where (tn.id=$id)";
            // $session = new Container('user');
            //       $user_id=(empty($session->offsetGet('id')))? 0:$session->offsetGet('id');
            //       $user_name=(empty($session->offsetGet('username')))? "not_user":$session->offsetGet('username');
          
                  // print_r($user_name);die;
            /******Fetch all Members Data from db*********/             
         $NewsSingle=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
           
           $news = (object)$NewsSingle[0];
            // print_r($news);	
            // die;

         // foreach ($PostSingle as $Post) {
         //        $posts['id'] = $Post->postid;
         //        $posts['user_id'] = $user_id;
         //        $posts['user_name'] = $user_name;
         //        $posts['title'] = $Post->title;
         //        $posts['image'] = $Post->image;
         //        $posts['description'] = $Post->description;
         //        $posts['full_name'] = $Post->full_name;
         //        $posts['created_date'] = $Post->postdate;
         // }
         // $Comments = $this->PostsComments($Post->postid);

//          $sqlviews = "INSERT INTO tbl_posts_views (post_id, user_id, user_name, ip_address)
// SELECT * FROM (SELECT '$Post->postid','$user_id','$user_name','".$_SERVER['REMOTE_ADDR']."') AS tmp
// WHERE NOT EXISTS (
//     SELECT * FROM tbl_posts_views WHERE (post_id='$Post->postid' && ip_address='".$_SERVER['REMOTE_ADDR']."')
// ) LIMIT 1;";
//           $adapter->query($sqlviews, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


         // $viewscounts = "SELECT post_id FROM tbl_posts_views WHERE (post_id='$Post->postid')";
         //  $viewscounts = $adapter->query($viewscounts, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();

                // $posts['views'] = $viewscounts;

          

        // return new ViewModel(array("posts"=>$posts,"PostComments"=>$Comments)); 


        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("filters_data"=>$filters_data,"news"=>$news));
    }

    public function sidebarFilters()
	{
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

		$filters_array = array("news_category_id"=>"tbl_newscategory");

      	foreach($filters_array as $key =>$table){
      	 	$filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      	}
      	return $filters_data;
	}

	public function newsfiltersAction()
	{
		
		$from = $this->convertdate($_POST['from']);
		$to = $this->convertdate($_POST['to']);
		
		if(count($_POST['category'])>0)
		{
			$category = implode(",", $_POST['category']);
			$catfield = "and news_category_id IN (".$category.")";
		}	
		else $catfield = "";	

		$sql = "select * from tbl_news where (created_date BETWEEN '".$from."' AND '".$to."' ".$catfield.") ORDER BY id DESC";
		


			 
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		/******Fetch all Members Data from db*********/				
		 $NewsData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
      	$view = new ViewModel(array('NewsData'=>$NewsData));
		$view->setTerminal(true);
		return $view;

		// echo $sql;
		
		exit();
	}

	public function convertdate($date){

			$timestamp = strtotime($date);
			$date = date("Y/m/d h:i:s",$timestamp);
			return $date;
	}


}
?>
