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
Route::post('/authenticate', 'SessionController@authenticate');
Route::post('/mobileauthenticate', 'SessionController@mobileauthenticate');
Route::get('/session', 'SessionController@validateSession');


Route::resource ('employee','EmployeeController');
Route::resource ('branch','BranchController');
Route::resource ('role','RoleController');
Route::resource ('service','ServiceController');
Route::resource ('sparepart','SparepartController');
Route::post ('/sparepart/updateimage','SparepartController@updateImage');
Route::post('/sparepart/sparepartverify','SparepartController@sparepartVerify');
Route::patch ('/sparepart/updatecompatibility/{id}','SparepartController@updateCompatibility');
Route::resource ('spareparttype','SparepartTypeController');
Route::resource ('supplier','SupplierController');
Route::resource ('sales','SalesController');
Route::resource ('motorbrand','MotorcycleBrandController');
Route::resource ('motortype','MotorcycleTypeController');
Route::resource ('motorcustomer','MotorcycleCustomerController');
Route::resource ('customer','CustomerController');
Route::resource ('procurement','ProcurementController');

Route::get('procurement/detail/{id}','ProcurementController@showDetail');
Route::post('procurement/detail','ProcurementController@storeDetail');
Route::put('procurement/detail/{id}','ProcurementController@updateDetail');

Route::resource ('transaction','TransactionController');
Route::post('transaction/service','TransactionController@storeDetailService');
Route::get('transaction/service/{id}','TransactionController@showDetailService');
Route::post('transaction/sparepart','TransactionController@storeDetailSparepart');
Route::get('transaction/sparepart/{id}','TransactionController@showDetailSparepart');
Route::patch ('transaction/payment/{id}','TransactionController@payment');








