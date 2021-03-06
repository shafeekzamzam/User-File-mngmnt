<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
            'Users\Controller\Register' => 'Users\Controller\RegisterController',
            'Users\Controller\Login' => 'Users\Controller\LoginController',
             'Users\Controller\UserManager' => 'Users\Controller\UserManagerController',
             'Users\Controller\UploadManager' => 'Users\Controller\UploadManagerController'
        ),
    ),
    'router' => array(
        'routes' => array(
        		
            'users' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/users',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Users\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
          
                    'login' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/login[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Users\Controller\Login',
                                'action' => 'index'
                            )
                        )
                    ),
                    'register' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/register[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Users\Controller\Register',
                                'action' => 'index'
                            )
                        )
                    ),
                    'user-manager' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user-manager[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Users\Controller\UserManager',
                                'action' => 'index'
                            )
                        )
                    ),
                    'upload-manager' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/upload-manager[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*'                              
                            ),
                            'defaults' => array(
                                'controller' => 'Users\Controller\UploadManager',
                                'action' => 'index'
                            )
                        )
                    )
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
    ),
    //MODULE CONFIGURATIONS
    'module_config' => array(
        'upload_location' => __DIR__.'/../../../data'
    )
);
