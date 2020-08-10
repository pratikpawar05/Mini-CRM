<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class AnnotationController extends Controller
{
    //
    public function index(Request $request){
        return view('annotation');
    }
}
