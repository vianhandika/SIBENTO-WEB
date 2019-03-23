<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\SparepartTransformers;
use Illuminate\Support\Facades\Hash;
use App\Sparepart;

class SparepartController extends RestController
{
    protected $transformer = SparepartTransformers::Class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sparepart = Sparepart::get();
        // return $sparepart;
        $response = $this->generateCollection($sparepart);
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

            $created = Sparepart::create([
                'id_sparepart'              => $request->id_sparepart,
                'name_sparepart'            => $request->name_sparepart,
                'brand_sparepart'           => $request->brand_sparepart,
                'id_sparepart_type'         => $request->id_sparepart_type,
                'stock_sparepart'           => $request->stock_sparepart,
                'minimal_stock_sparepart'   => $request->minimal_stock_sparepart,
                'buy_price'                 => $request->buy_price,
                'sell_price'                => $request->sell_price,
                'placement'                 => $request->placement,
                'image_sparepart'           => $request->image_sparepart,
                
            ]);

            if($request->hasfile('image_sparepart'))
            {
                $file = $request->file('image_sparepart');
                $name=$created->id_sparepart.".jpg";
                $file->move(public_path().'/images/sparepart/', $name);
                $created->image_sparepart='/images/sparepart/'.$name;
            }
            
            $created->save();

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
            $sparepart=Sparepart::where('id_sparepart',$id)->first();
            $response = $this->generateItem($sparepart);
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
            
            $event = Sparepart::where('id_sparepart',$id)->first()->update($request->All());
            $data = Sparepart::where('id_sparepart',$id)->first();
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);


        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateImage(Request $request)
    {
        try{
            $data = Sparepart::where('id_sparepart',$request->id_sparepart)->first();

            if($request->hasfile('image_sparepart'))
            {
                $file = $request->file('image_sparepart');
                $name=$data->id_sparepart.".jpg";
                $file->move(public_path().'/images/sparepart/', $name);
                $data->image_sparepart='/images/sparepart/'.$name;
            }

            $data->save();

            $response = $this->generateItem($data);
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
            $sparepart=Sparepart::where('id_sparepart',$id)->first();
            $sparepart->delete();
            return response()->json('Success',201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
