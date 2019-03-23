<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\SalesTransformers;
use Illuminate\Support\Facades\Hash;
use App\Sales;

class SalesController extends RestController
{
    protected $transformer = SalesTransformers::Class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::get();
        $response = $this->generateCollection($sales);
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
        try {

            $created = Sales::create([
                'name_sales'             => $request->name_sales,
                'phone_number_sales'     => $request->phone_number_sales,
                'id_supplier'            => $request->id_supplier,
                
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
            
            $sales=Sales::find($id);
            $response = $this->generateItem($sales);
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

            $events = Sales::find($id)->update($request->All());
            $data = Sales::find($id);
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
            $sales=Sales::find($id);
            $sales->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
