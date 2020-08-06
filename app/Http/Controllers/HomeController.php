<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Employee;
use Carbon\Carbon;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $yesterday_date=Carbon::yesterday()->toDateString();
        $total_employees=Employee::count();
        $total_companies=Company::count();
        $company=Company::where('created_at','like',$yesterday_date.'%')->get();
        $employee=Employee::where('created_at','like',$yesterday_date.'%')->get();
        // dd(count($company));
        // $comp=Company::all('created_at');
        // dd($comp);
        // dd($yesterday_date);
        
        return view('home',[
            'companies'=>$company,
            'employees'=>$employee,
            'total_employees'=>$total_employees,
            'total_companies'=>$total_companies,
        ]);
    }
}
