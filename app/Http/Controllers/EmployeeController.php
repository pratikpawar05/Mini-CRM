<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            // $query =DB::table('companies')->orderBy('id');
            $data= Employee::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Edit</button>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->addColumn('company_name', function($data){
                return '<b id="'.$data->company_id.'">'.Company::find($data->company_id)->name.'</b>';
            })
            ->rawColumns(['action','company_name'])
            ->make(true);
        }
        return view('employee.index',[
            'company_data'=>Company::all(),
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
        return view('employee.create',[
            'companies'=>Company::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'company'=>'required|not_in:0',
            'email'=>'nullable|sometimes|email:rfc,dns',
            'phone' => 'nullable|sometimes|regex:/[0-9]{10}/'
        ]);
        $emp =  Employee::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'company_id'=>$request->company,
            'email'=>$request->email,
            'phone'=>$request->phone,
        ]);
        $request->session()->flash('registered', 'Succesfully Registered The Employee');
        return redirect('/employee');
    }

    /**
     * get all the company resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getData(int $id)
    {
        //
        return response()->json(Company::all());
        
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        //   
        $request->validate([
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'company'=>'required|not_in:0',
            'email'=>'sometimes|email:rfc,dns',
            'phone' => 'sometimes|regex:/(01)[0-9]{9}/'
        ]);
        $emp=Employee::find($id);
        $emp->first_name=$request->first_name;
        $emp->last_name=$request->last_name;
        $emp->company_id=$request->company;
        $emp->email=$request->email;
        $emp->phone=$request->phone;
        $emp->updated_at =Carbon::now()->toDateTimeString();
        $emp->save();
        // return response()->json($request->header());
        return response()->json($request->first_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,int $id)
    {
        //
        Employee::destroy($id);
        // $request->session()->flash('registered', 'Succesfully Deleted The Employee');
        
    }

}
