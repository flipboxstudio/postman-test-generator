<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;
use session;

class genController extends Controller
{
    
    public function home(){
        return view('json-schema-form');
    }

    public function jsonschema(Request $request){
        $this->validate($request,[
            'json' => 'required|json',
            'response_time' => 'required|numeric'
        ]);
        $details = $request->json;
        $response = $request->response_time;
        $data = json_decode($details);
        $total = count((array)$data);
        $result = "{\"\$schema\": \"http://json-schema.org/draft-04/schema#\",".$this->rec($data,$total)."}";
        $result = json_encode(json_decode($result), JSON_PRETTY_PRINT);
        return view('response',compact('result','response'));
    }
    
    public function rec($data, $total){
        $properties = "\"type\":\"".gettype($data)."\"";
        $required = "\"required\":";
        $mid = "";
        $mod = "";
        $tempreq = "";
        if (is_object($data) || is_array($data)){
            $newtotal = count((array)$data);
            foreach($data as $obj => $val){
                if(!empty((array) ($val))){
                    if(is_object($data))
                        $mid = "\"".$obj."\":{".$this->rec($val,$newtotal)."}";
                    else
                        $mid = $this->rec($val,$newtotal);
                }
                $mod = $mod.$mid;
                $tempreq = $tempreq."\"".$obj."\"";
                if($newtotal > 1){
                    $mod = $mod.",";
                    $tempreq = $tempreq.",";
                }
                
                $newtotal--;
            }
            if(gettype($data) === "object"){
                $properties = $properties.",\"properties\":{".$mod."},".$required."[".$tempreq."]";
            }
            else
            {
                $properties = $properties.",\"item\":{".$mod."}";
            }
        }
        return $properties;
        
    }


}
