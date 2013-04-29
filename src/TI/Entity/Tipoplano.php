<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipoplano
 *
 * @ORM\Table(name="tipoplano")
 * @ORM\Entity
 */
class Tipoplano
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoPlano", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtipoplano;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45, nullable=true)
     */
    private $tipo;

    /**
     * @var \TI\Entity\Secaoplano
     *
     * @ORM\ManyToOne(targetEntity="TI\Entity\Secaoplano")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CategoriaPlano_fk", referencedColumnName="idSecaoPlano")
     * })
     */
    private $categoriaplanoFk;


}
