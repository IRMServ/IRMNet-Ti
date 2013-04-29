<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipamentoCaracteristica
 *
 * @ORM\Table(name="equipamento_caracteristica")
 * @ORM\Entity
 */
class EquipamentoCaracteristica
{
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


}
