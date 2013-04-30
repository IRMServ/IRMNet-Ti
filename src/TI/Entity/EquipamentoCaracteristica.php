<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * EquipamentoCaracteristica
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="equipamento_caracteristica")
 * @ORM\Entity
 */
class EquipamentoCaracteristica {

    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipamento_Caracteristica", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipamentoCaracteristica;

    /**
     * @var string
     *
     * @ORM\Column(name="detalhe", type="string", length=245, nullable=true)
     */
    private $detalhe;

    /**
     * @var \TI\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Equipamento_fk", referencedColumnName="idEquipamento")
     * })
     */
    private $equipamentoFk;

    /**
     * @var \TI\Entity\Caracteristicas
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Caracteristicas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Caracteristicas_fk", referencedColumnName="idCaracteristicas")
     * })
     */
    private $caracteristicasFk;

    public function getIdequipamentoCaracteristica() {
        return $this->idequipamentoCaracteristica;
    }

    public function setIdequipamentoCaracteristica($idequipamentoCaracteristica) {
        $this->idequipamentoCaracteristica = $idequipamentoCaracteristica;
    }

    public function getDetalhe() {
        return $this->detalhe;
    }

    public function setDetalhe($detalhe) {
        $this->detalhe = $detalhe;
    }

    public function getEquipamentoFk() {
        return $this->equipamentoFk;
    }

    public function setEquipamentoFk(\TI\Entity\Equipamento $equipamentoFk) {
        $this->equipamentoFk = $equipamentoFk;
    }

    public function getCaracteristicasFk() {
        return $this->caracteristicasFk;
    }

    public function setCaracteristicasFk(\TI\Entity\Caracteristicas $caracteristicasFk) {
        $this->caracteristicasFk = $caracteristicasFk;
    }

    public function __construct(EntityManager $em) {
        $this->licencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->em = $em;
    }

    public function getAll() {
        return $this->em->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if (!$this->getIdequipamentoCaracteristica()) {
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
