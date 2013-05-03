<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * Modeloequipamento
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="modeloequipamento")
 * @ORM\Entity
 */
class Modeloequipamento
{
    
    private $entityManager = null;
    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idModeloEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idmodeloequipamento;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Nome *: "})
     * @ORM\Column(name="modelo", type="string", length=45, nullable=false)
     */
    public $modelo;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\AllowEmpty(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Observação *: "})
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    public $observacao;

    /**
     * @var \TI\Entity\Tipoequipamento
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Tipo de equipamento *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Tipoequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TipoEquipamento", referencedColumnName="idTipoEquipamento")
     * })
     */
    public $tipoequipamento;

    /**
     * @var \TI\Entity\Fabricantes
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Fabricante *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Fabricantes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Fabricantes", referencedColumnName="idFabricantes")
     * })
     */
    public $fabricantes;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;

    public function getEntityManager() {
        return $this->entityManager;
    }
    
    public function getSubmit() {
        return $this->submit;
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }

    
    public function setEntityManager(EntityManager $entityManager) {
        
        $this->entityManager = $entityManager;
    }

    public function getIdmodeloequipamento() {
        return $this->idmodeloequipamento;
    }

    public function setIdmodeloequipamento($idmodeloequipamento) {
        $this->idmodeloequipamento = $idmodeloequipamento;
    }
    
    public function getFabricantes() {
        return $this->fabricantes;
    }

    public function setFabricantes(\TI\Entity\Fabricantes $fabricantes) {
        $this->fabricantes = $fabricantes;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getTipoequipamento() {
        return $this->tipoequipamento;
    }

    public function setTipoequipamento(\TI\Entity\Tipoequipamento $tipoequipamento) {
        $this->tipoequipamento = $tipoequipamento;
    }

    function __construct( EntityManager $entityManager) {
        $this->setEntityManager($entityManager);
    }
    
    public function store() {
        if (!$this->getIdmodeloequipamento()) {
            $this->getEntityManager()->persist($this);
            $this->getEntityManager()->flush();
        } else {
            $this->getEntityManager()->merge($this);
            $this->getEntityManager()->flush();
        }
    }
    
    public function populate(array $data)
    {
         $fab = new Fabricantes($this->getEntityManager());
        $this->setFabricantes($fab->getById($data['fabricantes']));
        $tipo = new Tipoequipamento($this->getEntityManager());
        $this->setIdmodeloequipamento($data['idmodeloequipamento']);
        $this->setModelo($data['modelo']);
        $this->setObservacao($data['observacao']);
        $this->setTipoequipamento($tipo->getById($data['tipoequipamento']));
    }
    
    public function getAll() {
        return $this->getEntityManager()->getRepository(get_class($this))->findAll();
      
    }
    
    public function getById($id) {
        return $this->getEntityManager()->getRepository(get_class($this))->find($id);
    }


}
