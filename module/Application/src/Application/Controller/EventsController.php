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

class EventsController extends AbstractActionController
{
	public function indexAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/
        $date = date('Y-m-d h:i:s');             
         $EventsData=$adapter->query("select * from tbl_upcoming_events where (event_date>'".$date."') ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
        // $filters_data = $this->sidebarFilters();
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("EventsData"=>$EventsData,"filters_data"=>$filters_data));
    }

	public function PreviousAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/
        $date = date('Y-m-d h:i:s');             
         $EventsData=$adapter->query("select * from tbl_upcoming_events where (event_date<'".$date."')  ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
        // $filters_data = $this->sidebarFilters();
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("EventsData"=>$EventsData,"filters_data"=>$filters_data));
    }
	
	public function ViewAction()
    {
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
        }
        else $id = Null;

       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $sql = "select tn.*,tal.username from tbl_upcoming_events as tn
        inner join tbl_admin_login as tal on tn.created_by=tal.id
        where (tn.id=$id)";
             
            /******Fetch all Members Data from db*********/             
         $EventSingle=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
           
           $events = (object)$EventSingle[0];
                
                  // print_r($events);die;


        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("filters_data"=>$filters_data,"events"=>$events));

        
    }

    public function sidebarFilters()
    {
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country"=>"tbl_country","city"=>"tbl_city");

        foreach($filters_array as $key =>$table){
            $filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        return $filters_data;
    }

    public function eventsfiltersAction()
    {
          $date = date('Y-m-d h:i:s'); 

          if(isset($_POST['pagename'])){
             if (strpos($_POST['pagename'], 'previous') !== false) {
                $status = "event_date<'".$date."' and ";
                $eventType = "Previous Events";
             }
             else {
                  $eventType = "UpComing Events";
                $status = "event_date>'".$date."' and ";
              }
         }


         if(isset($_POST['filtaction']))
           {
                $sql = "select * from tbl_upcoming_events where (".$status." ".$_POST['type']." = '".$_POST['value']."') ORDER BY id DESC";
            }
        else { 
        $from = $this->convertdate($_POST['from']);
        $to = $this->convertdate($_POST['to']);
        $chkdatediff = $this->valdateselection($from,$to);
       
        if($chkdatediff ==false){
            echo "From should be smaller than to";
            exit();
            }
            $sql = "select * from tbl_upcoming_events where (".$status." created_date BETWEEN '".$from."' AND '".$to."') ORDER BY id DESC";
              
            }

        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /******Fetch all Members Data from db*********/             
         $EventsData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
        $view = new ViewModel(array('EventsData'=>$EventsData,"Event"=>$eventType));
        $view->setTerminal(true);
        return $view;
        exit();
    }

    public function convertdate($date){

            $timestamp = strtotime($date);
            $date = date("Y/m/d h:i:s",$timestamp);
            return $date;
    }
    public function valdateselection($from,$to)
    {
        if(strtotime($from)>strtotime($to)){
            return false;
        }
        else return true;
    }
}
?>
