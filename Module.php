<?php
namespace TI;use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\ConfigurationFactory as ORMConfigurationFactory;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
class Module implements ServiceProviderInterface,ConsoleUsageProviderInterface
{
     public function onBootstrap(MvcEvent $e) {
        $application = $e->getApplication();
        $services = $application->getServiceManager();
        $this->initDatabase($services);
    }

    protected function initDatabase(ServiceLocatorInterface $services) {
        $em = $services->get('doctrine.entitymanager.orm_default');

        $dir = __DIR__ . '/src/' . __NAMESPACE__ . '/Entity/*.php';
        $classes = array();

        foreach (glob($dir) as $file) {
         
            $filename = end(explode('/', $file));
               $lock = 'lock/'.$filename . '.lock';
            if (!file_exists($lock)) {
                include($file);
                $entity = str_replace('.php', '', $file);
                $ex = end(explode('/', $entity));

                $newentity = __NAMESPACE__ . '\Entity\\' . $ex;
                $obj = new $newentity($em);
                $classes[] = $em->getClassMetadata($newentity);
                file_put_contents($lock, 'lock');
            }
        }
        $tool = new SchemaTool($em);
        $tool->createSchema($classes);
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
    public function getServiceConfig()
    {   
       return array(
            'factories' => array(
                'doctrine.entitymanager.orm_alternative'        => new EntityManagerFactory('orm_alternative'),
                'doctrine.connection.orm_alternative'           => new DBALConnectionFactory('orm_alternative'),
                'doctrine.configuration.orm_alternative'        => new ORMConfigurationFactory('orm_alternative'),
                ),
           );

    }
    public function getConsoleUsage(Console $console){
        return array(
            // Describe available commands
            'impressao (--importar|-i) --caminho= [--verbose|-v]'    => 'Importa dados de impressão a partir de um arquivo',

            // Describe expected parameters
            
            
            array( '--importar|-i',     'Importar dados da impressão'        ),
            array( '--caminho',     'Caminho arquivo de dados da impressão'        ),
            array( '--verbose|-v',     '(optional) turn on verbose mode'        ),
        );
    }
    
}
