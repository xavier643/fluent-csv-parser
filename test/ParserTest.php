<?php

namespace CSVParser\Tests;

use CSVParser\Parser;

final class ParserTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $file is for a test file to verify object constructed
     */
    protected $file;

    public function setUp()
    {
        /*
         * create a temporary file and place it into $file
         */
        $this->file = tempnam(sys_get_temp_dir(), 'csv_parser_test'); 
    }

    public function tearDown()
    {
        /*
         * removes the temporary file
         */
        unlink($this->file);
    }

    /**
     * @test
     */
    public function testConstruction()
    {
        /*
         * $subject is the object created from parser.php and filled with the temp file
         */
        $subject = new Parser($this->file);

        /*
         * verfies the object and test file are created
         */
        $this->assertInstanceOf('CSVParser\Parser', $subject);
    }

    /**
     * @test
     */
    public function testConstructionWithHeader()
    {
        $subject = new Parser($this->file, ',', ['name', 'social', 123]);

        $this->assertInstanceOf('CSVParser\Parser', $subject);
        $this->assertEquals(['name', 'social', 123], $subject->headers());
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage file_does_not_exist is not a valid file.
     */
    public function testConstructionNoFile() {
        $subject = new Parser('file_does_not_exist');
    }

    /**
     * @test
     */
    public function testConstructorWithNoHeader()
    {
        /**
         * fill @file with default information to test when no header is sent in
         */
        $file_open = fopen($this->file, 'r+');
        fwrite($file_open, "name,");
        fwrite($file_open, "social,");
        fwrite($file_open, "123");
        fclose($file_open);
        $test_array = array('name', 'social', 123);

        $subject = new Parser($this->file, ',');
        $this->assertEquals($test_array, $subject->headers());
    }
}
