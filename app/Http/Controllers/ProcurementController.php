<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SparepartProcurement;
use App\DetailSparepartProcurement;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Transformers\ProcurementTransformers;
use App\Transformers\DetailProcurementTransformers;

class ProcurementController extends RestController
{
    protected $transformer = ProcurementTransformers::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procurement = SparepartProcurement::all();
        $response = $this->generateCollection($procurement);
        return $this->sendResponse($response);
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

            date_default_timezone_set('Asia/Jakarta');
            // return $request->detail;
            $detail = $request->get('detail');

            $procurement = new SparepartProcurement;

            $procurement->date_procurement=$request->get('date_procurement').' '.date('H:i:s');
            $procurement->status_procurement=$request->get('status_procurement');
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();
            if($request->has('detail'))
            {
                $procurement = DB::transaction(function () use ($procurement,$detail) {
                    $procurement->detailsparepartprocurement()->createMany($detail);
                    return $procurement;
                });
            }


            $response = $this->generateItem($procurement);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
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
        try {
            $procurement=SparepartProcurement::find($id);
            $response = $this->generateItem($procurement);
            return $this->sendResponse($response);
        // } catch (ModelNotFoundException $e) {
        //     return $this->sendNotFoundResponse('procurement_not_found');
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
        try {
            date_default_timezone_set('Asia/Jakarta');

            $detail = $request->get('detail');
            
            $procurement=SparepartProcurement::find($id);
            if($request->has('detail'))
            {
                $procurement->detailsparepartprocurement()->delete();
            }
            $procurement->date_procurement=$request->get('date_procurement').' '.date('H:i:s');
            $procurement->status_procurement=$request->get('status_procurement');
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();
            if($request->has('detail'))
            {
                $procurement = DB::transaction(function () use ($procurement,$detail) {
                    $procurement->detailsparepartprocurement()->createMany($detail);
                    return $procurement;
                });
            }

            $response = $this->generateItem($procurement);

            return $this->sendResponse($response, 201);

        // }catch (ModelNotFoundException $e) {
        //     return $this->sendNotFoundResponse('procurement_not_found');
        }
        catch (\Exception $e) {
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
            $procurement=SparepartProcurement::find($id);
            $procurement->delete();
            return response()->json('Success',200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeDetail(Request $request)
    {
        try {


            $detail = new DetailSparepartProcurement;

            $detail->id_procurement=$request->get('id_procurement');
            $detail->price_detail_procurement=$request->get('price_detail_procurement');
            $detail->amount_detail_procurement=$request->get('amount_detail_procurement');
            $detail->subtotal_detail_procurement=$request->get('subtotal_detail_procurement');
            $detail->id_sparepart=$request->get('id_sparepart');
            $detail->save();

            $response = $this->generateItem($detail, DetailProcurementTransformers::class);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateDetail(Request $request,$id)
    {
        try {


            $detail = DetailSparepartProcurement::find($id);

            $detail->price_detail_procurement=$request->get('price_detail_procurement');
            $detail->amount_detail_procurement=$request->get('amount_detail_procurement');
            $detail->subtotal_detail_procurement=$request->get('subtotal_detail_procurement');
            $detail->save();

            $response = $this->generateItem($detail, DetailProcurementTransformers::class);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function showDetail($id)
    {
        try {
            $detail=DetailSparepartProcurement::where("id_procurement",$id)->get();
            $response = $this->generateCollection($detail,DetailProcurementTransformers::class);
            return $this->sendResponse($response);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

}
