<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;
use \DateTime;
use \DateInterval;
use Helpdesk\Entity\Setores;
/**
 * Alocacaoequipamento
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Table(name="alocacaoequipamento")
 * @ORM\Entity
 */
class Alocacaoequipamento {

    private $em = null;

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idAlocacaoEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idalocacaoequipamento;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Select")
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Options({"label":"Colaborador *: "})
     * @ORM\Column(name="colaborador", type="string", length=245, nullable=true)
     */
    public $colaborador;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"Setor *: "})
     * @ORM\Column(name="setor", type="string", length=245, nullable=true)
     */
    public $setor;

    /**
     * @var \DateTime
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Text")
     *  @Annotation\Options({"label":"Data de início *: "})
     * @ORM\Column(name="datainicio", type="date", nullable=true)
     */
    public $datainicio;

    /**
     * @var \DateTime
     *  @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Text")
     *  @Annotation\Options({"label":"Data de devolução *: "})
     * @ORM\Column(name="datafim", type="date", nullable=true)
     */
    public $datafim;

    /**
     * @var string
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Text")
     *  @Annotation\Options({"label":"Realocação *: "})
     * @ORM\Column(name="realocacao", type="string", length=245, nullable=true)
     */
    public $realocacao;

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
     * @var \TI\Entity\Equipamento
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"Equipamento *: "})
     * @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Equipamento_fk", referencedColumnName="idEquipamento")
     * })
     */
    public $equipamentoFk;
    /**
     * @var \TI\Entity\Equipamento
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"Local *: ","value_options" : {"":"Escolha um local","OnShore":"OnShore","OffShore":"OffShore"}})
     * @ORM\Column(name="local", type="text", nullable=true)
     */
    public $local;
     /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enviar","class":"btn btn-success"})
     */
    public $submit;

    public function getIdalocacaoequipamento() {
        return $this->idalocacaoequipamento;
    }

    public function setIdalocacaoequipamento($idalocacaoequipamento) {
        $this->idalocacaoequipamento = $idalocacaoequipamento;
    }

    public function getColaborador() {
        return $this->colaborador;
    }

    public function setColaborador($colaborador) {
        $this->colaborador = $colaborador;
    }

    public function getSetor() {
        return $this->setor;
    }

    public function setSetor($setor) {
        $this->setor = $setor;
    }

    public function getDatainicio() {
        return $this->datainicio instanceof DateTime ? $this->datainicio->format('d/m/Y'):'';
    }

    public function setDatainicio(\DateTime $datainicio) {
        $this->datainicio = $datainicio;
    }

    public function getDatafim() {
        return $this->datafim instanceof DateTime ? $this->datafim->format('d/m/Y'):'';
    }

    public function setDatafim(\DateTime $datafim) {
        $this->datafim = $datafim;
    }

    public function getRealocacao() {
        return $this->realocacao;
    }

    public function setRealocacao($realocacao) {
        $this->realocacao = $realocacao;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function getEquipamentoFk() {
        return $this->equipamentoFk;
    }

    public function setEquipamentoFk(\TI\Entity\Equipamento $equipamentoFk) {
        $this->equipamentoFk = $equipamentoFk;
    }

    public function populate(array $data) {
        $e = new Equipamento($this->getEm());
        $equi = $e->getById($data['equipamentoFk']);        
        $this->setColaborador($data['colaborador']);
        $this->setEquipamentoFk($equi);
        $this->setIdalocacaoequipamento($data['idalocacaoequipamento']);
        $this->setObservacao($data['observacao']);
        $s = new Setores();
        $s->setEm($this->getEm());
        $setor = $s->getById($data['setor']);
        $this->setSetor($setor->getSetor());
        $this->setLocal($data['local']);
    }
    
    public function store() {
        if (!$this->getIdalocacaoequipamento()) {
            $this->em->persist($this);
            $this->em->flush();
        } else {
            $this->em->merge($this);
            $this->em->flush();
        }
    }

    public function __construct(EntityManager $em) {
        $this->setEm($em);
    }

    public function getAll() {
        return $this->getEm()->getRepository(get_class($this))->findBy(array(),array('idalocacaoequipamento'=>'desc'));
    }

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }
    public function getLocal() {
        return $this->local;
    }

    public function setLocal($local) {
        $this->local = $local;
    }

    public function getSubmit() {
        return $this->submit;
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }



}
