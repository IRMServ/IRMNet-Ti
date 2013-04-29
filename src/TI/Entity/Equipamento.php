<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipamento
 *
 * @ORM\Table(name="equipamento")
 * @ORM\Entity
 */
class Equipamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipamento;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=245, nullable=true)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TI\Entity\Licencas", mappedBy="equipamento")
     */
    private $licencas;

    /**
     * @var \TI\Entity\Tipoequipamento
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Tipoequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TipoEquipamento_fk", referencedColumnName="idTipoEquipamento")
     * })
     */
    private $tipoequipamentoFk;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->licencas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
