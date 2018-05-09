<?php
/**
* @Name : CsvLine
* @Author : Haiwera
* @Created : 2018-05-09
*/

class CsvLine{
    private $attributes = [];
    public function __construct($headers,$lineStr){

        if(is_string($lineStr)){
            $symbols = ["\""];
            $i = 0;$headerPos = 0;
            $headerCount = count($headers);
            $stack = [];
            $len = strlen($lineStr);
            $value = "";
            for($i = 0;$i < $len && $headerPos < $headerCount; $i ++){
                if(!in_array($lineStr{$i},$symbols) && (($lineStr{$i} == "," && !empty($stack)) || $lineStr{$i} != ",")){
                    $value .= $lineStr{$i};
                }
                else if(in_array($lineStr{$i},$symbols) && (empty($stack) || array_top($stack) != $lineStr{$i})){
                    $value .= $lineStr{$i};
                    array_push($stack,$lineStr{$i});
                }
                else if(in_array($lineStr{$i},$symbols) && array_top($stack) == $lineStr{$i}){
                    $value .= $lineStr{$i};
                    array_pop($stack);
                }
                else{
                    $this->attributes[$headers[$headerPos]] = $value;
                    $value = "";
                    $headerPos ++;
                }
            }
            if($headerPos < $headerCount){
                $this->attributes[$headers[$headerPos]] = $value;
            }
        }else{
            $this->attributes = $lineStr;
        }
    }
    public function getAttribute($search){
        return isset($this->attributes[$search]) ? $this->attributes[$search] : null;
    }
    public function getAttributes(){
        return $this->attributes;
    }
    public function __get($name){
        foreach($this->attributes as $k => $v){
            if($name == $k){
                return $v;
            }
            $tk = implode('',ucfirst($k));
            if($name == $tk){
                return $value;
            }
        }
        throw new \Exception("Get undefined property $name");
    }

    public function merge($other,$merge_func){

        $attr = call_user_func($merge_func,$this->attributes,$other->getAttributes());
        return new CsvLine(array_keys($attr),$attr);
    }
    public function __toString(){
        return implode(",",$this->attributes);
    }
}
