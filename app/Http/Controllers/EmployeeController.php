<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\EmployeeTransformers;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use App\User;

class EmployeeController extends RestController
{
    protected $transformer = EmployeeTransformers::Class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::get();
        $response = $this->generateCollection($employees);
        return $this->sendResponse($response, 201);  
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
    public function store(Request $request)
    {
        //return $request;
        try {
            $createdUser = User::create([
                'username'      => $request->username, //Need edited
                'password'      => bcrypt($request->username),//Need edited
                // 'password'      => bcrypt(request('name_employee')),            
            ]);

            $user = User::where('username',$request->username)->first(); //Need edited 

            $created = Employee::create([
                'name_employee'   => $request->name_employee,
                'salary'          => $request->salary,
                'phone_number'    => $request->phone_number,
                'address'         => $request->address,
                'id_branch'       => $request->branch,
                'id_role'         => $request->role,
                'id_user'         => $user->id_user,
                
            ]);

            $response = $this->generateItem($created);
            return $this->sendResponse($response, 201);            

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
            // return response()->json(['Failed To Register'=>'Failed'], 400);
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
        try{
            // $employees = Employee::where('id_employee',$id)->first();
            $employees=Employee::find($id);
            $response = $this->generateItem($employees);
            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
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
        try{

            // $employees = Employee::find($id);
            // $employees->name_employee = $request->name_employee;
            // $employees->salary = $request->salary;
            // $employees->phone_number = $request->phone_number;
            // $employees->address = $request->address;
            // $employees->save();
            $events = Employee::find($id)->update($request->All());
            $data = Employee::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);


        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employees=Employee::find($id);
            optional($employees->user())->delete();
            $employees->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

}
