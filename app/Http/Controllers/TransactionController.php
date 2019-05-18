<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Sparepart;
use App\DetailTransactionService;
use App\DetailTransactionSparepart;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Transformers\TransactionTransformers;
use App\Transformers\DetailSparepartTransformers;
use App\Transformers\DetailServiceTransformers;


class TransactionController extends RestController
{
    protected $transformer = TransactionTransformers::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        $response = $this->generateCollection($transactions);
        return $this->sendResponse($response);
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

            date_default_timezone_set('Asia/Jakarta');

            if($request->has('service'))
            {
                $service = $request->get('service');
            }
            if($request->has('sparepart'))
            {
                $sparepart = $request->get('sparepart');
            }
            if($request->has('employee'))
            {
                $employee = $request->get('employee');
            }

            $transaction = new Transaction;
            $count = Transaction::get()->count()+1;

            if($request->get('type_transaction')=='Service')
            {
                $transaction->id_transaction='SV'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('type_transaction')=='Sparepart')
            {
                $transaction->id_transaction='SP'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('type_transaction')=='Service And Sparepart')
            {
                $transaction->id_transaction='SS'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            $transaction->date_transaction=date("Y-m-d").' '.date('H:i:s');
            $transaction->status_process=$request->get('status_process');
            $transaction->status_paid="Unpaid";
            $transaction->type_transaction=$request->get('type_transaction');
            $transaction->discount_transaction=0;
            $transaction->total_transaction=$request->get('total_transaction');
            $transaction->id_customer=$request->get('id_customer');
            $transaction->save();

            if($request->has('employee'))
            {
                $transaction = DB::transaction(function () use ($transaction,$employee) {
                    $transaction->employee()->attach($employee);
                    return $transaction;
                });
            }
            if($request->has('service'))
            {
                $transaction = DB::transaction(function () use ($transaction,$service) {
                    $transaction->detail_transaction_service()->createMany($service);
                    return $transaction;
                });
            }
            if($request->has('sparepart'))
            {
                $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                    $transaction->detail_transaction_sparepart()->createMany($sparepart);
                    return $transaction;
                });

                // foreach($sparepart as $value)
                // {
                //     $data = Sparepart::find($value['id_sparepart']);
                //     $data->stock_sparepart = $data->stock_sparepart - $value['amount_transaction_sparepart'];
                //     $data->save();
                // }
            }

            // foreach($sparepart as $value)
            // {
            //     $data = Sparepart::find($value['id_sparepart']);
            //     $data->stock = $data->stock - $value['amount_transaction_sparepart'];
            //     $data->save();
            //     if($data->stock<$data->min_stock)
            //     {
            //         $token=['cBy9I4NDXro:APA91bF0sDMutZo5aQo4VY9hMfmoOvY3mUjSXWwdZaGsKNVRgOtWRgVyBGX-SIAWRdbFLnURZQ-boB9_p3MaN03DUxKyyN-helrFnDgig_UdH2ffIGWCNSTsvdQ_FAbu42B-iPbzkvaK','fzQS5wVJYt4:APA91bG8Ldrp_8ksxZyC446z1TkPkux5_a8bpRkAwIDhEh7exYw6n4WoYUesq9EAKoUWG6FS5xHp1DxoVBU2andL1elkCqB4IpmTLIAYGVkOUEAMAGOR1XJ9DH6HoR6-A72K3O0rFLrd','cpb9nmgdPwg:APA91bFB2HkGGRhaPmzhkrAq7g2TjFsrYvTJ_S6DrjVhLGWaG7sy2S8nqIMi5JfAkX96Er-WvXdMbhrycSbRY4L49P_BUDW32nrzDJinUMW-UgfZqTEi8OfeQOnUBqv869Hdf_Yw-ybd','evv7Xzo4w_Y:APA91bEz8LNHRLzG4hqOY5ExDoF_50uy9dQdnCpt3bCGf-LezeUgGtzLXzLCx2wrTSfuRV6hSKr7tDEz8pYg0uZwHSG6JLWPrkzkKBWbSxsLAkT6Kp4R-1fRsRAyXkgYg6q81LwhPgxa'];

            //         // $notification = [
            //         //     'body' => 'this is test',
            //         //     'sound' => true,
            //         // ];
                    
            //         $data = array('title' => $data->sparepart_name ,'body' => 'kurang dari jumlah stock minimal');
            //         $fcmNotification = [
            //             'registration_ids' => $token, 
            //             // 'to'        => $token, //single token
            //             'priority' => "high",
            //             'notification' => $data,
            //         ];
                
                    
            //         $url = 'https://fcm.googleapis.com/fcm/send';
            //         $server_key = "AAAA49vwxPw:APA91bGsqHe9cRCcMcU2X47Tao1GWIDbA029PnPxgXaSL5wEvia2mJJiuINEV0dt-Wy9e2Jls8OV3T87h6SsH70DmitZg8J0f3aeENRCuoLDIWH58o9lXNKNc_4wSZ35Ya8cXwiNq0jX";

            //         $headers = [
            //             'Authorization: key='.$server_key,
            //             'Content-Type: application/json'
            //         ];


            //         $ch = curl_init();
            //         curl_setopt($ch, CURLOPT_URL,$url);
            //         curl_setopt($ch, CURLOPT_POST, true);
            //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            //         $result = curl_exec($ch);
            //         if ($result === FALSE) {
            //             return curl_error($ch);
            //         }
            //         curl_close($ch);
            //     }
            // }


            // return $result;

            $response = $this->generateItem($transaction);

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
            $transaction=Transaction::find($id);
            $response = $this->generateItem($transaction);
            return $this->sendResponse($response);

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

            if($request->has('service'))
            {
                $service = $request->get('service');
            }
            if($request->has('sparepart'))
            {
                $sparepart = $request->get('sparepart');
            }

            $transaction = Transaction::find($id);

            // $t= Transaction::with('detail_transaction_sparepart')->get();

            // foreach($t as $value )
            // {
            //     if($value->id_transaction==$id)
            //     {
            //         $sparepart2=$value->detail_transaction_sparepart;
            //     }
            // }
            // // $sparepart2 = $t->detail_spareparts;

            // foreach($sparepart2 as $value)
            // {
            //     $data = Sparepart::find($value->id_sparepart);
            //     $data->stock_sparepart = $data->stock_sparepart - $value->amount_transaction_sparepart;
            //     $data->save();
            // }
            if($request->has('sparepart'))
            {
                $transaction->detail_transaction_sparepart()->delete();
            }
            if($request->has('service'))
            {
                $transaction->detail_transaction_service()->delete();
            }
                 

            if($request->get('type_transaction')!=$transaction->type_transaction)
            {
                $count = Transaction::get()->count();
    
                if($request->get('type_transaction')=='Service')
                {
                    $transaction->id_transaction='SV'.'-'.date("d").date("m").date("y").'-'.$count;
                }
                else if($request->get('type_transaction')=='Sparepart')
                {
                    $transaction->id_transaction='SP'.'-'.date("d").date("m").date("y").'-'.$count;
                }
                else if($request->get('type_transaction')=='Service And Sparepart')
                {
                    $transaction->id_transaction='SS'.'-'.date("d").date("m").date("y").'-'.$count;
                }
            }         
            // $transaction->transaction_date=date("Y-m-d").' '.date('H:i:s');
            $transaction->status_process=$request->get('status_process');
            $transaction->status_paid="Unpaid";
            $transaction->type_transaction=$request->get('type_transaction');
            $transaction->discount_transaction=0;
            $transaction->total_transaction=$request->get('total_transaction');
            $transaction->id_customer=$request->get('id_customer');
            $transaction->save();

            if($request->has('service'))
            {
                $transaction = DB::transaction(function () use ($transaction,$service) {
                    $transaction->detail_transaction_service()->createMany($service);
                    return $transaction;
                });
            }
            if($request->has('sparepart'))
            {
                $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                    $transaction->detail_transaction_sparepart()->createMany($sparepart);
                    return $transaction;
                });
 
                // foreach($sparepart as $value)
                // {
                //     $data = Sparepart::find($value['id_sparepart']);
                //     $data->stock_sparepart = $data->stock_sparepart - $value['amount_transaction_sparepart'];
                //     $data->save();
                // }
                
            }


            // foreach($sparepart as $value)
            // {
            //     $data = Sparepart::find($value['id_sparepart']);
            //     $data->stock = $data->stock - $value['amount_transaction_sparepart'];
            //     $data->save();
            //     if($data->stock<$data->min_stock)
            //     {
            //         $token=['cBy9I4NDXro:APA91bF0sDMutZo5aQo4VY9hMfmoOvY3mUjSXWwdZaGsKNVRgOtWRgVyBGX-SIAWRdbFLnURZQ-boB9_p3MaN03DUxKyyN-helrFnDgig_UdH2ffIGWCNSTsvdQ_FAbu42B-iPbzkvaK','fzQS5wVJYt4:APA91bG8Ldrp_8ksxZyC446z1TkPkux5_a8bpRkAwIDhEh7exYw6n4WoYUesq9EAKoUWG6FS5xHp1DxoVBU2andL1elkCqB4IpmTLIAYGVkOUEAMAGOR1XJ9DH6HoR6-A72K3O0rFLrd','cpb9nmgdPwg:APA91bFB2HkGGRhaPmzhkrAq7g2TjFsrYvTJ_S6DrjVhLGWaG7sy2S8nqIMi5JfAkX96Er-WvXdMbhrycSbRY4L49P_BUDW32nrzDJinUMW-UgfZqTEi8OfeQOnUBqv869Hdf_Yw-ybd','evv7Xzo4w_Y:APA91bEz8LNHRLzG4hqOY5ExDoF_50uy9dQdnCpt3bCGf-LezeUgGtzLXzLCx2wrTSfuRV6hSKr7tDEz8pYg0uZwHSG6JLWPrkzkKBWbSxsLAkT6Kp4R-1fRsRAyXkgYg6q81LwhPgxa'];

            //         // $notification = [
            //         //     'body' => 'this is test',
            //         //     'sound' => true,
            //         // ];
                    
            //         $data = array('title' => $data->sparepart_name ,'body' => 'kurang dari jumlah stock minimal');
            //         $fcmNotification = [
            //             'registration_ids' => $token, 
            //             // 'to'        => $token, //single token
            //             'priority' => "high",
            //             'notification' => $data,
            //         ];
                
                    
            //         $url = 'https://fcm.googleapis.com/fcm/send';
            //         $server_key = "AAAA49vwxPw:APA91bGsqHe9cRCcMcU2X47Tao1GWIDbA029PnPxgXaSL5wEvia2mJJiuINEV0dt-Wy9e2Jls8OV3T87h6SsH70DmitZg8J0f3aeENRCuoLDIWH58o9lXNKNc_4wSZ35Ya8cXwiNq0jX";

            //         $headers = [
            //             'Authorization: key='.$server_key,
            //             'Content-Type: application/json'
            //         ];


            //         $ch = curl_init();
            //         curl_setopt($ch, CURLOPT_URL,$url);
            //         curl_setopt($ch, CURLOPT_POST, true);
            //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            //         $result = curl_exec($ch);
            //         if ($result === FALSE) {
            //             return curl_error($ch);
            //         }
            //         curl_close($ch);
            //     }
            // }

            $response = $this->generateItem($transaction);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function payment(Request $request, $id)
    {
        try {

            // return $request;
            $transaction = Transaction::find($id);
            $employee = $request->get('employee');
            $transaction->status_paid="Paid";
            $transaction->discount_transaction=$request->get('discount_transaction');;
            $transaction->total_transaction=$request->get('total_transaction');
            $transaction->save();
            $transaction = DB::transaction(function () use ($transaction,$employee) {
                $transaction->employee()->attach($employee);
                return $transaction;
            });
            foreach($transaction->detail_transaction_sparepart as $value)
            {
                $data = Sparepart::find($value['id_sparepart']);
                $data->stock_sparepart = $data->stock_sparepart - $value['amount_transaction_sparepart'];
                $data->save();
            }
            $response = $this->generateItem($transaction);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeDetailService(Request $request)
    {
        try {
            $detail = new DetailTransactionService;
            $detail->id_transaction=$request->get('id_transaction');
            $detail->amount_transaction_service=$request->get('amount_transaction_service');
            $detail->price_transaction_service=$request->get('price_transaction_service');
            $detail->subtotal_transaction_service=$request->get('subtotal_transaction_service');
            $detail->id_service=$request->get('id_service');
            $detail->id_employee=$request->get('id_employee');
            $detail->id_motorcycle=$request->get('id_motorcycle');
            $detail->save();
            $response = $this->generateItem($detail, DetailServiceTransformers::class);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
    public function storeDetailSparepart(Request $request)
    {
        try {
            $detail = new DetailTransactionSparepart;
            $detail->id_transaction=$request->get('id_transaction');
            $detail->amount_transaction_sparepart=$request->get('amount_transaction_sparepart');
            $detail->price_transaction_sparepart=$request->get('price_transaction_sparepart');
            $detail->subtotal_transaction_sparepart=$request->get('subtotal_transaction_sparepart');
            $detail->id_sparepart=$request->get('id_sparepart');
            $detail->id_employee=$request->get('id_employee');
            $detail->id_motorcycle=$request->get('id_motorcycle');
            $detail->save();
            $sparepart = Sparepart::find($request->get('id_sparepart'));
            $sparepart->stock_sparepart = $data->stock_sparepart - ($request->get('detail_sparepart_amount'));
            $sparepart->save();
            $response = $this->generateItem($detail, DetailSparepartTransformers::class);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
    public function showDetailService($id)
    {
        try {
            $detail=DetailTransactionService::where("id_transaction",$id)->get();
            $response = $this->generateCollection($detail,DetailServiceTransformers::class);
            return $this->sendResponse($response);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
    public function showDetailSparepart($id)
    {
        try {
            $detail=DetailTransactionSparepart::where("id_transaction",$id)->get();
            $response = $this->generateCollection($detail,DetailSparepartTransformers::class);
            return $this->sendResponse($response);
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
            $transaction=Transaction::find($id);
            // $transaction->employee->delete();
            $transaction->delete();
            return response()->json('Success',200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
