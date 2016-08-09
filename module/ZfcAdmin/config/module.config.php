<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'ZfcAdmin\Controller\AdminController' => 'ZfcAdmin\Controller\AdminController',
            'ZfcAdmin\Controller\CountryController' => 'ZfcAdmin\Controller\CountryController',
            'ZfcAdmin\Controller\StateController' => 'ZfcAdmin\Controller\StateController',
            'ZfcAdmin\Controller\CityController' => 'ZfcAdmin\Controller\CityController',
            'ZfcAdmin\Controller\ReligionController' => 'ZfcAdmin\Controller\ReligionController',
            'ZfcAdmin\Controller\GothraController' => 'ZfcAdmin\Controller\GothraController',
            'ZfcAdmin\Controller\StarsignController' => 'ZfcAdmin\Controller\StarsignController',
            'ZfcAdmin\Controller\ZodiacsignController' => 'ZfcAdmin\Controller\ZodiacsignController',
            'ZfcAdmin\Controller\MasterController' => 'ZfcAdmin\Controller\MasterController',
            'ZfcAdmin\Controller\NewsController' => 'ZfcAdmin\Controller\NewsController',
            'ZfcAdmin\Controller\EventsController' => 'ZfcAdmin\Controller\EventsController',
            'ZfcAdmin\Controller\MatrimonyuserController' => 'ZfcAdmin\Controller\MatrimonyuserController',
            'ZfcAdmin\Controller\PagesController' => 'ZfcAdmin\Controller\PagesController',
            'ZfcAdmin\Controller\HomepageController' => 'ZfcAdmin\Controller\HomepageController',
        ),
    ),
//    'zfcadmin' => array(
//        'use_admin_layout' => true,
//        'admin_layout_template' => 'layout/adminLayout',
//    ),
    'navigation' => array(
        'admin' => array(),
    ),
    // 'router' => array(
    //     'routes' => array(
    //         'zfcadmin' => array(
    //             'type' => 'segment',
    //             'options' => array(
    //             'route'       => '/admin[/:action][/:id]',
    //             'constraints' => array(
    //                 'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    //             ),
    //                 'defaults' => array(
    //                     'controller' => 'ZfcAdmin\Controller\AdminController',
    //                     'action'     => 'index',
    //                 ),
    //             ),
    //             'may_terminate' => true,
    //         ),
    //     ),
    // ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZfcAdmin\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZfcAdmin\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                ),
            ),
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZfcAdmin\Controller',
                        'controller' => 'Index',
                        'action' => 'login',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'ZfcAdmin\Controller\Index' => 'ZfcAdmin\Controller\IndexController',
            'ZfcAdmin\Controller\Admin' => 'ZfcAdmin\Controller\AdminController',
            'ZfcAdmin\Controller\Country' => 'ZfcAdmin\Controller\CountryController',
            'ZfcAdmin\Controller\State' => 'ZfcAdmin\Controller\StateController',
            'ZfcAdmin\Controller\City' => 'ZfcAdmin\Controller\CityController',
            'ZfcAdmin\Controller\Religion' => 'ZfcAdmin\Controller\ReligionController',
            'ZfcAdmin\Controller\Gothra' => 'ZfcAdmin\Controller\GothraController',
            'ZfcAdmin\Controller\Starsign' => 'ZfcAdmin\Controller\StarsignController',
            'ZfcAdmin\Controller\Zodiacsign' => 'ZfcAdmin\Controller\ZodiacsignController',
            'ZfcAdmin\Controller\Master' => 'ZfcAdmin\Controller\MasterController',
            'ZfcAdmin\Controller\News' => 'ZfcAdmin\Controller\NewsController',
            'ZfcAdmin\Controller\Events' => 'ZfcAdmin\Controller\EventsController',
            'ZfcAdmin\Controller\Matrimonyuser' => 'ZfcAdmin\Controller\MatrimonyuserController',
            'ZfcAdmin\Controller\Pages' => 'ZfcAdmin\Controller\PagesController',
            'ZfcAdmin\Controller\Homepage' => 'ZfcAdmin\Controller\HomepageController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/adminLayout.phtml',
           // 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
           // 'application/membership/filters' => __DIR__ . '/../view/application/membership/filters.phtml',
          //  'error/404' => __DIR__ . '/../view/error/404.phtml',
          //  'error/index' => __DIR__ . '/../view/error/index.phtml',
        //'flash-message' => __DIR__ . '/../view/layout/partial/flash-message.phtml',
        ),
    ),
);
