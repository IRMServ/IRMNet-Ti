<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Modeloequipamento;
use Zend\Form\Annotation\AnnotationBuilder;

class ModeloEquipamentoController extends AbstractActionController {

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
        $fab = new Modeloequipamento($this->getEntityManager());
        $total = $fab->getAll();        
        return new ViewModel(array('fab'=>$total,'messages-success'=>$messages_success));
    }
    
    public function storeAction()
    {
        $fab = new Modeloequipamento($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        $form->get('tipoequipamento')->setEmptyOption('Escolha um Tipo de Equipamento')->setValueOptions($this->getServiceLocator()->get('TipoEquipamentoPair'));;
        $form->get('fabricantes')->setEmptyOption('Escolha um Fabricante')->setValueOptions($this->getServiceLocator()->get('FabricantesPair'));;
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
                $this->flashMessenger()->addSuccessMessage("Modelo de Equipamento cadastrado com sucesso");
                $this->redirect()->toRoute('ti/modelo-equipamento');
            }
        }
        return new ViewModel(array('form'=>$form));        
    }

}