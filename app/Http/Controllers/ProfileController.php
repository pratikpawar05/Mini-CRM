<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id = null)
    {
        //
        $user = User::find($id)->get();
        return view('profile.index', [
            'user' => $user[0],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        //Get administrator
        $user=User::find($id);
        $user_p=explode('/',$user->profile_pic_url);
        $user_pic=array_pop($user_p);
        //Uploaded Image
        $image_data = $request->image;
        $image_array_1 = explode(";", $image_data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $extension = explode('/', $image_array_1[0])[1];
        $image_name = time() .'.'.$extension;
        $check=Storage::disk('public')->put($image_name, $data);
        if($check){
            if(Storage::disk('public')->exists($user_pic)){
                Storage::disk('public')->delete($user_pic);
            }
            $user->profile_pic_url='storage/user/'.$image_name;
            $user->updated_at =Carbon::now()->toDateTimeString();
            $user->save();
            return response()->json(['success'=>asset($user->profile_pic_url)]);
        }
        else{
            return response()->json(['error'=>'Unsuccefull attempt']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->notification_status = $request->notification_status;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->updated_at =Carbon::now()->toDateTimeString();
        $user->save();

        return response()->json('Succesfully Submitted the data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
