<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use \DateTime;
use \DateInterval;
/**
 * Agendamanutencao
 *
 * @ORM\Table(name="agendamanutencao")
 * @ORM\Entity
 */
class Agendamanutencao {

    /**
     * @var integer
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idAgendaManutencao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idagendamanutencao;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"Data da manutenção: "})
     * @ORM\Column(name="dia", type="string", length=245, nullable=true)
     */
    public $dia;

    /**
     * @var integer
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Adiado? : ","value":"1"})
     * @ORM\Column(name="adiado", type="integer", nullable=true)
     */
    public $adiado;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Data da manutenção: "})
     * @ORM\Column(name="proxima", type="string", length=245, nullable=true)
     */
    public $proxima;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Item Plano *: "})
     * @ORM\ManyToMany(targetEntity="TI\Entity\Itemplano", inversedBy="agendamanutencao")
     * @ORM\JoinTable(name="agendamanutencao_itemplano",
     *   joinColumns={
     *     @ORM\JoinColumn(name="AgendaManutencao_id", referencedColumnName="idAgendaManutencao")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ItemPlano_id", referencedColumnName="idItemPlano")
     *   }
     * )
     */
    public $itemplano;

    /**
     * @var \TI\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Equipamento_fk", referencedColumnName="idEquipamento")
     * })
     */
    public $equipamentoFk;
    
    public $submit;

    /**
     * Constructor
     */
    public function __construct() {
        $this->itemplano = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdagendamanutencao() {
        return $this->idagendamanutencao;
    }

    public function setIdagendamanutencao($idagendamanutencao) {
        $this->idagendamanutencao = $idagendamanutencao;
    }

    public function getDia() {
        return $this->dia;
    }

    public function setDia($dia) {
        $this->dia = $dia;
    }

    public function getAdiado() {
        return $this->adiado;
    }

    public function setAdiado($adiado) {
        $this->adiado = $adiado;
    }

    public function getProxima() {
        return $this->proxima;
    }

    public function setProxima($proxima) {
        $this->proxima = $proxima;
    }

    public function getItemplano() {
        return $this->itemplano;
    }

    public function setItemplano(\Doctrine\Common\Collections\Collection $itemplano) {
        $this->itemplano = $itemplano;
    }

    public function getEquipamentoFk() {
        return $this->equipamentoFk;
    }

    public function setEquipamentoFk(\TI\Entity\Equipamento $equipamentoFk) {
        $this->equipamentoFk = $equipamentoFk;
    }

    public function populate(array $data) {
        $this->setAdiado($data['adiado']);
        $this->setDia($data['dia']);
        $this->setEquipamentoFk($data['equipamentoFk']);
        $this->setIdagendamanutencao($data['idagendamanutencao']);
        $this->setItemplano($data['itemplano']);
        $this->setProxima($data['proxima']);
    }
    
    public function getSubmit() {
        return $this->submit;
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }



}
