<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('company.index',[
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
        ]);
        if (request()->hasFile('logo')) {
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = $request->file('logo')->store('public/company');
            $company->website_url = $request->website_url;
            $company->save();
            $request->session()->flash('posts', 'Succesfully Registered The Company');
        } else {
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = 'company/noimage.png';
            $company->website_url = $request->website_url;
            $company->save();
            $request->session()->flash('registered', 'Succesfully Registered The Company');
        }
        return redirect(route('company.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
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
