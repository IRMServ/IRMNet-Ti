<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secaoplano
 *
 * @ORM\Table(name="secaoplano")
 * @ORM\Entity
 */
class Secaoplano
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSecaoPlano", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsecaoplano;

    /**
     * @var string
     *
     * @ORM\Column(name="secao", type="string", length=45, nullable=true)
     */
    private $secao;


}
