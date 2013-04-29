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
     * @ORM\Column(name="nome", type="string", length=245, nullable=true)
     */
    public $nome;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Sigla *: "})
     * @ORM\Column(name="sigla", type="string", length=245, nullable=true)
     */
    public $sigla;

    /**
     * @var \TI\Entity\Fabricantes
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Fabricante *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Fabricantes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Fabricantes_fk", referencedColumnName="idFabricantes")
     * })
     */
    public $fabricantesFk;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;

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

    public function getFabricantesFk() {
        return $this->fabricantesFk;
    }

    public function setFabricantesFk(\TI\Entity\Fabricantes $fabricantesFk) {
        $this->fabricantesFk = $fabricantesFk;
    }

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }
    
    public function populate(array $data)
    {      
        $fab = new Fabricantes($this->em);
        $this->setFabricantesFk($fab->getById($data['fabricantesFk']));
        $this->setIdtipoequipamento($data['idtipoequipamento']);
        $this->setNome($data['nome']);
        $this->setSigla($data['sigla']);
    }

    public function store() {
        if ($this->getIdtipoequipamento() !== null) {
            $this->em->persist($this);
            $this->em->flush();
        } else {
            $this->em->merge($this);
            $this->em->flush();
        }
    }

    public function getById($id) {
        return $this->em->getRepository(get_class($this))->find($id);
    }

}
