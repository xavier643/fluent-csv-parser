<?php

namespace CSVParser;

class Parser {

    var $path;
    var $header_array = array();
    var $delimiter;

    function __construct ($path, $header_array = array(), $delimiter = ",") {

        if(file_exists($path)){ //verify path
            $this -> $path = $path; //fill path

            if($delimiter == "," || $delimiter == "|" || $delimiter == "\t") { //verify delimiter
                $this -> $delimiter = $delimiter; //fill delimiter

                if(count($header_array) > 0) { //make sure header array is not empty
                    //idea on foreach to fill array came from: stackoverflow.com/questions/3045619/how-to-store-values-from-foreach-loop-into-an-array
                    foreach($header_array as $header) {
                        $this -> $header_array[] = $header;
                    }
                } else {
                    echo "The header column is empty.";
                }
            } else {
                echo "The delimter of $delimiter is not valid.";
            }
        } else {
            echo "The path $path does not exist.";
        }       
    }
}