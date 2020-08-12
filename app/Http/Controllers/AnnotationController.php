<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\annotation;
use App\image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AnnotationController extends Controller
{
    //
    public function index(Request $request){
        // dd(gettype(DB::select('select * from annotations;')));
        // dd(DB::table('images')->get()[0]->image_url);
        return view('annotation',[
            'image'=>DB::table('images')->get(),
        ]);
    }
    
    public function create(Request $request){
        $request->validate([
            "img"=>'required',
            "obj"=>'required',
        ]);
        $image_data=$request->img;
        $image_array_1 = explode(";", $image_data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $extension = explode('/', $image_array_1[0])[1];
        $image_name = time() .'.'.$extension;
        $check=Storage::disk('annotation')->put($image_name, $data);
        if($check){
            //Image Store
            $image=new image();
            $image->image_name=$image_name;
            $image->image_url='storage/annotations/'.$image_name;
            $image->user_id=Auth::id();
            $image->save();
            
            // Annotation store
            $annotations=new annotation();
            $annotations->image_id=$image->id;
            $annotations->user_id=Auth::id();
            $annotations->annotation=json_encode($request->obj);
            $annotations->save();
            // file_put_contents(storage_path("app/public/annotations/annotations.w3c.json"),json_encode($request->obj));
            return response()->json('Succesful!');
        }
        else{
            return response()->json('Unsuccesful');
        }
    }

    public function update(Request $request,$id=null){
        $file=file_get_contents(storage_path("app/public/annotations/annotations.w3c.json"));
        $array_data=json_decode($file,true);
        $id_col=array_column($array_data,"id");
        $check=array_search($request->all()["id"],$id_col);
        if($check!==false){
            array_splice($array_data,(int)$check, 1);
            array_push($array_data,$request->all());
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
    public function getAnnotationData(Request $req,$id)
    {
        $result=DB::select("select annotation from annotations where id=?",[$id]);
        // file_put_contents(storage_path("app/public/annotations/annotates.json"),stripslashes($result[0]->annotation));
        file_put_contents(storage_path("app/public/annotations/annotates.json"),$result[0]->annotation);
        return response()->file(storage_path("app/public/annotations/annotates.json"));
    }

}
