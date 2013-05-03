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

    private $em = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipamento_Caracteristica", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idequipamentoCaracteristica;

    /**
     * @var string
     *
     * @ORM\Column(name="detalhe", type="string", length=245, nullable=true)
     */
    public $detalhe;

    /**
     * @var \TI\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Equipamento_fk", referencedColumnName="idEquipamento")
     * })
     */
    public $equipamentoFk;

    /**
     * @var \TI\Entity\Caracteristicas
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Caracteristicas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Caracteristicas_fk", referencedColumnName="idCaracteristicas")
     * })
     */
    public $caracteristicasFk;

    /*
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    public $observacao;

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

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }

    public function __construct(EntityManager $em) {
        $this->setEm($em);
    }

    public function getByEquipamento($id) {
    
       // e$this->getEm()->getRepository(get_class($this))->getClassName();//findBy(array('Equipamentos'=>$id));
        
        return $this->getEm()->getRepository(get_class($this))->findBy(array('Equipamentos_fk'=>$id));
    }

    public function getAll() {
        return $this->getEm()->getRepository(get_class($this))->findAll();
    }

    public function store() {
        if (!$this->getIdequipamentoCaracteristica()) {
            $this->getEm()->persist($this);
            $this->getEm()->flush();
        } else {
            $this->getEm()->merge($this);
            $this->getEm()->flush();
        }
    }

    public function getById($id) {
        return $this->getEm()->getRepository(get_class($this))->find($id);
    }

}
