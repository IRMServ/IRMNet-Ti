<?php

namespace TI\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
/**
 * Papercut
 *
 * @ORM\Table(name="papercut")
 * @ORM\Entity
 */
class Papercut
{
    
    /**
     * @var integer
     * @ORM\Column(name="idimpressao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idimpressao;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Time", type="string",length=45, nullable=false)       
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=45, nullable=true)
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="pages", type="integer", nullable=true)
     */
    private $pages;

    /**
     * @var integer
     *
     * @ORM\Column(name="copies", type="integer", nullable=true)
     */
    private $copies;

    /**
     * @var string
     *
     * @ORM\Column(name="printer", type="string", length=45, nullable=true)
     */
    private $printer;

    /**
     * @var string
     *
     * @ORM\Column(name="document_name", type="string", length=254, nullable=true)
     */
    private $documentName;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=45, nullable=true)
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="paper_size", type="string", length=45, nullable=true)
     */
    private $paperSize;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=45, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="string", length=45, nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="string", length=45, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="duplex", type="string", length=45, nullable=true)
     */
    private $duplex;

    /**
     * @var string
     *
     * @ORM\Column(name="grayscale", type="string", length=45, nullable=true)
     */
    private $grayscale;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=45, nullable=true)
     */
    private $size;
    
    private $entityManager;
    
   
    
    public function getIdimpressao() {
        return $this->idimpressao;
    }

    public function setIdimpressao($idimpressao) {
        $this->idimpressao = $idimpressao;
        return $this;
    }

        
    function __construct(EntityManager $entityManager) {
        $this->setEntityManager( $entityManager);
    }

        
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    
    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function getPages() {
        return $this->pages;
    }

    public function setPages($pages) {
        $this->pages = $pages;
        return $this;
    }

    public function getCopies() {
        return $this->copies;
    }

    public function setCopies($copies) {
        $this->copies = $copies;
        return $this;
    }

    public function getPrinter() {
        return $this->printer;
    }

    public function setPrinter($printer) {
        $this->printer = $printer;
        return $this;
    }

    public function getDocumentName() {
        return $this->documentName;
    }

    public function setDocumentName($documentName) {
        $this->documentName = $documentName;
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function setClient($client) {
        $this->client = $client;
        return $this;
    }

    public function getPaperSize() {
        return $this->paperSize;
    }

    public function setPaperSize($paperSize) {
        $this->paperSize = $paperSize;
        return $this;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    public function getDuplex() {
        return $this->duplex;
    }

    public function setDuplex($duplex) {
        $this->duplex = $duplex;
        return $this;
    }

    public function getGrayscale() {
        return $this->grayscale;
    }

    public function setGrayscale($grayscale) {
        $this->grayscale = $grayscale;
        return $this;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function store()
    {
        $this->getEntityManager()->persist($this);
        $this->getEntityManager()->flush();
    }

}
