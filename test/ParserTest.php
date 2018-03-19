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
        // removes the temporary file
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
        $this->assertEquals(['name', 'social', 123], $subject->getHeaders());
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
     *
     * Verifies the constructor reads the first row of a CSV file when the header parameter is not specified.
     * NOTE: If a header array is not passed into the constructor it is assumed that the first row of the CSV
     *      file contains the column headers.
     */
    public function testConstructorWithNoHeader()
    {
        /**
         * fill @file with a 1 row of column headers and 2 rows of data.
         */
        $file_open = fopen($this->file, 'r+');
        fwrite($file_open, "name,social,id" . PHP_EOL);
        fwrite($file_open, "Derek,1337,123" . PHP_EOL);
        fwrite($file_open, "Arthur,1347,456" . PHP_EOL);
        fclose($file_open);
        
        $expected = ['name', 'social', 'id'];

        $subject = new Parser($this->file, ',');
        $this->assertEquals($expected, $subject->getHeaders());
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage A delimiter of . is not supported.
     */
    public function testPassingaPeriodAsDelimiter()
    {
        $subject = new Parser($this->file, '.');
    }

}
