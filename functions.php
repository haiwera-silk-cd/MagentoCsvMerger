<?php
    function get_add_attr($str){
        $str = trim($str);
        $arr = explode(',',$str);
        $result = [];
        foreach($arr as $v){
            $pair = explode('=',$v);
            if(isset($pair[1])){
                $result[$pair[0]] = $pair[1];
            }
        }
        return $result;
    }

    function build_add_attr_str($arr){
        $result = "\"";
        foreach($arr as $k => $v){
            if(trim($v) !== ""){
                $result.="$k=$v,";
            }
        }
        $result = trim($result,",");
        $result .= "\"";
        return $result;

    
    }

    function attribute_merge($attributes1,$attributes2){
    
        $attr = ['sku' => $attributes1['sku']];
        if(isset($attributes2['additional_attributes'])){
        
            if(isset($attributes1['additional_attributes'])){
                $tmp = get_add_attr(trim($attributes1['additional_attributes'],"\""));
                $tmp2 = get_add_attr(trim($attributes2['additional_attributes'],"\""));

                $add_attr = array_merge($tmp,$tmp2);
                $attributes1['additional_attributes'] = build_add_attr_str($add_attr);
            }
            else{
                $attributes1['additional_attributes'] = $attributes2['additional_attributes'];
            }
        }
        $attr['additional_attributes'] =  $attributes1['additional_attributes'];
        return $attr;
    }

    function __autoload($class){
        $classFile = __DIR__ . "/class/".$class.".php";
        if(file_exists($classFile)){
            require_once($classFile);
        }
    }
