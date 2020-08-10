<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Expr\Cast\Object_;

class AnnotationController extends Controller
{
    //
    public function index(Request $request){
        return view('annotation');
    }
    public function create(Request $request){
        $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        $array_data=json_decode($file,true);
        $array_data[] = $request->all();
        $x=file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($array_data));
        return response()->json($x);
    }

}
