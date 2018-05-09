<?php
/**
* @Name : Csv
* @Author : Haiwera
* @Created : 2018-05-09
*/

class Csv{
    private $lines = [];
    private $headers = [];
    private $file = null;
    public function __construct($file){
        $this->file = $file;
        if(!file_exists($file)){
            return ;
        }
        $lineArray = explode("\n",file_get_contents($file));
        $avalibLine = [];
        foreach($lineArray as $line){
            if(trim($line) !== ""){
                $avalibLine[] = $line;
            }
        }
        $tmpHeader = explode(',',current($avalibLine));
        array_shift($avalibLine);
        foreach($tmpHeader as $header){
            $this->headers[] = trim($header);
        }
        foreach($avalibLine as $line){
            $this->lines[] = new CsvLine($this->headers,$line);
        }
    }
    public function setHeaders($headers){
        $this->headers = $headers;
    }
    public function addLine($line){
        if(empty($this->headers)){
            $this->headers = array_keys($line->getAttributes());
        }
        $this->lines[] = $line;
    }
    public function getHeaders(){
        return $this->headers;
    }
    public function &getLines(){
        return $this->lines;
    }
    public function save(){
        $result = implode(",",$this->headers);
        foreach($this->getLines() as $v){
            $result .= "\n".$v;
        }
        file_put_contents($this->file,$result);
    }
}
