<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\SupplierTransformers;
use Illuminate\Support\Facades\Hash;
use App\Supplier;


class SupplierController extends RestController
{
    protected $transformer = SupplierTransformers::Class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::get();
        $response = $this->generateCollection($supplier);
        return $this->sendResponse($response, 201);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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

            $created = Supplier::create([
                'name_supplier'             => $request->name_supplier,
                'phone_number_supplier'     => $request->phone_number_supplier,
                'address_supplier'          => $request->address_supplier,
                
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
            
            $supplier=Supplier::find($id);
            $response = $this->generateItem($supplier);
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

            $events = Supplier::find($id)->update($request->All());
            $data = Supplier::find($id);
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
            $supplier=Supplier::find($id);
            optional($supplier->sales())->delete();
            $supplier->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
