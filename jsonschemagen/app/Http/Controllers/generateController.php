<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class generateController extends Controller
{
    public function jsonschema(Request $request){
        $details = Input::get('details');
        
        $data = json_decode($details);

        $mid = "";
        $required = "\"required\":[";
        $total0 = count((array)$data);
        foreach($data as $obj => $val ){
            $total = count((array)$val);
            
            $mid = $mid."\"".$obj."\"";

            $required = $required."\"".$obj."\"";
            if($total0 > 1)
                $required = $required.",";
            $wow = "";
            if(!empty((array) ($val))){
                //echo "wut";
                
                $wow =$this->rec($val,$total);
            }
            if(gettype($val) === "array"){
                $prop = "item";
            
            }
            else
                $prop = "properties";
            $mid = $mid.":{\"type\": \"".gettype($val)."\",
      \"".$prop."\": {".$wow."}";
            if($total0 > 1)
                $mid = $mid.",";
            else
                $mid = $mid;
            $total0--;
        }
        $output = "{\"type\": \"".gettype($data)."\",
      \"properties\": {".$mid."},".$required."]}";
        
        
        echo $output;
         return view('json-schema-form',compact($output));
        
    }
    public function rec($objs,$total){
     
        $mid ="";
        $required = "\"required\":[";
        $total0 = count((array)$objs);
        if (is_object($objs) || is_array($objs)){
            
        foreach($objs as $obj => $val ){
            //echo $obj;
            $total1 = count((array)$val);
            //echo gettype($val);
            if(gettype($val) === "object"){
                $mid = $mid."\"type\":\"".gettype($val)."\":{";
            }
            else
                $mid = $mid."\"".$obj."\":{\"type\":\"".gettype($val)."\"";
            
            //echo $obj;
            if ($obj != "item") {
            $required = $required."\"".$obj."\"";
            if($total0 > 1)
                $required = $required.",";
            }
            
            if(!empty((array) ($val)) || $obj = "item"){
                //echo gettype($val);
                $mid = $mid.$this->rec($val,$total1);
            }
            if(!(gettype($val) === "object")){
            if($total0 > 1)
                $mid = $mid."},";
            else
                $mid = $mid."}";
            }
            $total0--;
            //$mid = $mid."},";
        }
            if($obj != "item")
                return $mid."},".$required."]}";
            else return $mid;
        }
        //$mid."}";
        if($total0 > 1)
                $mid = $mid.",";
        
        return $mid;
    }
}
