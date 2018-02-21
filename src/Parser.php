<?php

namespace CSVParser;

class Parser {

    /*
     * @var $path the file path to the csv file to be parsed.
     * @var $headers The column headers for the CSV file that give context to the column values.
     * @var $delimiter the delimiter value that separates column values for this CSV file.
     */

    private $path;
    private $headers = [];
    private $delimiter;

    function __construct ($path, $headers = [], $delimiter = ',') {

        /*
         * Check that the path does exist or throws an exception
         * Checks that the delimiter is a , | or /t
         * Fills headers, if it's empty grabs first line from CSV instead
         */

        if(!file_exists($path)) throw new Exception("{$path} is not a valid file.");
        $this->path = $path; //fill path

        if($delimiter == ',' || $delimiter == '|' || $delimiter == '\t') { //verify delimiter
            $this->delimiter = $delimiter; //fill delimiter
        }

        $this->headers = $headers;
        if(empty($headers)) {
            /* 
             * Pull first row of data from the file to fill the headers since was empty
             */

            //$this->headers = first row of CSV
        }
    }
}
