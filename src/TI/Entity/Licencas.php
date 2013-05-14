<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;
use Zend\Debug\Debug;
/**
 * Licencas
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="licencas")
 * @ORM\Entity
 */
class Licencas
{
    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idLicencas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idlicencas;

    /**
     * @var string
     *
     *  @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Licenca *: "})
     * @ORM\Column(name="licenca", type="string", length=245, nullable=true)
     */
    public $licenca;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\ManyToMany(targetEntity="TI\Entity\Equipamento", inversedBy="licencas")
     * @ORM\JoinTable(name="licencas_equipamento",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Licencas_id", referencedColumnName="idLicencas")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Equipamento_id", referencedColumnName="idEquipamento")
     *   }
     * )
     */
    public $equipamento;

    /**
     * @var \TI\Entity\Softwares
     *@Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Software *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Softwares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Softwares_fk", referencedColumnName="idSoftwares")
     * })
     */
    public $softwaresFk;
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
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;
    
    private $em;

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getSubmit() {
        return $this->submit;
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }

        /**
     * Constructor
     */
    public function __construct(EntityManager $em)
    {
        $this->setEm($em);
        $this->equipamento = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function getIdlicencas() {
        return $this->idlicencas;
    }

    public function setIdlicencas($idlicencas) {
        $this->idlicencas = $idlicencas;
    }

    public function getLicenca() {
        return $this->licenca;
    }

    public function setLicenca($licenca) {
        $this->licenca = $licenca;
    }

    public function getEquipamento() {
        return $this->equipamento;
    }

    public function setEquipamento(\Doctrine\Common\Collections\Collection $equipamento) {
        $this->equipamento = $equipamento;
    }

    public function getSoftwaresFk() {
        return $this->softwaresFk;
    }

    public function setSoftwaresFk(\TI\Entity\Softwares $softwaresFk) {
        $this->softwaresFk = $softwaresFk;
    }
    
    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }
    
    public function populate(array $data)
    {
        $s = new Softwares($this->em);
        $this->setIdlicencas($data['idlicencas']);
        $this->setLicenca($data['licenca']);
        $this->setSoftwaresFk($s->getById($data['softwaresFk']));
        $this->setObservacao($data['observacao']);
    }

    public function store() {
        if (!$this->getIdlicencas()) {
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

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }


}
