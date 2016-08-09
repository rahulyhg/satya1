<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use \Application\Model\UserTable;
use \Application\Model\UserTypeTable;
use \Application\Model\GothraTable;
use \Application\Model\ProfessionTable;
use \Application\Model\ContactTable;
use \Application\Model\UserInfoTable;
use \Application\Model\EducationLevelTable;
use \Application\Model\EducationFieldTable;
use \Application\Model\CountryTable;
use \Application\Model\StateTable;
use \Application\Model\CityTable;
use \Application\Model\AnnualIncomeTable;
use \Application\Model\HeightTable;
use \Application\Model\ReligionTable;
use \Application\Model\EmailLogsTable;
use \Application\Model\FamilyInfoTable;
use \Application\Model\DesignationTable;
use \Application\Model\RustagiBranchTable;
use \Application\Model\PostcategoryTable;
use \Application\Model\PostTable;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface; 

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    // public function getViewHelperConfig()
    // {
    // return array(
    //     'factories' => array(
    //         'liveStreaming' => function($sl) {
    //             // Get the shared service manager instance
    //             $sm = $sl->getServiceLocator(); 
    //             $liveStreamingTable = $sm->get('Application\Model\CountryTable');
    //             // Now inject it into the view helper constructor
    //             return new LiveStreaming($liveStreamingTable);
    //         },
    //     ),
    //   );
    // } 

   //  public function getViewHelperConfig()
   //  {
   //      return array(
   //          'factories' => array(
   //              'auth_helper' => function($sm) {
   //                  $helper = new View\Helper\Testhelper ;
   //                  return $helper;
   //              }
   //          )
   //      );   
   // }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                 'myHelper' => function($sm) {
                      // either create a new instance of your model
                      //$model = new \Application\Model\CountryTable();
                      // or, if your model is in the servicemanager, fetch it from there
                      $dbAdapter = $sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                      $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                      // $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                      // print_r($model);
                      // die;
                      // create a new instance of your helper, injecting the model it uses
                      $helper = new \Application\View\Helper\MyHelper($model, $dbAdapter);
                      return $helper;
                 },
             ),
        );
    }
   
	public function getServiceConfig() {
        return array(
            'factories' => array(
               'SpeckAuthnet\Client' => function($sm){
                return new \SpeckAuthnet\Client;
               },
                'Application\Model\UserTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($dbAdapter);
                    return $table;
                },
                'Application\Model\UserTypeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTypeTable($dbAdapter);
                    return $table;
                },
                'Application\Model\GothraTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new GothraTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ProfessionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProfessionTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ContactTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EmailLogsTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EmailLogsTable($dbAdapter);
                    return $table;
                },
                'Application\Model\UserInfoTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserInfoTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EducationLevelTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EducationLevelTable($dbAdapter);
                    return $table;
                },
                'Application\Model\CountryTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CountryTable($dbAdapter);
                    return $table;
                },
                'Application\Model\StateTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new StateTable($dbAdapter);
                    return $table;
                },
                'Application\Model\CityTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CityTable($dbAdapter);
                    return $table;
                },
                'Application\Model\AnnualIncomeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AnnualIncomeTable($dbAdapter);
                    return $table;
                },
                'Application\Model\HeightTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new HeightTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EducationFieldTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EducationFieldTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ReligionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ReligionTable($dbAdapter);
                    return $table;
                },
				'Application\Model\FamilyInfoTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new FamilyInfoTable($dbAdapter);
                    return $table;
                },
				'Application\Model\DesignationTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new DesignationTable($dbAdapter);
                    return $table;
                },
				'Application\Model\RustagiBranchTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RustagiBranchTable($dbAdapter);
                    return $table;
                },'Application\Model\PostcategoryTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PostcategoryTable($dbAdapter);
                    return $table;
                },'Application\Model\PostTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PostTable($dbAdapter);
                    return $table;
                }
				
				
            ),
        );
    }
}