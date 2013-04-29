<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Itemplano
 *
 * @ORM\Table(name="itemplano")
 * @ORM\Entity
 */
class Itemplano
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idItemPlano", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iditemplano;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=45, nullable=true)
     */
    private $item;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TI\Entity\Agendamanutencao", mappedBy="itemplano")
     */
    private $agendamanutencao;

    /**
     * @var \TI\Entity\Tipoplano
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Tipoplano")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TipoPlano_fk", referencedColumnName="idTipoPlano")
     * })
     */
    private $tipoplanoFk;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agendamanutencao = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
