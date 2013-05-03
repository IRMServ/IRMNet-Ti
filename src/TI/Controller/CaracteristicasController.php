<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Caracteristicas;
use Zend\Form\Annotation\AnnotationBuilder;

class CaracteristicasController extends AbstractActionController {

    protected $em;
    protected $aCount = array();
  

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
        $messages_success = $this->flashMessenger()->getCurrentSuccessMessages();
        $fab = new Caracteristicas($this->getEntityManager());
        $total = $fab->getAll();        
        return new ViewModel(array('fab'=>$total,'messages-success'=>$messages_success));
    }
    
    public function storeAction()
    {
        $fab = new Caracteristicas($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        
        $id = $this->params()->fromRoute('id');
        if($id)
        {
            $form->bind($fab->getById($id));
            $form->get('submit')->setValue('Enviar');
        }
        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();
            $form->setData($data);
            if($form->isValid())
            {
                $fab->populate((array)$data);
                $fab->store();
                $this->flashMessenger()->addSuccessMessage("Caracteristica cadastrada com sucesso");
                $this->redirect()->toRoute('ti/caracteristicas');
            }
        }
        return new ViewModel(array('form'=>$form));        
    }

}