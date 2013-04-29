<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Fabricantes;
use TI\Entity\Tipoequipamento;
use Zend\Form\Annotation\AnnotationBuilder;

class TipoEquipamentoController extends AbstractActionController {

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
        $fab = new Tipoequipamento($this->getEntityManager());
        $total = $fab->getAll();        
        return new ViewModel(array('fab'=>$total,'messages-success'=>$messages_success));
    }
    
    public function storeAction()
    {
        $fab = new Tipoequipamento($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        $fabricante  = $form->get('fabricantesFk')->setEmptyOption('Escolha um Fabricante')->setValueOptions($this->getServiceLocator()->get('FabricantesPair'));;
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
                $this->flashMessenger()->addSuccessMessage("Tipo de Equipamento cadastrado com sucesso");
                $this->redirect()->toRoute('ti/tipo-equipamento');
            }
        }
        return new ViewModel(array('form'=>$form));        
    }

}