<?php
/**
 * Class Pessoa
 */

 class Pessoa {
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    

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
    public function setNome(string $name)
    {
        $this->name = $name;

        return $this;
    }
 }