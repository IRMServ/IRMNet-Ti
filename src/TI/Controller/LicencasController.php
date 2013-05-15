<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Licencas;
use Zend\Form\Annotation\AnnotationBuilder;

class LicencasController extends AbstractActionController {

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
        $fab = new Licencas($this->getEntityManager());
        $total = $fab->getAll();        
        return new ViewModel(array('fab'=>$total,'messages-success'=>$messages_success));
    }
    
    public function storeAction()
    {
        $fab = new Licencas($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        $form->get('softwaresFk')->setEmptyOption('Escolha um Software')->setValueOptions($this->getServiceLocator()->get('SoftwaresPair'));;
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
                $this->flashMessenger()->addSuccessMessage("Licença cadastrada com sucesso");
                $this->redirect()->toRoute('ti/licencas');
            }
        }
        return new ViewModel(array('form'=>$form));        
    }
    public function removeAction() {
        $lic = new Licencas($this->getEntityManager());
        $id = $this->params()->fromRoute('id');
        $l = $lic->getById($id);
        $l->setEm($this->getEntityManager());
        $l->remove();
        $this->redirect()->toRoute('ti/licencas');
    }

}