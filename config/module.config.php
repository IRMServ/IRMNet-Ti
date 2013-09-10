<?php

namespace TI;

return array(
    'controllers' => array(
        'invokables' => array(
            'TI\Controller\Index' => 'TI\Controller\IndexController',
            'TI\Controller\Impressao' => 'TI\Controller\ImpressaoController',
            'TI\Controller\Fabricantes' => 'TI\Controller\FabricantesController',
            'TI\Controller\HelpDesk' => 'TI\Controller\HelpDeskController',
            'TI\Controller\Softwares' => 'TI\Controller\SoftwaresController',
            'TI\Controller\Licencas' => 'TI\Controller\LicencasController',
            'TI\Controller\Caracteristicas' => 'TI\Controller\CaracteristicasController',
            'TI\Controller\TipoEquipamento' => 'TI\Controller\TipoEquipamentoController',
            'TI\Controller\ModeloEquipamento' => 'TI\Controller\ModeloEquipamentoController',
            'TI\Controller\ModeloImpressora' => 'TI\Controller\ModeloImpressoraController',
            'TI\Controller\AlocacaoEquipamento' => 'TI\Controller\AlocacaoEquipamentoController',
            'TI\Controller\Equipamentos' => 'TI\Controller\EquipamentosController',
            'TI\Controller\EquipamentosRestful' => 'TI\Controller\EquipamentosRestfulController',
        ),
    ),
    'acl' => array(
        'TI' => array(
            'TI' => array(
                'TI\Controller\Index:index',
                'TI\Controller\Impressao:index',
                'TI\Controller\Impressao:periodo',
                'TI\Controller\Impressao:detalhedia',
                'TI\Controller\Impressao:detalhediaprinter',
                'TI\Controller\Impressao:detalheusuario',
                'TI\Controller\Impressao:detalheprinter',
                'TI\Controller\AlocacaoEquipamento:index',
                'TI\Controller\AlocacaoEquipamento:store',
                'TI\Controller\AlocacaoEquipamento:realocar',
                'TI\Controller\AlocacaoEquipamento:terminar',
                'TI\Controller\Caracteristicas:index',
                'TI\Controller\Caracteristicas:store',
                'TI\Controller\Equipamentos:index',
                'TI\Controller\Equipamentos:store',
                'TI\Controller\Equipamentos:deletelicencas',
                'TI\Controller\Equipamentos:storestorecaracteristica',
                'TI\Controller\Equipamentos:storelicencas',
                'TI\Controller\Equipamentos:descricaologica',
                'TI\Controller\Equipamentos:descricaofisica',
                'TI\Controller\Equipamentos:equipamento',
                'TI\Controller\Equipamentos:upload',
                'TI\Controller\Equipamentos:update',
                'TI\Controller\Equipamentos:uploadjs',
                'TI\Controller\Softwares:index',
                'TI\Controller\Softwares:store',
                'TI\Controller\TipoEquipamento:index',
                'TI\Controller\TipoEquipamento:store',
                'TI\Controller\Licencas:index',
                'TI\Controller\Licencas:store',
                'TI\Controller\Licencas:remove',
                'TI\Controller\ModeloEquipamento:index',
                'TI\Controller\ModeloImpressora:index',
                'TI\Controller\ModeloImpressora:store',
                'TI\Controller\ModeloEquipamento:store',
                'TI\Controller\ModeloEquipamento:gettipo',
                'TI\Controller\Modelos:index',
                'TI\Controller\Modelos:store',
                'TI\Controller\Modelos:gettipo',
                'TI\Controller\Fabricantes:index',
                'TI\Controller\Fabricantes:store',
                'TI\Controller\HelpDesk:index',
                'TI\Controller\HelpDesk:store',
                'TI\Controller\HelpDesk:chamado',
                'TI\Controller\HelpDesk:resposta',
                'TI\Controller\HelpDesk:changeprioridade',
                'TI\Controller\HelpDesk:close',
                'TI\Controller\HelpDesk:avaliar',
                'TI\Controller\HelpDesk:indicadores',
                'ZFTool\Controller\Diagnostics:run',
            ),
        )
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
                    'upload' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/upload',
                            'defaults' => array(
                                'action' => 'upload',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'uploadagir' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/uploadagir',
                            'defaults' => array(
                                'action' => 'uploadagir',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'fabricantes' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/fabricantes',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Fabricantes',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\Fabricantes',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'tipo-equipamento' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/tipo-equipamento',
                            'defaults' => array(
                                'controller' => 'TI\Controller\TipoEquipamento',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\TipoEquipamento',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'modelo-impressora' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modelo-impressora',
                            'defaults' => array(
                                'controller' => 'TI\Controller\ModeloImpressora',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\ModeloImpressora',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'modelos' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modelos-impressora[/:action[/:id]]',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Modelos',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'alocacao' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/alocacao',
                            'defaults' => array(
                                'controller' => 'TI\Controller\AlocacaoEquipamento',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\AlocacaoEquipamento',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'termina' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/termina-alocacao/:id',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\AlocacaoEquipamento',
                                        'action' => 'termina',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'realocar' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/realocar/:id',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\AlocacaoEquipamento',
                                        'action' => 'realocar',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'softwares' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/softwares',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Softwares',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\Softwares',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'licencas' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/licencas',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Licencas',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\Licencas',
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/remove/:id',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\Licencas',
                                        'action' => 'remove',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'caracteristicas' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/caracteristicas',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Caracteristicas',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'modelo-equipamento' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modelo-equipamento',
                            'defaults' => array(
                                'controller' => 'TI\Controller\ModeloEquipamento',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'get-tipos' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/get-tipo',
                                    'defaults' => array(
                                        'action' => 'gettipo',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'equipamentos' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/equipamentos',
                            'defaults' => array(
                                'controller' => 'TI\Controller\Equipamentos',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'store' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store[/:id]',
                                    'defaults' => array(
                                        'action' => 'store',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'deletelicencas' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/deletelicencas[/:licequid]',
                                    'defaults' => array(
                                        'action' => 'store',
                                        'licequid' => 0
                                    ),
                                ),
                            ),
                            'update' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/update',
                                    'defaults' => array(
                                        'action' => 'update',
                                    ),
                                ),
                            ),
                            'update-restful' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/update-restful',
                                    'defaults' => array(
                                        'controller' => 'TI\Controller\EquipamentosRestful',
                                        'action' => 'update',
                                    ),
                                ),
                            ),
                            'get-detalhe' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/detalhe/:id',
                                    'defaults' => array(
                                        'action' => 'equipamento',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'upload-equipamento' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/upload/:id',
                                    'defaults' => array(
                                        'action' => 'upload',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'upload-equipamento-js' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/upload-js/:id',
                                    'defaults' => array(
                                        'action' => 'uploadjs',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'descricao-logica' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/descricao-logica/:id',
                                    'defaults' => array(
                                        'action' => 'descricaologica',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'descricao-fisica' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/descricao-fisica/:id',
                                    'defaults' => array(
                                        'action' => 'descricaofisica',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'storecaracteristica' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store/caracteristica/:id',
                                    'defaults' => array(
                                        'action' => 'storestorecaracteristica',
                                        'controller' => 'TI\Controller\Equipamentos',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'storelicencas' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/store/licencas/:id',
                                    'defaults' => array(
                                        'action' => 'storelicencas',
                                        'id' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
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
                            'impressao-periodo' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/periodo/:ano/:mes',
                                    'defaults' => array(
                                        'action' => 'periodo',
                                        'ano' => 0,
                                        'mes' => 0
                                    ),
                                ),
                            ),
                            'impressao-dia' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/periodo/:data',
                                    'defaults' => array(
                                        'action' => 'detalhedia',
                                        'data' => 0,
                                    ),
                                ),
                            ),
                            'impressao-dia-printer' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/periodo/:data/impressora',
                                    'defaults' => array(
                                        'action' => 'detalhediaprinter',
                                        'data' => 0,
                                    ),
                                ),
                            ),
                            'impressao-usuario' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/usuario/:usuario/periodo/:periodo',
                                    'defaults' => array(
                                        'action' => 'detalheusuario',
                                        'usuario' => 0,
                                    ),
                                ),
                            ),
                            'impressao-printer' => array(
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => array(
                                    'route' => '/impressora/:printer/periodo/:periodo',
                                    'defaults' => array(
                                        'action' => 'detalheprinter',
                                        'printer' => 0,
                                    ),
                                ),
                            ),
                        )
                    ),
                )
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            __NAMESPACE__ . '_driver_alternative' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            ),
            'orm_alternative' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver_alternative'
                )
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
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'barra' => 'TI\View\Helper\Barra'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'FabricantesPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Fabricantes')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdfabricantes()] = $f->getFabricante();
                }
                return $farray;
            },
            'SoftwaresPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Softwares')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdsoftwares()] = $f->getSoftware();
                }
                return $farray;
            },
            'TipoEquipamentoPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Tipoequipamento')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdtipoequipamento()] = $f->getNome();
                }
                return $farray;
            },
            'LicencasSoftwaresPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Licencas')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdlicencas()] = "{$f->getSoftwaresFk()->getSoftware()} - {$f->getLicenca()}";
                }
                return $farray;
            },
            'CaracteristicasPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Caracteristicas')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdcaracteristicas()] = $f->getCaracteristica();
                }
                return $farray;
            },
            'ModeloEquipPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Modeloequipamento')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $farray[$f->getIdmodeloequipamento()] = $f->getModelo();
                }
                return $farray;
            },
            'EquipamentoPair' => function($sm) {
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $s = $em->getRepository('TI\Entity\Equipamento')->findAll();
                $farray = array();
                foreach ($s as $f) {
                    $nome = 'IRM/';
                    $nome .= "{$f->getModeloequipamento()->getTipoequipamento()->getSigla()}/";
                    $nome .= "{$f->getNome()}";
                    $farray[$f->getIdequipamento()] = $nome;
                }
                return $farray;
            },
        )
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),
    'navigation' => array(
        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(
            // And finally, here is where we define our page hierarchy
            'ti-default' => array(
                'label' => 'Painel',
                'route' => 'ti',
                'module' => 'TI\Controller\Index:index',
                'privilege' => 'TI'


// 'pages' => array(
// 'ti' => array(
// 'label' => 'T.I.',
// 'route' => 'ti/helpdesk',
// 'params' => array('setor' => 2)
// ),
// 'projetos-especiais-nav' => array(
// 'label' => 'Projetos Especiais',
// 'route' => 'helpdesk',
// 'params' => array('setor' => 2)
// )
// )
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'importar-impressao' => array(
                    'options' => array(
                        'route' => 'impressao (--importar|-i) [--all|-a] --caminho= [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'TI\Controller\Impressao',
                            'action' => 'importar'
                        )
                    )
                )
            )
        )
    )
);