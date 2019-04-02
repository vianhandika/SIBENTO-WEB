<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\MotorcycleCustomerTransformers;
use App\MotorcycleCustomer;

class MotorcycleCustomerController extends RestController
{
    protected $transformer = MotorcycleCustomerTransformers::Class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motor = MotorcycleCustomer::get();
        $response = $this->generateCollection($motor);
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

            $created = MotorcycleCustomer::create([
                'plate_number'          => $request->plate_number,
                'id_motorcycle_type'    => $request->id_motorcycle_type,
                'id_customer'           => $request->id_customer,
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
            
            $motor=MotorcycleCustomer::find($id);
            $response = $this->generateItem($motor);
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

            $events = MotorcycleCustomer::find($id)->update($request->All());
            $data = MotorcycleCustomer::find($id);
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
            $motor=MotorcycleCustomer::find($id);
            $motor->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
