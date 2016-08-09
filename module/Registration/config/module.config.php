<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Registration\Controller\Registration' => 'Registration\Controller\RegistrationController'
		)
	),
	'router' => array(
		'routes' => array(
			'registration' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/registration[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Registration\Controller\Registration',
						'action' => 'index'
					)
				)
			)
		)
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'registration' => __DIR__ . '/../view'
		),
	)
);