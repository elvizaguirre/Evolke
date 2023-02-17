<?php

require_once('vendor/autoload.php');
require_once('classes/Unidade.php');
use PHPUnit\Framework\TestCase;

final class UnidadeTest extends TestCase
{
    public function testConstructor()
    {
        $unidade = new Unidade();
        $this->assertEquals('Unidade', get_class($unidade), 'Assert if the class is Unidade');
    }

    public function testId()
    {
        $unidade = new Unidade();
        $this->assertEquals($unidade->getId(), null, "The initial id is not set");
        $unidade->setId(5);
        $this->assertEquals($unidade->getId(), 5, "The id is correctly set");
    }
    public function testName()
    {
        $unidade = new Unidade();
        $this->assertEquals($unidade->getName(), null, "The initial name is not set");
        $unidade->setNome('Name 1');
        $this->assertEquals($unidade->getName(), 'Name 1', "The name is correctly set");
    }
}