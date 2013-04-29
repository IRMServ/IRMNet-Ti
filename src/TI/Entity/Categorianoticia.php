<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorianoticia
 *
 * @ORM\Table(name="categorianoticia")
 * @ORM\Entity
 */
class Categorianoticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategoriaNoticia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorianoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=145, nullable=true)
     */
    private $categoria;


}
