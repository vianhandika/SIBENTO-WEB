<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\UserTransformers;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends RestController
{
    protected $transformer = UserTransformers::Class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        $response = $this->generateCollection($users);
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
        //
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
            $users = User::find($id);
            $response = $this->generateItem($users);
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
        //
    }

    public function changePassword(Request $request, $id) //Change Password
    {
        $this->validate($request, [
            'newPassword' => 'required|min:6'
        ]);

        try {
            $users = User::find($id);
            $users->password = bcrypt(request('newPassword'));
            $users->save();
            
            $response = $this->generateItem($users);
            return $this->sendResponse($response, 201);
            
            return response()->json('Success',201);

        } catch (\Exception $e) {
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
            $users=User::find($id);
            optional($users->employee())->delete();
            $users->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
