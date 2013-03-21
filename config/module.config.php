<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'TI\Controller\Index' => 'TI\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'ti' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/ti',
                    'defaults' => array(
                       
                        'controller' => 'TI\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../../Base/view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../../Base/view/error/404.phtml',
            'error/index' => __DIR__ . '/../../Base/view/error/index.phtml',
            'partials/navigation' => __DIR__ . '/../view/partials/navigation.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
