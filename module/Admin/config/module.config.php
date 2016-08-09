<?php

use Zend\Authentication\AuthenticationService;

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Country' => 'Admin\Controller\CountryController',
            'Admin\Controller\State' => 'Admin\Controller\StateController',
            'Admin\Controller\City' => 'Admin\Controller\CityController',
            'Admin\Controller\Religion' => 'Admin\Controller\ReligionController',
            'Admin\Controller\Gothra' => 'Admin\Controller\GothraController',
            'Admin\Controller\Starsign' => 'Admin\Controller\StarsignController',
            'Admin\Controller\Zodiacsign' => 'Admin\Controller\ZodiacsignController',
            'Admin\Controller\Master' => 'Admin\Controller\MasterController',
            'Admin\Controller\News' => 'Admin\Controller\NewsController',
            'Admin\Controller\Events' => 'Admin\Controller\EventsController',
            'Admin\Controller\Matrimonyuser' => 'Admin\Controller\MatrimonyuserController',
            'Admin\Controller\Pages' => 'Admin\Controller\PagesController',
            'Admin\Controller\Homepage' => 'Admin\Controller\HomepageController',
        )
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admincontrol',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Index',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Index',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    'dashboard' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/dashboard',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'dashboard',
                            ),
                        ),
                    ),
                    'user' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/user[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'country' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/country[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Country',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'state' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/state[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\State',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'city' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/city[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\City',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'religion' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/religion[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Religion',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'gothra' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/gothra[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Gothra',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'starsign' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/starsign[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Starsign',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'zodiacsign' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/zodiacsign[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Zodiacsign',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'master' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/master[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Master',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'news' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/news[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\News',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'events' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/events[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Events',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'matrimonyuser' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/matrimonyuser[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Matrimonyuser',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                ),
            ),
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view'
        ),
       
    ),
    'admin_layout' => array(
        'use_admin_layout' => true,
        'admin_layout_template' => 'layout/adminLayout',
        'admin_login_layout_template' => 'layout/loginLayout',
        
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                $authenticationServices = new AuthenticationService();
                return $authenticationServices;
            }
        ),
    ),
);
