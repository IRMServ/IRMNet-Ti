<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * Equipamento
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="equipamento")
 * @ORM\Entity
 */
class Equipamento {

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idequipamento;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Nome (número) *: "})
     * @ORM\Column(name="nome", type="string", length=245, nullable=true)
     */
    public $nome;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\ManyToMany(targetEntity="TI\Entity\Licencas", mappedBy="equipamento")
     */
    public $licencas;

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
     * @var \TI\Entity\Modeloequipamento
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Modelo do equipamento *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Modeloequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ModeloEquipamento", referencedColumnName="idModeloEquipamento")
     * })
     */
    public $modeloequipamento;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;
    
    private $em;

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }

    /**
     * Constructor
     */
    public function __construct(EntityManager $em) {
        $this->licencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setEm($em);
    }

    public function getAll() {
        return $this->getEm()->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if (!$this->getIdequipamento()) {
            $this->getEm()->persist($this);
            $this->getEm()->flush();
        } else {
            $this->getEm()->merge($this);
            $this->getEm()->flush();
        }
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getById($id) {
        return $this->em->getRepository(get_class($this))->find($id);
    }

    public function getIdequipamento() {
        return $this->idequipamento;
    }

    public function setIdequipamento($idequipamento) {
        $this->idequipamento = $idequipamento;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($name) {
        $this->nome = $name;
    }

    public function getLicencas() {
        return $this->licencas;
    }

    public function setLicencas(\Doctrine\Common\Collections\Collection $licencas) {
        $this->licencas = $licencas;
    }

    public function populate(array $data) {
        $tip = new Modeloequipamento($this->getEm());
        $this->setNome($data['nome']);
        $this->setModeloequipamento($tip->getById($data['modeloequipamento']));
        $this->setObservacao($data['observacao']);
    }

    public function getModeloequipamento() {
        return $this->modeloequipamento;
    }

    public function setModeloequipamento(\TI\Entity\Modeloequipamento $modeloequipamento) {
        $this->modeloequipamento = $modeloequipamento;
    }

    public function getSubmit() {
        return $this->submit;
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }

}
