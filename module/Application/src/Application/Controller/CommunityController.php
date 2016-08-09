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

class CommunityController extends AbstractActionController
{
	public function indexAction()
    {

      $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $rows = $adapter->query("select * from tbl_community_mngmnt where status=1 group by agent_id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        $lonerows = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_status,tui.profile_photo,tbl_communities.*,tbl_user.email from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where (tui.comm_mem_status=1 && tbl_communities.Head=2)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

       
  
        $new = array();
        foreach ($rows as $a){

              $childs = $adapter->query("select * from tbl_community_mngmnt where (status=1 && agent_id=".$a['agent_id'].")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

              foreach ($childs as  $child) {
                  $children[] = $this->TreeUsersData($child['sub_agent_id']);
              }

            $parent = $this->TreeUsersData($a['agent_id']);
            $parent['mychild'] = $children;
            $new[$a['agent_id']] = $parent;
            unset($children);
        }
         foreach ($lonerows as $l) {
            $lone[$l['parent_id']][] = $l;
         }

   //     
      /******Return to View Model*********/
      	$filters_data = $this->sidebarFilters();

        return new ViewModel(array("filters_data"=>$filters_data,"new"=>$new,"lone"=>$lone,"firstrow"=>array()));
    }

    public function sidebarFilters()
	{
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

		$filters_array = array("country"=>"tbl_country","state"=>"tbl_state","designation"=>"tbl_designation","city"=>"tbl_city");

      	foreach($filters_array as $key =>$table){
      	 	$filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      	}
      	return $filters_data;
	}

  public function TreeUsersData($value='')
  {
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       $rows = $adapter->query("select tui.full_name,tui.comm_mem_id,tui.comm_mem_id,tui.profile_photo,tbl_communities.category_name,tbl_user.email from tbl_user_info as tui 
          inner join tbl_communities on tui.comm_mem_id = tbl_communities.id   
          inner join tbl_user on tui.user_id = tbl_user.id   
        where (tui.user_id=".$value." && tui.comm_mem_status=1)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
       
       $rows[0]['user_id'] = $value;

    return $rows[0];

  }


	
}
?>
