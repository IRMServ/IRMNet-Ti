<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Equipamento,
    TI\Entity\Caracteristicas,
    TI\Entity\EquipamentoCaracteristica,
    TI\Entity\Licencas;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation\AnnotationBuilder;

class EquipamentosController extends AbstractActionController {

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
        $fab = new Equipamento($this->getEntityManager());
        $total = $fab->getAll();
        return new ViewModel(array('fab' => $total, 'messages-success' => $messages_success));
    }

    public function storeAction() {
        $fab = new Equipamento($this->getEntityManager());
        $afb = new AnnotationBuilder();
        $form = $afb->createForm($fab);
        $form->get('tipoequipamentoFk')->setEmptyOption('Escolha um Tipo de Equipamento')->setValueOptions($this->getServiceLocator()->get('TipoEquipamentoPair'));

        $id = $this->params()->fromRoute('id');
        if ($id) {
            $form->bind($fab->getById($id));
            $form->get('submit')->setValue('Enviar');
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $fab->populate((array) $data);
                $fab->store();
                $this->flashMessenger()->addSuccessMessage("Equipamento cadastrado com sucesso");
                $this->redirect()->toRoute('ti/equipamentos/storecaracteristica', array('id' => $fab->getIdequipamento()));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function storestorecaracteristicaAction() {
        $fab = new EquipamentoCaracteristica($this->getEntityManager());
        $id = $this->params()->fromRoute('id');
        $e = new Equipamento($this->getEntityManager());
        $equi = $e->getById($id);
        $carac = $this->getServiceLocator()->get('CaracteristicasPair');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            foreach ($data['my-select'] as $d) {
                $caract = new Caracteristicas($this->getEntityManager());
                $c = $caract->getById($d);
                $fab->setCaracteristicasFk($c);
                $fab->setEquipamentoFk($equi);
                $fab->setDetalhe($data[str_replace(' ', '_', $c->getCaracteristica())]);
                $fab->store();
            }
            $this->redirect()->toRoute('ti/equipamentos/storelicencas', array('id' => $id));
        }
        return new ViewModel(array('carac' => $carac));
    }

    public function storelicencasAction() {
        $colequi = new ArrayCollection();
        $collicen = new ArrayCollection();
        $licen = new Licencas($this->getEntityManager());

        $id = $this->params()->fromRoute('id');
        $e = new Equipamento($this->getEntityManager());

       
        $carac = $this->getServiceLocator()->get('LicencasSoftwaresPair');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            foreach ($data['my-select'] as $d) {
                $equi = $e->getById($id);
                $li = $licen->getById($d);
               
                $equi->setEm($this->getEntityManager());
                $li->setEm($this->getEntityManager());
               
               
                $equi->getLicencas()->add($li);
                
                $li->getEquipamento()->add($equi);
                $equi->store();
                $li->store();
                $this->getEntityManager()->flush();
            }
            $this->redirect()->toRoute('ti/equipamentos');
        }
        return new ViewModel(array('carac' => $carac));
    }

}