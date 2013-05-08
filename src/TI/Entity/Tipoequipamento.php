<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * Tipoequipamento
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="tipoequipamento")
 * @ORM\Entity
 */
class Tipoequipamento {

    private $entityManager = null;

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idTipoEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idtipoequipamento;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Nome *: "})
     * @ORM\Column(name="nome", type="string", length=245, nullable=false)
     */
    public $nome;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Sigla *: "})
     * @ORM\Column(name="sigla", type="string", length=245, nullable=false)
     */
    public $sigla;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Observação *: "})
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    public $observacao;

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

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getIdtipoequipamento() {
        return $this->idtipoequipamento;
    }

    public function setIdtipoequipamento($idtipoequipamento) {
        $this->idtipoequipamento = $idtipoequipamento;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getFabricantes() {
        return $this->fabricantes;
    }

    public function setFabricantes(\TI\Entity\Fabricantes $fabricantes) {
        $this->fabricantes = $fabricantes;
    }

    public function populate(array $data) {
        $fab = new Fabricantes($this->getEntityManager());
        $this->setFabricantes($fab->getById($data['fabricantes']));
        $this->setIdtipoequipamento($data['idtipoequipamento']);
        $this->setNome($data['nome']);
        $this->setSigla($data['sigla']);
        $this->setObservacao($data['observacao']);
        
    }
    
    public function __construct(EntityManager $em) {
        $this->setEntityManager($em);
    }
    
    public function store() {
        if (!$this->getIdtipoequipamento()) {
            $this->getEntityManager()->persist($this);
            $this->getEntityManager()->flush();
        } else {
            $this->getEntityManager()->merge($this);
            $this->getEntityManager()->flush();
        }
    }

    public function getAll() {
        return $this->getEntityManager()->getRepository(get_class($this))->findAll();
    }
    public function getById($id) {
        return $this->getEntityManager()->getRepository(get_class($this))->find($id);
    }
    public function getByFabricante($id) {
        return $this->getEntityManager()->getRepository(get_class($this))->findBy(array('fabricantes'=>$id));
    }

}
