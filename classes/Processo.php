<?php
/**
 * Class Processo
 */

 class Processo {
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var Pessoa
     */
    private $pessoa;

    /**
     * @var Unidade
     */
    private $unidade;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var DateTime
     */
    private  $createdDate;

    /**
     * @var DateTime
     */
    private $modifiedDate;

    /**
     * @var integer
     */
    private $idVolk;

    /**
     * Object constructor
     * @return Processo
     */
    public function __construct() {
        $this->createdDate = new DateTime();
        $this->modifiedDate = new DateTime();
    }

    /**
     * Get the value of id
     *
     * @return  integer
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  integer  $id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of pessoa
     *
     * @return  Pessoa
     */ 
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * Set the value of pessoa
     *
     * @param  Pessoa  $pessoa
     *
     * @return  self
     */ 
    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    /**
     * Get the value of unidade
     *
     * @return  Unidade
     */ 
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Set the value of unidade
     *
     * @param  Unidade  $unidade
     *
     * @return  self
     */ 
    public function setUnidade(Unidade $unidade)
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  integer
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  integer  $status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of createdDate
     *
     * @return  DateTime
     */ 
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set the value of createdDate
     *
     * @param  DateTime  $createdDate
     *
     * @return  self
     */ 
    public function setCreatedDate(DateTime $createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get the value of modifiedDate
     *
     * @return  DateTime
     */ 
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set the value of modifiedDate
     *
     * @param  DateTime  $modifiedDate
     *
     * @return  self
     */ 
    public function setModifiedDate(DateTime $modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get the value of idVolk
     *
     * @return  integer
     */ 
    public function getIdVolk()
    {
        return $this->idVolk;
    }

    /**
     * Set the value of idVolk
     *
     * @param  integer  $idVolk
     *
     * @return  self
     */ 
    public function setIdVolk($idVolk)
    {
        $this->idVolk = $idVolk;

        return $this;
    }
 }