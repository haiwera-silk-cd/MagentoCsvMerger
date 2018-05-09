<?php
    /**
    * @Name : csvmerge
    * @Function : 
    * @Author : Haiwera
    * @Created : 2018-05-08
    */

    include __DIR__ . '/functions.php';

    if(!isset($argv[3])){
        exit(
<<<STR
    useage: php csvmerge.php exportcsvfile yourcsvfile resultcsvfile
STR
        );
    }

    $infile1 = $argv[1];
    $infile2 = $argv[2];
    $resultfile = $argv[3];


    if(!is_file($infile1) || !is_file($infile2)){
        exit('file not exists');
    }
    function array_top($array){
        foreach($array as $v){
            return $v;
        }
        return null;
    }



    $csv1 = new Csv($infile1);
    $csv2 = new Csv($infile2);
    @unlink($resultfile);
    $csv3 = new Csv($resultfile);
    $ref = $csv1->getLines();
    foreach($ref as $k => $line){
        foreach($csv2->getLines() as $v2_line){
            if($line->sku == $v2_line->sku){
                $arr = $ref[$k]->merge($v2_line,"attribute_merge");
                $csv3->addLine($arr);
            }
        }
    }
    $csv3->save();


