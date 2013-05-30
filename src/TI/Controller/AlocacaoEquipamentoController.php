<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Alocacaoequipamento;
use Zend\Form\Annotation\AnnotationBuilder;
use \DateTime;

class AlocacaoEquipamentoController extends AbstractActionController {

    protected $em;
    protected $aCount = array();

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
        $ae = new Alocacaoequipamento($this->getEntityManager());
        $all = $ae->getAll();
        return new ViewModel(array('all'=>$all));
    }

    public function storeAction() {
        $fab = new Alocacaoequipamento($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        $id = $this->params()->fromRoute('id');
        $form->get('colaborador')->setEmptyOption('Escolha um Colaborador')->setValueOptions($this->getServiceLocator()->get('UsersPair'));
        $form->get('setor')->setEmptyOption('Escolha um Setor')->setValueOptions($this->getServiceLocator()->get('SetoresPair'));
        $form->get('equipamentoFk')->setEmptyOption('Escolha um Equipamento')->setValueOptions($this->getServiceLocator()->get('EquipamentoPair'));
        if ($id) {
            $form->bind($fab->getById($id));
            $form->get('submit')->setValue('Enviar');
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $inicio = empty($data['datainicio']) || !isset($data['datainicio']) || is_null($data['datainicio']) ? new DateTime('now') :new DateTime(implode('-',array_reverse(explode('/',$data['datainicio']))));;
                $fab->setDatainicio($inicio);
                $fab->populate((array) $data);
                $fab->store();
                $this->flashMessenger()->addSuccessMessage("Alocação cadastrada com sucesso");
                $this->redirect()->toRoute('ti/alocacao');
            }
        }
        return new ViewModel(array('form' => $form));
    }

}