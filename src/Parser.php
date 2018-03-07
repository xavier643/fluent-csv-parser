<?php

namespace CSVParser;

class Parser {

    /**
     * @var path the file path to the csv file to be parsed.
     */
    private $path;

    /**
     * @var headers The column headers for the CSV file that give context to the column values.
     */
    private $headers;

    /**
     * @var delimiter the delimiter value that separates column values for this CSV file.
     */
    private $delimiter;

    function __construct ($path, $delimiter = ',', $headers = []) 
    {
        /*
         * Check that the path does exist or throws an exception
         * Checks that the delimiter is a , | or /t
         * Fills headers, if it's empty grabs first line from CSV instead
         */

        if(!file_exists($path)) 
            throw new \Exception("{$path} is not a valid file.");
        $this->path = $path; //fill path

        if(!in_array($delimiter, [',', '|', '\t']))  //verify delimiter
            throw new Exception("A delimiter of {$delimiter} is not supported.");    
        $this->delimiter = $delimiter; //fill delimiter

        $this->headers = $headers;
        if(empty($headers)) 
        {
            /**
             * @var path_open will open up path and is read only
             */
            $path_open = fopen($path, 'r');
            /**
             * @var data is an array of data from the csv file
             */
            $data = fgetcsv($path_open, 0, $this->delimiter);
            $this->headers = $data; //this line created a new error
            //not using str_getcsv() because it makes array of arrays from whole CSV


            //$this->headers = first row of CSV
            //line 31 will need to set path to an open resource in order to read this->path = fopen($path);
            //will make path = to the resource.  File pointer.  function of fgetcsv in order to read in the rows.
            //close the path when done
        }
    }

    public function headers()
    {
        return $this->headers;
    }
}
