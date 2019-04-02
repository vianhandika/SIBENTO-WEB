<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\CustomerTransformers;
use App\Customer;

class CustomerController extends RestController
{
    protected $transformer = CustomerTransformers::Class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::get();
        $response = $this->generateCollection($customer);
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

            $created = Customer::create([
                'name_customer'             => $request->name_customer,
                'address_customer'          => $request->address_customer,
                'phone_number_customer'     => $request->phone_number_customer,
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
            
            $customer=Customer::find($id);
            $response = $this->generateItem($customer);
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

            $events = Customer::find($id)->update($request->All());
            $data = Customer::find($id);
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
            $customer=Customer::find($id);
            optional($customer->motorcyclecustomer())->delete();
            $customer->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
