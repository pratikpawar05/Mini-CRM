<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Resource_;
use App\Company;
use App\Employee;
use App\Mail\OnBoardMail;
use PhpParser\Node\Expr\Empty_;

//Basic Url to get into system
Route::get('/', function () {
    return redirect('/login');
});

// Configuring auth routes
Auth::routes();

// Verifying authencity of users based on auth middleware
Route::group(['middleware' => ['auth']], function () {
    // Profile Routes
    Route::get('/profile/index/{id}','ProfileController@index')->name('profile.index');
    Route::post('/profile/update/{id}','ProfileController@update')->name('profile.update');
    Route::post('/profile/store/{id}','ProfileController@store')->name('profile.store');

    //Company Routes
    Route::Resource('/company','CompanyController',['only' => [
        'index','store', 'create'
    ]]);
    Route::post('/company/delete/{id}','CompanyController@delete');
    Route::post('/company/update/{id}','CompanyController@update');

    //Employee Routes
    Route::Resource('/employee','EmployeeController',['only' => [
        'index','store', 'create'
    ]]);
    Route::post('/employee/update/{id}','EmployeeController@update');
    Route::post('/employee/delete/{id}','EmployeeController@delete');
   
    //Home Controller Routes
    Route::get('/home', 'HomeController@index')->name('home');

    //Annotation Controller Routes
    Route::get('/annotation', 'AnnotationController@index')->name('annotation.index');
    Route::post('/annotation', 'AnnotationController@create')->name('annotation.create');
    Route::post('/annotation/update/{id?}', 'AnnotationController@update')->name('annotation.update');
    Route::post('/annotation/delete/{id?}', 'AnnotationController@delete')->name('annotation.delete');
    Route::get('/annotation/{id}', 'AnnotationController@getAnnotationData')->name('annotation.getAnnotationData');

    //Testing mail functionality!!
    Route::get('/company/testMail',function(){
        $details = [
            'company_name'=>'MyName',
        ];
        \Mail::to('anonymouscoder05@gmail.com')->queue(new OnBoardMail($details));
        print_r("Email has been sent!");
    });
});
