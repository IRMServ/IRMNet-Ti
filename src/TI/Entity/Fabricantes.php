<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;
use \DateTime;
use \DateInterval;

/**
 * Fabricantes
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="fabricantes")
 * @ORM\Entity
 */
class Fabricantes {

    private $em;

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idFabricantes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idfabricantes;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Fabricante *: "})
     * @ORM\Column(name="fabricante", type="string", length=245, nullable=true)
     */
    public $fabricante;
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
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;

    public function getIdfabricantes() {
        return $this->idfabricantes;
    }

    public function setIdfabricantes($idfabricantes) {
        $this->idfabricantes = $idfabricantes;
    }

    public function getFabricante() {
        return $this->fabricante;
    }

    public function setFabricante($fabricante) {
        $this->fabricante = $fabricante;
    }

    public function populate(array $data) {
        $this->setFabricante($data['fabricante']);
        $this->setIdfabricantes($data['idfabricantes']);
        $this->setObservacao($data['observacao']);
    }

    public function __construct(EntityManager $em) {
        $this->setEm($em);
    }

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }
    
    public function store()
    {
        if(!$this->getIdfabricantes())
        {
            $this->em->persist($this);
            $this->em->flush();
        }else{
            $this->em->merge($this);
            $this->em->flush();
        }
    }
    
    public function getById($id)
    {
         return $this->em->getRepository(get_class($this))->find($id);
    }
    
    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }

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



}
