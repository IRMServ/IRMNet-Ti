<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @ORM\Entity 
 * @ORM\Table(name="ImagemEquipamento")
 * */
class ImagemEquipamento {
    private $em = null;

    /**
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(name="idImagemEquipamento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $idImagemEquipamento;
    /**
     * @Annotation\AllowEmpty(true)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(type="text",name="acao") 

     */
    public $acao;

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\AllowEmpty(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"1"}})     
     ** @ORM\ManyToOne(targetEntity="TI\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento", referencedColumnName="idEquipamento")
     * })
     */
    public $equipamento;

       /**
     *
     * @Annotation\AllowEmpty(true)
     * @ORM\Column(type="text",nullable=true)
     */
    public $arquivo;
    
    public function getIdImagemEquipamento() {
        return $this->idImagemEquipamento;
    }

    public function setIdImagemEquipamento($idImagemEquipamento) {
        $this->idImagemEquipamento = $idImagemEquipamento;
    }

    public function getEquipamento() {
        return $this->equipamento;
    }

    public function setEquipamento(\TI\Entity\Equipamento $equipamento) {
        $this->equipamento = $equipamento;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }
    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }

    function __construct(EntityManager $em) {
        $this->setEm($em);
    }
    
    public function populate(array $data)
    {
        $e = new Equipamento($this->getEm());
        $this->setArquivo($data['arquivo']);
        $this->setEquipamento($e->getById($data['equipamento']));
        $this->setIdImagemEquipamento($data['idImagemEquipamento']);
        $this->setAcao($data['acao']);
    }
    
    public function store()
    {
        $this->getEm()->persist($this);
        $this->getEm()->flush();
    }

    public function getAcao() {
        return $this->acao;
    }

    public function setAcao($acao) {
        $this->acao = $acao;
    }
    
   public function getByEquipamento($id) {
        return $this->getEm()->getRepository(get_class($this))->findBy(array('equipamento'=>$id));
    }
}
