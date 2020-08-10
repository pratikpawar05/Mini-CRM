<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnotationController extends Controller
{
    //
    public function index(Request $request){
        // $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        // $array_data=json_decode($file,true);
        // $id_col=array_column($array_data,"id");
        // array_splice($array_data,0, 1);
        // $x=file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($array_data));
        // dd($x);
        return view('annotation');
    }
    
    public function create(Request $request){
        $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        $array_data=json_decode($file,true);
        $array_data[] = $request->all();
        $x=file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($array_data));
        return response()->json($x);
    }

    public function update(Request $request,$id=null){
        $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        $array_data=json_decode($file,true);
        $id_col=array_column($array_data,"id");
        $check=array_search($request->all()["id"],$id_col);
        if($check!==false){
            $array_data[$check] = $request->all();
                file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($array_data));
                return response()->json('Succesful');
         }
         else{
            return response()->json('Un-succesful');
         }
    }

    public function delete(Request $request,$id=null){
        $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        $array_data=json_decode($file,true);
        $id_col=array_column($array_data,"id");
        $check=array_search($request->all()["id"],$id_col);
        if($check!==false){
            array_splice($array_data,(int)$check, 1);
            file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($array_data));
            return response()->json('Succesful');
         }
         else{
            return response()->json('Un-succesful');
         }
    }

}
