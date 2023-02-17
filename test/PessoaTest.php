<?php

require_once('vendor/autoload.php');
require_once('classes/Pessoa.php');
use PHPUnit\Framework\TestCase;

final class PessoaTest extends TestCase
{
    public function testConstructor()
    {
        $pessoa = new Pessoa();
        $this->assertEquals('Pessoa', get_class($pessoa), 'Assert if the class is Pessoa');
    }

    public function testId()
    {
        $pessoa = new Pessoa();
        $this->assertEquals($pessoa->getId(), null, "The initial id is not set");
        $pessoa->setId(5);
        $this->assertEquals($pessoa->getId(), 5, "The id is correctly set");
    }
    public function testName()
    {
        $pessoa = new Pessoa();
        $this->assertEquals($pessoa->getName(), null, "The initial name is not set");
        $pessoa->setNome('Name 1');
        $this->assertEquals($pessoa->getName(), 'Name 1', "The name is correctly set");
    }
}