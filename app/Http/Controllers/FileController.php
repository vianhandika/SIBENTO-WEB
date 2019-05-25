<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SparepartProcurement;
use App\Transaction;
use App\SparepartType;

class FileController extends Controller
{
    /**
     * Generate receipt of procurement.
     *
     * @param int $id
     * @return void
     */
    public function generateProcurementPdf($id)
    {
        try {
            // Carbon::setLocale('id');
            // // $translator = Carbon::setLocale('id');
            // $date = Carbon::now()->setlocale('id')->format('l, d F Y H:i');
            $procurement = SparepartProcurement::find($id);
            $date=date('Ymd', strtotime($procurement->date_procurement));
            // $date=date('d F Y', strtotime($procurement->date_procurement));
            // return $date;
            // $date = $date->format('Ymd');


            $no = 1;
            $pdf = PDF::loadView('pdf.procurement', compact('procurement', 'no'))->setPaper('a4', 'portrait');
            return $pdf->stream();
            // return $pdf->download('PROC_' . $date . '.pdf');

        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), $e->getCode());
            return response()->json($e->getMessage());
        }
    }
    public function generateSPK($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $transaction = Transaction::find($id);
            $date = Carbon::now();

            $service_details = $transaction->detail_transaction_service
                ->map(function ($item) {
                    return $item;
            });

            $sparepart_details = $transaction->detail_transaction_sparepart
                ->map(function ($item){
                    return $item;
            });

            $mechanics=[];
            $sparepartmotorcycles=[];
            $servicemotorcycles=[];
            $motorcycles=[];
            $temp = 0;

            foreach($service_details as $detail)
            {
                if($mechanics!=NULL)
                {
                    foreach($mechanics as $mechanic)
                    {
                        if($mechanic!=$detail->mechanic->name_employee)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }
                    }
                    if($temp ==1)
                    {
                        array_push($mechanics,$detail->mechanic->name_employee);
                    }
                    

                }
                else{
                    array_push($mechanics,$detail->mechanic->name_employee);
                }
            }


            foreach($sparepart_details as $detail)
            {
                if($detail->id_employee!=NULL)
                {
                    if($mechanics!=NULL)
                    {
                        foreach($mechanics as $mechanic)
                        {
                            if($mechanic!=$detail->mechanic->name_employee)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }
                            
                        }
                        if($temp ==1)
                        {
                            array_push($mechanics,$detail->mechanic->name_employee);
                        }
                    }
                    else{
                        array_push($mechanics,$detail->mechanic->name_employee);
                    }
                }
            }

            foreach($service_details as $detail)
            {
                if($motorcycles!=NULL)
                {
                    foreach($motorcycles as $motorcycle)
                    {
                        if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }   
                    }
                    if($temp ==1)
                    {
                        array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                    }   
                }
                else{
                    array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                }
            }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_motorcycle!=NULL)
                {
                    if($motorcycles!=NULL)
                    {
                        foreach($motorcycles as $motorcycle)
                        {
                            if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }   

                        }
                        if($temp ==1)
                        {
                            array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                        }   
                    }
                    else{
                        array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                    }
                }
            }
            
            
            // return $mechanics;
            // return $motorcycles;
            $pdf = PDF::loadView('pdf.spk', compact('transaction','mechanics','motorcycles','date'))->setPaper('a4', 'portrait');


            // return $pdf->download($transaction->id_transaction . '.pdf');
            return $pdf->stream();

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Generate receipt of Transaction
     *
     * @param string $id
     * @return void
     */
    public function generateSPKPdf($id)
    {
        try {
            $transaction = Transaction::find($id);
            // $users = User::select('name')->distinct()->get();
            // $motor = $transaction->with('detail_transaction_service')->motorcyclecustomer->select('plate_number')->distinct()->get();
            // $motor = $transaction->detail_transaction_service()->with('motorcyclecustomer')->get();
            // $motor = $transaction->detail_transaction_service()->get();

            // return $motor;
            // return $total_sparepart;
            // return $transaction->employee;
            $service_details = $transaction->detail_transaction_service
            ->map(function ($item) {
                return $item;
            });
            $sparepart_details = $transaction->detail_transaction_sparepart
            ->map(function ($item) {
                return $item;
            });

            if($transaction->type_transaction == 'Sparepart')
            {
                // $mechanics = $sparepart_details->reduce(function ($carry, $item) {
                //     return $item->mechanic;
                // }, []);
                $mechanics = $transaction->detail_transaction_sparepart()->first()->mechanic->name_employee;

                $motor = $transaction->detail_transaction_sparepart()->first()->motorcyclecustomer;
            }
            else{
                // $mechanics = $service_details->reduce(function ($carry, $item) {
                //     return $item->mechanic;
                // }, []);
                $mechanics = $transaction->detail_transaction_service()->first()->mechanic->name_employee;

                $motor = $transaction->detail_transaction_service()->first()->motorcyclecustomer;

            }
            
            // return $motor;

            $pdf = PDF::loadView('pdf.spk', compact('transaction','motor','mechanics'))->setPaper('a4', 'portrait');

            return $pdf->stream();
            // return $pdf->download($transaction->transaction_code . '.pdf');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function generateNotaPdf($id)
    {
        try {
            $transaction = Transaction::find($id);

            if($transaction->type_transaction == 'Sparepart')
            {
                // $mechanics = $sparepart_details->reduce(function ($carry, $item) {
                //     return $item->mechanic;
                // }, []);
                $mechanics = $transaction->detail_transaction_sparepart()->first()->mechanic->name_employee;

                $motor = $transaction->detail_transaction_sparepart()->first()->motorcyclecustomer;
            }
            else{
                // $mechanics = $service_details->reduce(function ($carry, $item) {
                //     return $item->mechanic;
                // }, []);
                $mechanics = $transaction->detail_transaction_service()->first()->mechanic->name_employee;

                $motor = $transaction->detail_transaction_service()->first()->motorcyclecustomer;

            }

            $pdf = PDF::loadView('pdf.nota', compact('transaction','motor','mechanics'))->setPaper('a4', 'portrait');

            return $pdf->stream();
            // return $pdf->download($transaction->transaction_code . '.pdf');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function generateNota($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $transaction = Transaction::find($id);
            $date = Carbon::now();

            $service_details = $transaction->detail_transaction_service
                ->map(function ($item) {
                    return $item;
            });

            $sparepart_details = $transaction->detail_transaction_sparepart
                ->map(function ($item){
                    return $item;
            });

            $mechanics=[];
            $sparepartmotorcycles=[];
            $servicemotorcycles=[];
            $motorcycles=[];
            $temp = 0;

            foreach($service_details as $detail)
            {
                if($mechanics!=NULL)
                {
                    foreach($mechanics as $mechanic)
                    {
                        if($mechanic!=$detail->mechanic->name_employee)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }
                    }
                    if($temp ==1)
                    {
                        array_push($mechanics,$detail->mechanic->name_employee);
                    }
                    

                }
                else{
                    array_push($mechanics,$detail->mechanic->name_employee);
                }
            }


            foreach($sparepart_details as $detail)
            {
                if($detail->id_employee!=NULL)
                {
                    if($mechanics!=NULL)
                    {
                        foreach($mechanics as $mechanic)
                        {
                            if($mechanic!=$detail->mechanic->name_employee)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }
                            
                        }
                        if($temp ==1)
                        {
                            array_push($mechanics,$detail->mechanic->name_employee);
                        }
                    }
                    else{
                        array_push($mechanics,$detail->mechanic->name_employee);
                    }
                }
            }

            // foreach($service_details as $detail)
            // {
            //     if($motorcycles!=NULL)
            //     {
            //         foreach($motorcycles as $motorcycle)
            //         {
            //             if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
            //             {
            //                 $temp = 1;
            //             }
            //             else{
            //                 $temp = 0;
            //             }   
            //         }
            //         if($temp ==1)
            //         {
            //             array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
            //         }   
            //     }
            //     else{
            //         array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
            //     }
            // }

            foreach($service_details as $detail)
            {
                if($servicemotorcycles!=NULL)
                {
                    foreach($servicemotorcycles as $motorcycle)
                    {
                        if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }   
                    }
                    if($temp ==1)
                    {
                        array_push($servicemotorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                    }   
                }
                else{
                    array_push($servicemotorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                }
            }
            
            // foreach($sparepart_details as $detail)
            // {
            //     if($detail->id_motorcycle!=NULL)
            //     {
            //         if($motorcycles!=NULL)
            //         {
            //             foreach($motorcycles as $motorcycle)
            //             {
            //                 if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
            //                 {
            //                     $temp = 1;
            //                 }
            //                 else{
            //                     $temp = 0;
            //                 }   

            //             }
            //             if($temp ==1)
            //             {
            //                 array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
            //             }   
            //         }
            //         else{
            //             array_push($motorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
            //         }
            //     }
            // }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_motorcycle!=NULL)
                {
                    if($sparepartmotorcycles!=NULL)
                    {
                        foreach($sparepartmotorcycles as $motorcycle)
                        {
                            if($motorcycle!=$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }   

                        }
                        if($temp ==1)
                        {
                            array_push($sparepartmotorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                        }   
                    }
                    else{
                        array_push($sparepartmotorcycles,$detail->motorcyclecustomer->motorcycletype->motorcyclebrand->name_motorcycle_brand.' '.$detail->motorcyclecustomer->motorcycletype->name_motorcycle_type.' '.$detail->motorcyclecustomer->plate_number);
                    }
                }
            }
            
            
            // return $mechanics;
            // return $motorcycles;
            // return view('pdf.workOrder',compact('transaction','date'));
            // $pdf = PDF::loadView('pdf.nota2', compact('transaction','mechanics','motorcycles','date'))->setPaper('a4', 'portrait');
            $pdf = PDF::loadView('pdf.nota2', compact('transaction','mechanics','servicemotorcycles','sparepartmotorcycles','date'))->setPaper('a4', 'portrait');


            // return $pdf->download($transaction->id_transaction . '.pdf');
            return $pdf->stream();

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

 
    public function reportProfitMonthPDF($year)
    {
        // $report = DB::select("SELECT * FROM transactions");
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan, 
        COALESCE(SUM(d.subtotal_transaction_sparepart),0) AS Sparepart,
        COALESCE(SUM(e.subtotal_transaction_service),0) AS Service,
        COALESCE(SUM(d.subtotal_transaction_sparepart),0)+COALESCE(SUM(e.subtotal_transaction_service),0)  AS Total FROM (SELECT '01' AS
        bulan
        UNION SELECT '02' AS
        bulan
        UNION SELECT '03' AS
        bulan
        UNION SELECT '04' AS
        bulan
        UNION SELECT '05' AS
        bulan
        UNION SELECT '06' AS
        bulan
        UNION SELECT '07'AS
        bulan
        UNION SELECT '08'AS
        bulan
        UNION SELECT '09' AS
        bulan
        UNION SELECT '10' AS
        bulan
        UNION SELECT '11' AS
        bulan
        UNION SELECT '12' AS
        bulan
        )AS m LEFT JOIN (SELECT * FROM transactions 
        WHERE YEAR(date_transaction)=$year AND status_paid='Paid') p 
        ON MONTHNAME(p.date_transaction) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        LEFT JOIN detail_transaction_spareparts d ON p.id_transaction=d.id_transaction
        LEFT JOIN detail_transaction_services e ON p.id_transaction=e.id_transaction

        GROUP BY YEAR(p.date_transaction),m.bulan
        ORDER by m.bulan");

        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // return $report;
        $pdf = PDF::loadView('pdf.reportprofitpermonth', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        return $pdf->stream();

    }

    public function reportProfitMonthData($year)
    {
        // $report = DB::select("SELECT * FROM transactions");
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan, COALESCE(SUM(d.subtotal_transaction_sparepart),0) AS Sparepart,COALESCE(SUM(e.subtotal_transaction_service),0) AS Service,COALESCE(SUM(d.subtotal_transaction_sparepart),0)+COALESCE(SUM(e.subtotal_transaction_service),0)  AS Total FROM (SELECT '01' AS
        bulan
        UNION SELECT '02' AS
        bulan
        UNION SELECT '03' AS
        bulan
        UNION SELECT '04' AS
        bulan
        UNION SELECT '05' AS
        bulan
        UNION SELECT '06' AS
        bulan
        UNION SELECT '07'AS
        bulan
        UNION SELECT '08'AS
        bulan
        UNION SELECT '09' AS
        bulan
        UNION SELECT '10' AS
        bulan
        UNION SELECT '11' AS
        bulan
        UNION SELECT '12' AS
        bulan
        )AS m LEFT JOIN (SELECT * FROM transactions WHERE YEAR(date_transaction)=$year AND status_paid='Paid') p ON MONTHNAME(p.date_transaction) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) LEFT JOIN detail_transaction_spareparts d ON p.id_transaction=d.id_transaction
        LEFT JOIN detail_transaction_services e ON p.id_transaction=e.id_transaction

        GROUP BY YEAR(p.date_transaction),m.bulan
        ORDER by m.bulan");

        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // return $report;
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

        // $pdf = PDF::loadView('pdf.reportprofitpermonth', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        // return $pdf->stream();

    }

    public function reportSpendMonthPDF($year)
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan,  COALESCE(SUM(d.subtotal_detail_procurement),0) AS Total FROM (SELECT '01' AS
        bulan
        UNION SELECT '02' AS
        bulan
        UNION SELECT '03' AS
        bulan
        UNION SELECT '04' AS
        bulan
        UNION SELECT '05' AS
        bulan
        UNION SELECT '06' AS
        bulan
        UNION SELECT '07'AS
        bulan
        UNION SELECT '08'AS
        bulan
        UNION SELECT '09' AS
        bulan
        UNION SELECT '10' AS
        bulan
        UNION SELECT '11' AS
        bulan
        UNION SELECT '12' AS
        bulan
        )AS m LEFT JOIN (SELECT * FROM sparepart_procurements WHERE YEAR(date_procurement)=$year)as p ON MONTHNAME(p.date_procurement) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) LEFT JOIN
        detail_sparepart_procurements d ON d.id_procurement = p.id_procurement
      
        GROUP BY YEAR(p.date_procurement),m.bulan
        ORDER by m.bulan");

        // return ($report);
        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // return $report;
        $pdf = PDF::loadView('pdf.reportexpense', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    public function reportSpendMonthData($year)
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan,  COALESCE(SUM(d.subtotal_detail_procurement),0) AS Total FROM (SELECT '01' AS
        bulan
        UNION SELECT '02' AS
        bulan
        UNION SELECT '03' AS
        bulan
        UNION SELECT '04' AS
        bulan
        UNION SELECT '05' AS
        bulan
        UNION SELECT '06' AS
        bulan
        UNION SELECT '07'AS
        bulan
        UNION SELECT '08'AS
        bulan
        UNION SELECT '09' AS
        bulan
        UNION SELECT '10' AS
        bulan
        UNION SELECT '11' AS
        bulan
        UNION SELECT '12' AS
        bulan
        )AS m LEFT JOIN (SELECT * FROM sparepart_procurements WHERE YEAR(date_procurement)=$year)as p ON MONTHNAME(p.date_procurement) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) LEFT JOIN
        detail_sparepart_procurements d ON d.id_procurement = p.id_procurement
      
        GROUP BY YEAR(p.date_procurement),m.bulan
        ORDER by m.bulan");

        // return ($report);
        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // return $report;
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

        // $pdf = PDF::loadView('pdf.reportexpense', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        // return $pdf->stream();
    }
    
    public function reportProfitYearPDF()
    {
        $report = DB::select("SELECT YEAR(c.date_transaction) AS Tahun, 
        D.name_branch AS Cabang, SUM(C.total_transaction) AS Total 
        FROM employee_onduties a join employees b on b.id_employee=a.id_employee 
        JOIN transactions c on c.id_transaction=a.id_transaction
        join branches d on d.id_branch=b.id_branch
        WHERE b.id_role = 1 or b.id_role = 2
        GROUP BY YEAR(c.date_transaction),d.name_branch");
        $date = Carbon::now()->format('d F Y');
        $no = 1;
        $pdf = PDF::loadView('pdf.reportprofitperyear', compact('report','date','no'))->setPaper('a4', 'portrait');

        return $pdf->stream();
        // return $report;
    }
    public function reportProfitYearData()
    {
        $report = DB::select("SELECT YEAR(c.date_transaction) AS Tahun, 
        D.name_branch AS Cabang, SUM(C.total_transaction) AS Total 
        FROM employee_onduties a join employees b on b.id_employee=a.id_employee 
        JOIN transactions c on c.id_transaction=a.id_transaction
        join branches d on d.id_branch=b.id_branch
        WHERE b.id_role = 1 or b.id_role = 2
        GROUP BY YEAR(c.date_transaction),d.name_branch");
        // return $report;
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

    }

    public function reportTopSellSparepartPDF($year)
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan, 
        Coalesce((select s.name_sparepart from detail_transaction_spareparts t inner join spareparts s 
        on t.id_sparepart = s.id_sparepart where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by t.id_sparepart order by sum(t.amount_transaction_sparepart) DESC LIMIT 1),'') 
        AS NamaBarang, Coalesce((select tp.name_sparepart_type from detail_transaction_spareparts t 
        inner join spareparts s on t.id_sparepart = s.id_sparepart 
        inner join sparepart_types tp on s.id_sparepart_type = tp.id_sparepart_type 
        where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by t.id_sparepart order by sum(t.amount_transaction_sparepart) 
        DESC LIMIT 1),'') AS TipeBarang, Coalesce((select sum(amount_transaction_sparepart) 
        from detail_transaction_spareparts where MONTHNAME(created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by id_sparepart order by sum(amount_transaction_sparepart) DESC LIMIT 1),'') AS JumlahPenjualan
        FROM(
               SELECT '01' AS
               bulan
               UNION SELECT '02' AS
               bulan
               UNION SELECT '03' AS
               bulan
               UNION SELECT '04' AS
               bulan
               UNION SELECT '05' AS
               bulan
               UNION SELECT '06' AS
               bulan
               UNION SELECT '07'AS
               bulan
               UNION SELECT '08'AS
               bulan
               UNION SELECT '09' AS
               bulan
               UNION SELECT '10' AS
               bulan
               UNION SELECT '11' AS
               bulan
               UNION SELECT '12' AS
               bulan
        ) AS m");
        // return ($report);
        $date = Carbon::now()->format('d F Y');
        $no = 1;
       
       
        $pdf = PDF::loadView('pdf.sparepartTopSell', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        return $pdf->stream();

    }
    public function reportTopSellSparepartData($year)
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan, 
        Coalesce((select s.name_sparepart from detail_transaction_spareparts t inner join spareparts s 
        on t.id_sparepart = s.id_sparepart where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by t.id_sparepart order by sum(t.amount_transaction_sparepart) DESC LIMIT 1),'') 
        AS NamaBarang, Coalesce((select tp.name_sparepart_type from detail_transaction_spareparts t 
        inner join spareparts s on t.id_sparepart = s.id_sparepart 
        inner join sparepart_types tp on s.id_sparepart_type = tp.id_sparepart_type 
        where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by t.id_sparepart order by sum(t.amount_transaction_sparepart) 
        DESC LIMIT 1),'') AS TipeBarang, Coalesce((select sum(amount_transaction_sparepart) 
        from detail_transaction_spareparts where MONTHNAME(created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) 
        group by id_sparepart order by sum(amount_transaction_sparepart) DESC LIMIT 1),'') AS JumlahPenjualan
        FROM(
               SELECT '01' AS
               bulan
               UNION SELECT '02' AS
               bulan
               UNION SELECT '03' AS
               bulan
               UNION SELECT '04' AS
               bulan
               UNION SELECT '05' AS
               bulan
               UNION SELECT '06' AS
               bulan
               UNION SELECT '07'AS
               bulan
               UNION SELECT '08'AS
               bulan
               UNION SELECT '09' AS
               bulan
               UNION SELECT '10' AS
               bulan
               UNION SELECT '11' AS
               bulan
               UNION SELECT '12' AS
               bulan
        ) AS m");
        // return $report;
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

        $date = Carbon::now()->format('d F Y');
        $no = 1;
       
       
        // $pdf = PDF::loadView('pdf.sparepartTopSell', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        // return $pdf->stream();

    }

    public function reportTopSellServicePDF($year,$month)
    {
        $report = DB::select("SELECT motorcycle_brands.name_motorcycle_brand, motorcycle_types.name_motorcycle_type, services.name_service, sum(detail_transaction_services.amount_transaction_service)as jumlah_jasa
        FROM detail_transaction_services
        LEFT JOIN motorcycle_customers on detail_transaction_services.id_motorcycle = motorcycle_customers.id_motorcycle
        JOIN motorcycle_types ON motorcycle_customers.id_motorcycle_type = motorcycle_types.id_motorcycle_type
        JOIN motorcycle_brands ON motorcycle_types.id_motorcycle_brand = motorcycle_brands.id_motorcycle_brand
        LEFT JOIN services ON detail_transaction_services.id_service = services.id_service
        LEFT JOIN transactions ON detail_transaction_services.id_transaction = transactions.id_transaction
        WHERE YEAR(transactions.date_transaction) = $year
        AND Month(transactions.date_transaction) = $month
        AND transactions.status_paid = 'Paid'
        GROUP BY detail_transaction_services.id_service, motorcycle_customers.id_motorcycle
        ORDER BY motorcycle_customers.id_motorcycle");
        // return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // $year =2018;
       
        // return $report;
        $monthName = date("F", mktime(0, 0, 0, $month, 1));
        $pdf = PDF::loadView('pdf.serviceTopSell', compact('report', 'no', 'date', 'year','monthName'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function reportTopSellServiceData($year,$month)
    {
        $report = DB::select("SELECT motorcycle_brands.name_motorcycle_brand, motorcycle_types.name_motorcycle_type, services.name_service, sum(detail_transaction_services.amount_transaction_service)as jumlah_jasa
        FROM detail_transaction_services
        LEFT JOIN motorcycle_customers on detail_transaction_services.id_motorcycle = motorcycle_customers.id_motorcycle
        JOIN motorcycle_types ON motorcycle_customers.id_motorcycle_type = motorcycle_types.id_motorcycle_type
        JOIN motorcycle_brands ON motorcycle_types.id_motorcycle_brand = motorcycle_brands.id_motorcycle_brand
        LEFT JOIN services ON detail_transaction_services.id_service = services.id_service
        LEFT JOIN transactions ON detail_transaction_services.id_transaction = transactions.id_transaction
        WHERE YEAR(transactions.date_transaction) = $year
        AND Month(transactions.date_transaction) = $month
        AND transactions.status_paid = 'Paid'
        GROUP BY detail_transaction_services.id_service, motorcycle_customers.id_motorcycle
        ORDER BY motorcycle_customers.id_motorcycle");
        // return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
        $date = Carbon::now()->format('d F Y');
        $no = 1;
        // $year =2018;
       
        // return $report;
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

        // $pdf = PDF::loadView('pdf.sparepartTopSell', compact('report','year','date','no'))->setPaper('a4', 'portrait');

        // return $pdf->stream();
    }

    public function reportStockSparepartPDF($year,$sparepart)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as 'Bulan', COALESCE((select (
                (select stock_sparepart + (select sum(amount_transaction_sparepart) from detail_transaction_spareparts join spareparts on detail_transaction_spareparts.id_sparepart=spareparts.id_sparepart
                where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM detail_transaction_spareparts.created_at) = $year)
                 - (select sum(amount_detail_procurement) from detail_sparepart_procurements join spareparts on detail_sparepart_procurements.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM detail_sparepart_procurements.created_at) = $year) from spareparts where id_sparepart_type = '$sparepart')
                 - (select sum(amount_transaction_sparepart) from detail_transaction_spareparts join spareparts on detail_transaction_spareparts.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM detail_transaction_spareparts.created_at) = bulan) 
                + (select sum(amount_detail_procurement) from detail_sparepart_procurements join spareparts on detail_sparepart_procurements.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM detail_sparepart_procurements.created_at) = bulan))  AS 'Jumlah Sparepart Sisa' 
                from spareparts where id_sparepart_type = '$sparepart'),'0') AS 'JumlahStokSisa'
                 FROM(
                SELECT '01' AS
                        bulan
                        UNION SELECT '02' AS
                        bulan
                        UNION SELECT '03' AS
                        bulan
                        UNION SELECT '04' AS
                        bulan
                        UNION SELECT '05' AS
                        bulan
                        UNION SELECT '06' AS
                        bulan
                        UNION SELECT '07'AS
                        bulan
                        UNION SELECT '08'AS
                        bulan
                        UNION SELECT '09' AS
                        bulan
                        UNION SELECT '10' AS
                        bulan
                        UNION SELECT '11' AS
                        bulan
                        UNION SELECT '12' AS
                        bulan
                    ) AS m");
            $type= SparepartType::find($sparepart)->first();
            $type = $type->name_sparepart_type;
            // echo $procurement->date;
            $date = Carbon::now()->format('d F Y');
            $no = 1;
            $pdf = PDF::loadView('pdf.reportstocksparepart', compact('report', 'no', 'date', 'year', 'type'))->setPaper('a4', 'portrait');
            return $pdf->stream();
    
            // return $pdf->download('REMAININGSTOCK_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function reportStockSparepartData($year,$sparepart)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as 'Bulan', COALESCE((select (
                (select stock_sparepart + (select sum(amount_transaction_sparepart) from detail_transaction_spareparts join spareparts on detail_transaction_spareparts.id_sparepart=spareparts.id_sparepart
                where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM detail_transaction_spareparts.created_at) = $year)
                 - (select sum(amount_detail_procurement) from detail_sparepart_procurements join spareparts on detail_sparepart_procurements.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM detail_sparepart_procurements.created_at) = $year) from spareparts where id_sparepart_type = '$sparepart')
                 - (select sum(amount_transaction_sparepart) from detail_transaction_spareparts join spareparts on detail_transaction_spareparts.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM detail_transaction_spareparts.created_at) = bulan) 
                + (select sum(amount_detail_procurement) from detail_sparepart_procurements join spareparts on detail_sparepart_procurements.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM detail_sparepart_procurements.created_at) = bulan))  AS 'Jumlah Sparepart Sisa' 
                from spareparts where id_sparepart_type = '$sparepart'),'0') AS 'JumlahStokSisa'
                 FROM(
                SELECT '01' AS
                        bulan
                        UNION SELECT '02' AS
                        bulan
                        UNION SELECT '03' AS
                        bulan
                        UNION SELECT '04' AS
                        bulan
                        UNION SELECT '05' AS
                        bulan
                        UNION SELECT '06' AS
                        bulan
                        UNION SELECT '07'AS
                        bulan
                        UNION SELECT '08'AS
                        bulan
                        UNION SELECT '09' AS
                        bulan
                        UNION SELECT '10' AS
                        bulan
                        UNION SELECT '11' AS
                        bulan
                        UNION SELECT '12' AS
                        bulan
                    ) AS m");
            $type= SparepartType::find($sparepart);
            $type = $type->name_sparepart_type;
            // echo $procurement->date;
            $date = Carbon::now()->format('d F Y');
            $no = 1;

            // return $report;
            return response()->json($report, 200, [], JSON_NUMERIC_CHECK);

            // return $type;
            // $pdf = PDF::loadView('pdf.remainingStock', compact('report', 'no', 'date', 'year', 'type'))->setPaper('a4', 'portrait');
            // return $pdf->stream();
    
            // return $pdf->download('REMAININGSTOCK_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

}
