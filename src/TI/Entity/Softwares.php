<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * Softwares
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="softwares")
 * @ORM\Entity
 */
class Softwares {

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idSoftwares", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idsoftwares;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Software *: "})
     * @ORM\Column(name="Software", type="string", length=245, nullable=true)
     */
    public $software;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Descrição *: "})
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    public $observacao;
    
     /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;

    public function getIdsoftwares() {
        return $this->idsoftwares;
    }

    public function setIdsoftwares($idsoftwares) {
        $this->idsoftwares = $idsoftwares;
    }

    public function getSoftware() {
        return $this->software;
    }

    public function setSoftware($software) {
        $this->software = $software;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function populate(array $data) {
        $this->setIdsoftwares($data['idsoftwares']);
        $this->setSoftware($data['software']);
        $this->setObservacao($data['observacao']);
    }

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if ($this->getIdsoftwares() !== null) {
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
