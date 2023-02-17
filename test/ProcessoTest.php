<?php

require_once('vendor/autoload.php');
require_once('classes/Processo.php');
use PHPUnit\Framework\TestCase;

final class ProcessoTest extends TestCase
{
    public function testConstructor()
    {
        $processo = new Processo();
        $this->assertEquals('Processo', get_class($processo), 'Assert if the class is Processo');
    }

    public function testId()
    {
        $processo = new Processo();
        $processo->setId(1);

        $this->assertEquals(1, $processo->getId(), "The initial id is not set");
        $processo->setId(5);
        $this->assertEquals(5, $processo->getId(), "The id is correctly set");
    }
    public function testName()
    {
        $processo = new Processo();
        $processo->setName('1');
        $this->assertEquals('1', $processo->getName(), "The initial name is not set");
        $processo->setName('Name 1');
        $this->assertEquals('Name 1', $processo->getName(), "The name is correctly set");
    }

    public function testDates()
    {
        $processo = new Processo();
        $this->assertEquals('DateTime', get_class($processo->getCreatedDate()), 'The createdDate property type is correct');
        $this->assertEquals('DateTime', get_class($processo->getModifiedDate()), 'The modifiedDate property type is correct');
    }
}