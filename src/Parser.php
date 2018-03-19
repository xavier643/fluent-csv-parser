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
        $this->path = fopen($path, 'r'); //fill path

        if(!in_array($delimiter, [',', '|', '\t']))  //verify delimiter
            throw new Exception("A delimiter of {$delimiter} is not supported.");    
        $this->delimiter = $delimiter; //fill delimiter

        
        if(empty($headers)) 
        {
            //following line currently gets whole csv? Not just first line?
            $data = fgetcsv($this->path, 0, $this->delimiter);
            $this->headers = $data;
        } else {
            $this->headers = $headers;
        }
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
