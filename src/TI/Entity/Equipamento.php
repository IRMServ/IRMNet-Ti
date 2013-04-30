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
     * @ORM\Column(name="name", type="string", length=245, nullable=true)
     */
    public $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\ManyToMany(targetEntity="TI\Entity\Licencas", mappedBy="equipamento")
     */
    public $licencas;

    /**
     * @var \TI\Entity\Tipoequipamento
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Tipo de Equipamento *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Tipoequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TipoEquipamento_fk", referencedColumnName="idTipoEquipamento")
     * })
     */
    public $tipoequipamentoFk;
    
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
        $this->em = $em;
    }
    
    

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if (!$this->getIdequipamento()) {
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
    
    public function getIdequipamento() {
        return $this->idequipamento;
    }

    public function setIdequipamento($idequipamento) {
        $this->idequipamento = $idequipamento;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLicencas() {
        return $this->licencas;
    }

    public function setLicencas(\Doctrine\Common\Collections\Collection $licencas) {
        $this->licencas = $licencas;
    }

    public function getTipoequipamentoFk() {
        return $this->tipoequipamentoFk;
    }

    public function setTipoequipamentoFk(\TI\Entity\Tipoequipamento $tipoequipamentoFk) {
        $this->tipoequipamentoFk = $tipoequipamentoFk;
    }

public function populate(array $data)
{
    $tip = new Tipoequipamento($this->em);
    $this->setName($data['name']);
    $this->setTipoequipamentoFk($tip->getById($data['tipoequipamentoFk']));
}

}
