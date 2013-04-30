<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * Caracteristicas
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="caracteristicas")
 * @ORM\Entity
 */
class Caracteristicas {

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idCaracteristicas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idcaracteristicas;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})
     * @Annotation\Options({"label":"Caracteristica *: "})
     * @ORM\Column(name="caracteristica", type="string", length=245, nullable=true)
     */
    public $caracteristica;

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

    public function getIdcaracteristicas() {
        return $this->idcaracteristicas;
    }

    public function setIdcaracteristicas($idcaracteristicas) {
        $this->idcaracteristicas = $idcaracteristicas;
    }

    public function getCaracteristica() {
        return $this->caracteristica;
    }

    public function setCaracteristica($caracteristica) {
        $this->caracteristica = $caracteristica;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function populate(array $data) {
        $this->setCaracteristica($data['caracteristica']);
        $this->setIdcaracteristicas($data['idcaracteristicas']);
        $this->setObservacao($data['observacao']);
    }

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if (!$this->getIdcaracteristicas()) {
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
