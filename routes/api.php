<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource ('user','UserController');
Route::patch    ('user/changepassword/{id}' ,'UserController@changePassword');


Route::resource ('employee','EmployeeController');
Route::resource ('branch','BranchController');
Route::resource ('role','RoleController');
Route::resource ('service','ServiceController');
Route::resource ('sparepart','SparepartController');
Route::post ('/sparepart/updateimage','SparepartController@updateImage');
Route::resource ('spareparttype','SparepartTypeController');
Route::resource ('supplier','SupplierController');
Route::resource ('sales','SalesController');




