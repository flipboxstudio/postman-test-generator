<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;
use session;

class genController extends Controller
{
    
    public function home(){
        $response="";
        $result="";
        
        session(['details' =>""]);
        session(['response' =>""]);
        return View::make('json-schema-form',compact('result','response'));
    }
    public function jsonschema(Request $request){
        
        
        
        
        $this->validate($request, ['details' =>'required' , 
                                   'response' => 'required'],
                       ['required' => 'this field must not empty!']);
        
        $details = Input::get('details');
        $response = Input::get('response');
        
        session(['details' =>$details]);
        session(['response' =>$response]);
        $data = json_decode($details);
        
        if($data === null)
            return redirect("/")->withErrors(['Invalid json']);
        $total = count((array)$data);
        
        $result = "{\"\$schema\": \"http://json-schema.org/draft-04/schema#\",".$this->rec($data,$total)."};";
        
        return View::make('json-schema-form',compact('result','response'));
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
