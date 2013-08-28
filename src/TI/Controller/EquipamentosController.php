<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
use TI\Entity\Equipamento,
    TI\Entity\Caracteristicas,
    TI\Entity\EquipamentoCaracteristica,
    TI\Entity\Licencas,
    TI\Entity\ImagemEquipamento;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\JsonModel;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Filter\File\Rename;
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
        $test = $form->get('modeloequipamento')->setEmptyOption('Escolha um Modelo de Equipamento')->setValueOptions($this->getServiceLocator()->get('ModeloEquipPair'));

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
                return $this->redirect()->toRoute('ti/equipamentos/upload-equipamento', array('id' => $fab->getIdequipamento()));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function storestorecaracteristicaAction() {


        $id = $this->params()->fromRoute('id');
        $e = new Equipamento($this->getEntityManager());
        $equi = $e->getById($id);
        $carac = $this->getServiceLocator()->get('CaracteristicasPair');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            
            foreach ($data['my-select'] as $d) {
                $caract = new Caracteristicas($this->getEntityManager());
                $c = $caract->getById($d);
                $fab = new EquipamentoCaracteristica($this->getEntityManager());
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

    public function descricaologicaAction() {
        $id = $this->params()->fromRoute('id');
        $e = new Equipamento($this->getEntityManager());
        $equi = $e->getById($id);
        return new ViewModel(array('licencas' => $equi->getLicencas(), 'equip' => $equi));
    }

    public function descricaofisicaAction() {
        $id = $this->params()->fromRoute('id');
        $ec = new EquipamentoCaracteristica($this->getEntityManager());

        $equipcar = $ec->getAll();
        $aCara = array();
        foreach ($equipcar as $s) {
            if ($s->getEquipamentoFk()->getIdequipamento() == $id) {
                $aCara[] = $s;
            }
        }
        return new ViewModel(array('peca' => $aCara));
    }

    public function equipamentoAction() {
        $id = $this->params()->fromRoute('id');
        $e = new Equipamento($this->getEntityManager());
        $equi = $e->getById($id);
        $ec = new EquipamentoCaracteristica($this->getEntityManager());
        $ie = new ImagemEquipamento($this->getEntityManager());
        $iequi = $ie->getByEquipamento($id);
        $equipcar = $ec->getByEquipamento($id);
       
        return new ViewModel(array('licencas' => $equi->getLicencas(), 'equip' => $equi, 'peca' => $equipcar,'iequi'=>$iequi));
    }

    public function uploadAction() {
        $id = $this->params()->fromRoute('id');
        return new ViewModel(array('id'=>$id));
    }

    public function uploadjsAction() {
        $ie = new ImagemEquipamento($this->getEntityManager());
        $e = new Equipamento($this->getEntityManager());
        $ie->setAcao('Cadastro');
        $id = $this->params()->fromRoute('id');
        
        $File = $this->params()->fromFiles('pic');
        $ie->setEquipamento($e->getById($id));
        if ($File['size'] > 0) {
            $size = new Size(array('max' => 5 * 1024 * 1024));
            $adapter = new \Zend\File\Transfer\Adapter\Http();

            $dir = \dirname(__DIR__);
            $ex = \explode('intranet', $dir);
            $exten = \explode('.', $File['name']);
            $destino = $ex[0] . 'intranet\public\ti-files\\' . md5(uniqid()) . '.' . $exten[1];

            $rename = new Rename($destino);

            $extension = new Extension(array('gif', 'jpg', 'pdf', 'bmp', 'png'));
            $adapter->addFilter($rename);
            $adapter->addValidator($extension)
                    ->addValidator($size);

            if (!$adapter->isValid()) {
                $dataError = $adapter->getMessages();
                $error = array();
                foreach ($dataError as $key => $row) {
                    $error[] = $row;
                }
                return new JsonModel(array('status' => 'arquivo nao valido'));
            } else {

                $dir = \dirname(__DIR__);
                $ex = explode('intranet', $dir);
                $destino = $ex[0] . 'intranet\public\ti-files';
                $adapter->setDestination($destino);
                if ($adapter->receive()) {
                    $ie->setArquivo(str_replace('\\', '/', end(explode('public', $adapter->getFileName()))));
                    $ie->store();
                    return new JsonModel(array('status' => 'arquivo enviado com sucesso'));
                }
            }
        }
        $v = new ViewModel();
        $v->setTerminal(true);
        return $v;
    }

    function exit_status($str) {
        echo json_encode(array('status' => $str));
        exit;
    }

    function get_extension($file_name) {
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }
    
    public function updateAction()
    {
        $ec = new EquipamentoCaracteristica($this->getEntityManager());
      
        if($this->getRequest()->isPost())
        {
            
            $data = $this->getRequest()->getPost();
            $ecar = $ec->getById($data['id']);
            $ecar->setEm($this->getEntityManager());
            $ecar->setDetalhe($data['value']);
            $ecar->store();
            return new JsonModel(array('result'=>'ok'));
        }
        return new JsonModel(array());
    }

}