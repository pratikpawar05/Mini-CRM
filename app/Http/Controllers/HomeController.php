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
        //Associative Array creation
        $data=[];
        $yesterday_date=Carbon::yesterday()->toDateString();
        $total_employees=Employee::count();
        $total_companies=Company::count();
        $company=Company::where('created_at','like',$yesterday_date.'%')->get();
        $employee=Employee::where('created_at','like',$yesterday_date.'%')->get();
        $compa=DB::select('SELECT CAST(created_at AS DATE) as created_at,count(*) as count FROM companies GROUP BY CAST(created_at AS DATE)');
        $empa=DB::select('SELECT CAST(created_at AS DATE) as created_at,count(*) as count FROM employees GROUP BY CAST(created_at AS DATE)');
        //Graph data preparation// 
        foreach ($compa as $val)
        {
            $date=$val->created_at;
            if(isset($data[$date])){
                $data[$date]['count_company']=$val->count;
            }
            else{
                $data[$date]=['count_company'=>$val->count,'count_employee'=>0];
            }
        }
        foreach ($empa as $key=>$val)
        {
           $date=$val->created_at;
            if(isset($data[$date])){
                $data[$date]['count_employee']=$val->count;
            }
            else{
                $data[$date]=['count_company'=>0,'count_employee'=>$val->count];
            }
        }
        // dd(array_keys($data));
        // dd(array_column($data, 'count_company'));
        
        return view('home',[
            'companies'=>$company,
            'employees'=>$employee,
            'total_employees'=>$total_employees,
            'total_companies'=>$total_companies,
            'data'=>$data,
        ]);
    }
}
