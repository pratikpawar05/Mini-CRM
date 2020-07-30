<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Mail;
use DB;
// use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\DataTables;
class CompanyController extends Controller
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
            $data =Company::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('company.create');
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
            'name'=>'required|max:255',
            'email'=>'nullable|email:rfc,dns',
            'image'=> 'sometimes|required|dimensions:max_width=100,max_height=100'
        ]);
        if (request()->hasFile('logo')) {
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = $request->file('logo')->store('public/company');
            $company->website_url = $request->website_url;
            $company->save();
        } else {
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = 'company/noimage.png';
            $company->website_url = $request->website_url;
            $company->save();
        }
        $request->session()->flash('registered', 'Succesfully Registered The Company');
        $data=['name'=>$request->name];
        Mail::send('emails.welcome', $data, function ($message) {
            $message->from('pratikp@binated.in', 'Laravel');
            $message->to('icanpratikpawar@gmail.com');
            $message->cc('icanpratikpawar@gmail.com');
            $message->subject('Testing Mail');
        });
        
        return redirect(route('company.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        return response()->json(Company::get($id));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
       
    }
}
