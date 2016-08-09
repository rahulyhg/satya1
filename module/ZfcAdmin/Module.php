<?php


namespace ZfcAdmin;

use Zend\ModuleManager\Feature;
use Zend\Loader;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use ZfcAdmin\Model\Entity\Countries;
use ZfcAdmin\Model\Entity\AllCountries;
use ZfcAdmin\Model\Entity\States;
use ZfcAdmin\Model\Entity\Cities;
use ZfcAdmin\Model\Entity\Religions;
use ZfcAdmin\Model\Entity\Gothras;
use ZfcAdmin\Model\Entity\Starsigns;
use ZfcAdmin\Model\Entity\Zodiacsigns;
use ZfcAdmin\Model\Entity\Educationfields;
use ZfcAdmin\Model\Entity\Educationlevels;
use ZfcAdmin\Model\Entity\Professions;
use ZfcAdmin\Model\Entity\Designations;
use ZfcAdmin\Model\Entity\Usertypes;
use ZfcAdmin\Model\Entity\Newses;
use ZfcAdmin\Model\Entity\Newscategories;
use ZfcAdmin\Model\Entity\Userinfos;
use ZfcAdmin\Model\Entity\Users;
use ZfcAdmin\Model\Entity\Events;
use ZfcAdmin\Model\Entity\AllPages;
use ZfcAdmin\Model\Entity\UserRoles;
use ZfcAdmin\Model\CountryTable;
use ZfcAdmin\Model\AllCountryTable;
use ZfcAdmin\Model\StateTable;
use ZfcAdmin\Model\CityTable;
use ZfcAdmin\Model\ReligionTable;
use ZfcAdmin\Model\GothraTable;
use ZfcAdmin\Model\StarsignTable;
use ZfcAdmin\Model\ZodiacsignTable;
use ZfcAdmin\Model\EducationfieldTable;
use ZfcAdmin\Model\EducationlevelTable;
use ZfcAdmin\Model\ProfessionTable;
use ZfcAdmin\Model\DesignationTable;
use ZfcAdmin\Model\UsertypeTable;
use ZfcAdmin\Model\NewsTable;
use ZfcAdmin\Model\NewscategoryTable;
use ZfcAdmin\Model\UserinfoTable;
use ZfcAdmin\Model\UserTable;
use ZfcAdmin\Model\EventsTable;
use ZfcAdmin\Model\PagesTable;
use ZfcAdmin\Model\UsersRolesTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
/**
 * Module class for ZfcAdmin
 *
 * @package ZfcAdmin
 */
class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\ServiceProviderInterface
    
{
    /**
     * @{inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            Loader\AutoloaderFactory::STANDARD_AUTOLOADER => array(
                Loader\StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @{inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    
//    public function onBootstrap(EventInterface $e)
//    {
//        $app = $e->getParam('application');
//        $em  = $app->getEventManager();
//
//        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'selectLayoutBasedOnRoute'));
//    }
//
//    /**
//     * Select the admin layout based on route name
//     *
//     * @param  MvcEvent $e
//     * @return void
//     */
//    public function selectLayoutBasedOnRoute(MvcEvent $e)
//    {
//        $app    = $e->getParam('application');
//        $sm     = $app->getServiceManager();
//        $config = $sm->get('config');
//
//        if (false === $config['zfcadmin']['use_admin_layout']) {
//            return;
//        }
//
//        $match      = $e->getRouteMatch();
//        $controller = $e->getTarget();
//        if (!$match instanceof RouteMatch
//            || 0 !== strpos($match->getMatchedRouteName(), 'zfcadmin')
//            || $controller->getEvent()->getResult()->terminate()
//        ) {
//            return;
//        }
//
//        $layout     = $config['zfcadmin']['admin_layout_template'];
//        $controller->layout($layout);
//    }

    public function getServiceConfig() {

        return array(

        'factories' => array(

        'ZfcAdmin\Model\CountryTable' =>   function($sm) {

        $tableGateway = $sm->get('CountryTableGateway');

        $table = new CountryTable($tableGateway);

        return $table;

        },
        'CountryTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Countries());

        return new TableGateway('tbl_country', $dbAdapter, null, $resultSetPrototype);

        },


        'ZfcAdmin\Model\StateTable' =>   function($sm) {

        $tableGateway = $sm->get('StateTableGateway');

        $table = new StateTable($tableGateway);

        return $table;

        },
        'StateTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new States());

        return new TableGateway('tbl_state', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\CityTable' =>   function($sm) {

        $tableGateway = $sm->get('CityTableGateway');

        $table = new CityTable($tableGateway);

        return $table;

        },
        'CityTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Cities());

        return new TableGateway('tbl_city', $dbAdapter, null, $resultSetPrototype);

        },


        'ZfcAdmin\Model\ReligionTable' =>   function($sm) {

        $tableGateway = $sm->get('ReligionTableGateway');

        $table = new ReligionTable($tableGateway);

        return $table;

        },
        'ReligionTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Religions());

        return new TableGateway('tbl_religion', $dbAdapter, null, $resultSetPrototype);

        },




        'ZfcAdmin\Model\GothraTable' =>   function($sm) {

        $tableGateway = $sm->get('GothraTableGateway');

        $table = new GothraTable($tableGateway);

        return $table;

        },
        'GothraTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Gothras());

        return new TableGateway('tbl_gothra_gothram', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\StarsignTable' =>   function($sm) {

        $tableGateway = $sm->get('StarsignTableGateway');

        $table = new StarsignTable($tableGateway);

        return $table;

        },
        'StarsignTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Starsigns());

        return new TableGateway('tbl_star_sign', $dbAdapter, null, $resultSetPrototype);

        },




        'ZfcAdmin\Model\ZodiacsignTable' =>   function($sm) {

        $tableGateway = $sm->get('ZodiacsignTableGateway');

        $table = new ZodiacsignTable($tableGateway);

        return $table;

        },
        'ZodiacsignTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Zodiacsigns());

        return new TableGateway('tbl_zodiac_sign_raasi', $dbAdapter, null, $resultSetPrototype);

        },


        'ZfcAdmin\Model\EducationfieldTable' => function($sm) {

        $tableGateway = $sm->get('EducationfieldTableGateway');

        $table = new EducationfieldTable($tableGateway);

        return $table;

        },
        'EducationfieldTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Educationfields());

        return new TableGateway('tbl_education_field', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\EducationlevelTable' => function($sm) {

        $tableGateway = $sm->get('EducationlevelTableGateway');

        $table = new EducationlevelTable($tableGateway);

        return $table;

        },
        'EducationlevelTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Educationlevels());

        return new TableGateway('tbl_education_level', $dbAdapter, null, $resultSetPrototype);

        },




        'ZfcAdmin\Model\ProfessionTable' => function($sm) {

        $tableGateway = $sm->get('ProfessionTableGateway');

        $table = new ProfessionTable($tableGateway);

        return $table;

        },
        'ProfessionTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Professions());

        return new TableGateway('tbl_profession', $dbAdapter, null, $resultSetPrototype);

        },


         'ZfcAdmin\Model\DesignationTable' => function($sm) {

        $tableGateway = $sm->get('DesignationTableGateway');

        $table = new DesignationTable($tableGateway);

        return $table;

        },
        'DesignationTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Designations());

        return new TableGateway('tbl_designation', $dbAdapter, null, $resultSetPrototype);

        },



         'ZfcAdmin\Model\UsertypeTable' => function($sm) {

        $tableGateway = $sm->get('UsertypeTableGateway');

        $table = new UsertypeTable($tableGateway);

        return $table;

        },
        'UsertypeTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Usertypes());

        return new TableGateway('tbl_user_type', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\NewsTable' => function($sm) {

        $tableGateway = $sm->get('NewsTableGateway');

        $table = new NewsTable($tableGateway);

        return $table;

        },
        'NewsTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Newses());

        return new TableGateway('tbl_news', $dbAdapter, null, $resultSetPrototype);

        },


          'ZfcAdmin\Model\NewscategoryTable' => function($sm) {

        $tableGateway = $sm->get('NewscategoryTableGateway');

        $table = new NewscategoryTable($tableGateway);

        return $table;

        },
        'NewscategoryTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Newscategories());

        return new TableGateway('tbl_newscategory', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\UserinfoTable' => function($sm) {

        $tableGateway = $sm->get('UserinfoTableGateway');

        $table = new UserinfoTable($tableGateway);

        return $table;

        },
        'UserinfoTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Userinfos());

        return new TableGateway('tbl_user_info', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\UserTable' => function($sm) {

        $tableGateway = $sm->get('UserTableGateway');

        $table = new UserTable($tableGateway);

        return $table;

        },
        'UserTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Users());

        return new TableGateway('tbl_user', $dbAdapter, null, $resultSetPrototype);

        },




        'ZfcAdmin\Model\EventsTable' => function($sm) {

        $tableGateway = $sm->get('EventsTableGateway');

        $table = new EventsTable($tableGateway);

        return $table;

        },
        'EventsTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new Events());

        return new TableGateway('tbl_upcoming_events', $dbAdapter, null, $resultSetPrototype);

        },


        'ZfcAdmin\Model\AllCountryTable' => function($sm) {

        $tableGateway = $sm->get('AllCountryTableGateway');

        $table = new AllCountryTable($tableGateway);

        return $table;

        },
        'AllCountryTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new AllCountries());

        return new TableGateway('allcountries', $dbAdapter, null, $resultSetPrototype);

        },



        'ZfcAdmin\Model\PagesTable' => function($sm) {

        $tableGateway = $sm->get('PagesTableGateway');

        $table = new PagesTable($tableGateway);

        return $table;

        },
        'PagesTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new AllPages());

        return new TableGateway('tbl_static_pages', $dbAdapter, null, $resultSetPrototype);

        },

        'ZfcAdmin\Model\UsersRolesTable' => function($sm) {

        $tableGateway = $sm->get('UsersRolesTableGateway');

        $table = new UsersRolesTable($tableGateway);

        return $table;

        },
        'UsersRolesTableGateway' => function ($sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new UserRoles());

        return new TableGateway('tbl_user_roles', $dbAdapter, null, $resultSetPrototype);

        },



        ),
      );
    }

}
