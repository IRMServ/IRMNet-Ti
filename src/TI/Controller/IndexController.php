<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    

    public function indexAction() {
        $cURL = curl_init("http://192.168.0.14/main/main.html");
        
	// Define a opção que diz que você quer receber o resultado encontrado
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cURL,CURLOPT_FOLLOWLOCATION, false);
	// Executa a consulta, conectando-se ao site e salvando o resultado na variável $resultado
	$string = curl_exec($cURL);
	// Encerra a conexão com o site
	curl_close($cURL);
        //$string = file_get_contents("http://192.168.0.14/main/main.html");
        $exp = explode("Page Counter :",$string);
        $exp = explode("<",$exp[1]);
        $exp = $exp[0];
        //echo $exp;
        return new ViewModel();
        
    }

   
}
