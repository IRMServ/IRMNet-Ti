<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use \DateTime;
use \DateInterval;
/**
 * Alocacaoequipamento
 *
 * @ORM\Table(name="alocacaoequipamento")
 * @ORM\Entity
 */
class Alocacaoequipamento
{
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
     *
     * @ORM\Column(name="datainicio", type="date", nullable=true)
     */
    public $datainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datafim", type="date", nullable=true)
     */
    public $datafim;

    /**
     * @var string
     *
     * @ORM\Column(name="realocacao", type="string", length=245, nullable=true)
     */
    public $realocacao;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    public $observacao;

    /**
     * @var \TI\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Equipamento_fk", referencedColumnName="idEquipamento")
     * })
     */
    public $equipamentoFk;


}
