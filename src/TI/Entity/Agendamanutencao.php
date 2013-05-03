<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agendamanutencao
 *
 * @ORM\Table(name="agendamanutencao")
 * @ORM\Entity
 */
class Agendamanutencao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAgendaManutencao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idagendamanutencao;

    /**
     * @var string
     *
     * @ORM\Column(name="dia", type="string", length=45, nullable=true)
     */
    private $dia;

    /**
     * @var integer
     *
     * @ORM\Column(name="adiado", type="integer", nullable=true)
     */
    private $adiado;

    /**
     * @var string
     *
     * @ORM\Column(name="proxima", type="string", length=45, nullable=true)
     */
    private $proxima;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
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
    private $itemplano;

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
     * Constructor
     */
    public function __construct()
    {
        $this->itemplano = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
