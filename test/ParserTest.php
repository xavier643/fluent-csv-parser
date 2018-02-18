<?php

namespace CSVParser\Tests;

use CSVParser\Parser;

final class ParserTests extends \PHPUnit_Framework_TestCase
{
    protected $file;

    public function setUp()
    {
        $this->file = tmpfile();
    }

    public function tearDown()
    {
        fclose($this->file);
    }

    /*
     * @test
     */
    public function testConstruction()
    {
        $subject = new Parser($this->file);

        $this->assertInstanceOf('CSVParser\Parser', $subject);
    }

    /*
     * @test
     */
    public function testConstructionWithHeader()
    {
    }
}