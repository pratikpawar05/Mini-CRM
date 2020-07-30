<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Resource_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    //Company Routes
    Route::Resource('/company','CompanyController');
    // Route::get('/company/getAllData','CompanyController@getAllData');
    //Employee Routes
    Route::Resource('/employee','EmployeeController',['only' => [
        'index','store', 'create'
    ]]);
    Route::get('/employee/getData/{id}','EmployeeController@getData');
    Route::post('/employee/update/{id}','EmployeeController@update');
    Route::post('/employee/delete/{id}','EmployeeController@delete');
    
    Route::get('/home', 'HomeController@index')->name('home');
    
});
