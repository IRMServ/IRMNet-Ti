<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'TI\Controller\Index' => 'TI\Controller\IndexController',
            'TI\Controller\Impressao' => 'TI\Controller\ImpressaoController',
            'TI\Controller\HelpDesk' => 'TI\Controller\HelpDeskController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'ti' => array(
                'type' => 'Literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/ti',
                    'defaults' => array(
                        'controller' => 'TI\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'helpdesk' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/helpdesk',
                            'defaults' => array(
                                'controller' => 'TI\Controller\HelpDesk',
                                'action' => 'index',
                                'setor' => 1
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'open' => array(
                                'type' => 'Literal',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/open',
                                    'defaults' => array(
                                        'action' => 'store',
                                    ),
                                ),
                            ),
                            'helpdesk-page' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/page[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                            ),
                            'chamado' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/chamado/:chamado',
                                    'constraints' => array(
                                        'chamado' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'chamado',
                                        'chamado' => 0
                                    ),
                                ),
                                'child_routes' => array(
                                    'avaliar-chamado' => array(
                                        'type' => 'Literal',
                                        'may_terminate' => true,
                                        'options' => array(
                                            'route' => '/avaliar',
                                            'defaults' => array(
                                                'action' => 'avaliar',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'fechar' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/fechar/chamado/:chamado',
                                    'constraints' => array(
                                        'chamado' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'close',
                                        'chamado' => 0
                                    ),
                                ),
                            ),
                            'changeprioridade' => array(
                                'type' => 'Literal',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/changeprioridade',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\HelpDesk',
                                        'action' => 'changeprioridade',
                                    ),
                                ),
                            ),
                            'indicadores' => array(
                                'type' => 'Literal',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/indicadores',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\HelpDesk',
                                        'action' => 'indicadores',
                                    ),
                                ),
                            ),
                            'chamado-resposta' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/chamado/:id/resposta',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'resposta',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        )
                    ),
                    'impressao' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/impressao',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Impressao',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'relatorio' => array(
                                'type' => 'Literal',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/relatorio',
                                    'defaults' => array(
                                        'action' => 'index',
                                        'controller' => 'TI\Controller\Impressao',
                                    ),
                                ),
                                'child_routes' => array(
                                    'crescente' => array(
                                        'type' => 'Literal',
                                        'may_terminate' => true,
                                        'options' => array(
                                            'route' => '/crescente',
                                            'defaults' => array(
                                                'action' => 'ordemcres',
                                                'controller' => 'TI\Controller\Impressao',
                                            ),
                                        ),
                                    ),
                                    'decrescente' => array(
                                        'type' => 'Literal',
                                        'may_terminate' => true,
                                        'options' => array(
                                            'route' => '/decrescente',
                                            'defaults' => array(
                                                'action' => 'ordemdesc',
                                                'controller' => 'TI\Controller\Impressao',
                                            ),
                                        ),
                                    ),
                                )
                            ),
                        )
                    ),
//                    'setor' => array(
//                        'type' => 'Literal',
//                        'options' => array(
//                            'route' => '/setor',
//                            'defaults' => array(
//                                'controller' => 'TI\Controller\Setor',
//                                'action' => 'index',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'store' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/store[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'store',
//                                    ),
//                                ),
//                            ),
//                            'delete' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/delete[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'setor-page' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/page[/:page]',
//                                    'constraints' => array(
//                                        'page' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'index',
//                                        'page' => 1
//                                    ),
//                                ),
//                            ),
//                        )
//                    ),
//                    'status-chamado' => array(
//                        'type' => 'Literal',
//                        'options' => array(
//                            'route' => '/status-chamado',
//                            'defaults' => array(
//                                'controller' => 'TI\Controller\StatusChamado',
//                                'action' => 'index',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'store' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/store[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'store',
//                                    ),
//                                ),
//                            ),
//                            'delete' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/delete[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'status-chamado-page' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/page[/:page]',
//                                    'constraints' => array(
//                                        'page' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'index',
//                                        'page' => 1
//                                    ),
//                                ),
//                            ),
//                        )
//                    ),
//                    'prioridade-chamado' => array(
//                        'type' => 'Literal',
//                        'options' => array(
//                            'route' => '/prioridade-chamado',
//                            'defaults' => array(
//                                'controller' => 'TI\Controller\PrioridadeChamado',
//                                'action' => 'index',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'store' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/store[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'store',
//                                    ),
//                                ),
//                            ),
//                            'delete' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/delete[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'prioridade-page' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/page[/:page]',
//                                    'constraints' => array(
//                                        'page' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'index',
//                                        'page' => 1
//                                    ),
//                                ),
//                            ),
//                        )
//                    ),
//                    'status-chamado' => array(
//                        'type' => 'Literal',
//                        'options' => array(
//                            'route' => '/status-chamado',
//                            'defaults' => array(
//                                'controller' => 'TI\Controller\StatusChamado',
//                                'action' => 'index',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'store' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/store[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'store',
//                                    ),
//                                ),
//                            ),
//                            'delete' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/delete[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'status-chamado-page' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/page[/:page]',
//                                    'constraints' => array(
//                                        'page' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'index',
//                                        'page' => 1
//                                    ),
//                                ),
//                            ),
//                        )
//                    ),
//                    'categoria-chamado' => array(
//                        'type' => 'Literal',
//                        'options' => array(
//                            'route' => '/categoria-chamado',
//                            'defaults' => array(
//                                'controller' => 'TI\Controller\categoriaChamado',
//                                'action' => 'index',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'store' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/store[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'store',
//                                    ),
//                                ),
//                            ),
//                            'delete' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/delete[/:id]',
//                                    'constraints' => array(
//                                        'id' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'categoria-chamado-page' => array(
//                                'type' => 'Segment',
//                                'may_terminate' => true,
//                                'options' => array(
//                                    'route' => '/page[/:page]',
//                                    'constraints' => array(
//                                        'page' => '[0-9]+'
//                                    ),
//                                    'defaults' => array(
//                                        'action' => 'index',
//                                        'page' => 1
//                                    ),
//                                ),
//                            ),
//                        )
//                    ),
                )
            ),
        ),
    ),
//    'router' => array(
//        'routes' => array(
//            'ti' => array(
//                'type' => 'Literal',
//                'options' => array(
//                    'route' => '/ti',
//                    'defaults' => array(
//                       
//                        'controller' => 'TI\Controller\Index',
//                        'action' => 'index',
//                    ),
//                ),
//                
//            ),
//        ),
//    ),
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
//        'navigation' =>
//    
//    array(
//        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
//        'default' => array(
//            // And finally, here is where we define our page hierarchy
//            'ti-default' => array(
//                'label' => 'Painel',
//                'route' => 'ti',
//                'module'=>'TI',
//                 'privilege'=>'TI'
//               
//               
////                'pages' => array(
////                    'ti' => array(
////                        'label' => 'T.I.',
////                        'route' => 'ti/helpdesk',
////                        'params' => array('setor' => 2)
////                    ),
////                    'projetos-especiais-nav' => array(
////                        'label' => 'Projetos Especiais',
////                        'route' => 'helpdesk',
////                        'params' => array('setor' => 2)
////                    )
////                )
//            ),
//        ),
//    ),
);
