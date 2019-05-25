<!DOCTYPE html>
<html>
<head>
    <!-- <title>SP-TESTED-01</title> -->
    <title>{{ $transaction->id_transaction }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<style>
	.container {
		width: 600px;
		margin: 0 auto;
		padding: 5px 10px;
        /* font-size: 14px; */
	}

    .text-xs-center {
        text-align: center;
    }

	.header-section .image {
		float: left;
        height: 125px;
	}

	.header-section .title {
		text-align: center;
		line-height: 20px;
	}

	.description-section h3 {
		text-align: center;
	}

	.description-section .date-section {
		float: right;
	}

	.description-section .date-section tbody tr {
		text-align: left;
	}

    .general-section {
        width: 100%;
    }

    .general-section .box {
        width: 100%;
        text-align: left;
    }

	.table-section table {
		width: 100%;
		text-align: left;
		border: 1px solid black;
		border-collapse: collapse;
	}

	.table-section table thead tr th {
		border: 1px solid black;
	}

	.table-section table tbody tr td {
		border: 1px solid black;
	}

    .sparepart-details {
        width: 100%;
        text-align: left;
        /* table-layout: fixed; */
        
    }

    .sparepart-details tbody tr {
        width: 100%;
    }

    .service-details {
        width: 100%;
        text-align: left;
    }

    .service-details tbody tr {
        width: 100%;
    }
    .sub-title{
        font-weight: bold !important;
    }
    .border_bottom_upper{
        border-bottom:1pt solid black;
        border-top:1pt solid black;
        
    }
    .col-1{
        width: 20%;
    }
    .col-2{
        width: 20%;
    }
    .col-3{
        width: 20%;
    }
    .col-4{
        width: 15%;
    }
    .col-5{
        width: 8%;
    }
    .col-6{
        width: 17%;
    }
   
	</style>
</head>
<body>
	<div class="container">
		<div class="header-section">
			<div class="image">
				<img src="https://s3.us-east-2.amazonaws.com/pilatix-api-clubs/AtmaAutoLogo.png" alt="">
			</div>
			<div class="title">
				<div><h1>ATMA AUTO</h1></div>
				<div>MOTORCYCLE SPAREPARTS AND SERVICES</div>
				<div>
					Jl. Babarsari No.43 Yogyakarta 552181 <br>
					Telp. (0274) 487711 <br>
					http://www.atmaauto.com
				</div>
			</div>
		</div>

        <hr>
        <div class="text-xs-center sub-title">
            NOTA LUNAS 
        </div>
        <hr>
        
		<div class="description-section">
			<div class="date-section">
                <!-- <div>24-01-19 10:55</div> -->
                <div>{{ date('d-m-Y H:i', strtotime($transaction->date_transaction)) }}</div>
			</div>
        </div>
        
        <div>
            <!-- <h3>SS-240119-141</h3> -->
            <h3>{{ $transaction->id_transaction }}</h3>

        </div>

        <div class="general-section">
            <table class="box">
                <tbody>
                    <tr>
                        <th>Cust</th>
                        <!-- <td>Stefanus Rojali</td> -->
                        <td>{{ $transaction->customer->name_customer }}</td>
                        <td style="width:30%;"></td>

                        <th>CS</th>
                        <!-- <td>Natalia Ramona</td> -->
                        @foreach ($transaction->employee as $item)
                            @if ($item->id_role === 2)
                                <td>{{ $item->name_employee }}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <!-- <td>081801234567</td> -->
                        <td>{{ $transaction->customer->phone_number_customer }}</td>
                        <td style="width:30%;"></td>

                        <th>Montir</th>
                        <!-- <td>Fatir Kamil</td> -->
                        <td>
                            {{ 
                                $mechanics
                            }}
                        </td>
                        

                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <hr>
        <div class="text-xs-center sub-title">
            SPAREPART   
        </div>
        <hr>
        <br>                       
        <div>
            <table class="sparepart-details border_bottom_upper">
                <thead>
                    <tr >
                        <th class="col-1">Kode</th>
                        <th class="col-2">Nama</th>
                        <th class="col-3">Merk</th>
                        <th style="text-align:left;" class="col-4">Harga</th>
                        <th style="text-align:right;" class="col-5">Jumlah</th>
                        <th style="text-align:right;" class="col-6">Subtotal</th>

                    </tr>
                </thead>
                <tbody>
                   
                    <!-- <tr>
                        <td>1111-KTM-809</td>
                        <td>Ger Rantai Set</td>
                        <td>Astra Honda Motor</td>
                        <td style="text-align:right;">Rp. 50000</td>
                        <td style="text-align:right;">2</td>
                        <td style="text-align:right;">Rp. 10000000</td>

                    </tr> -->

                    @foreach ($transaction->detail_transaction_sparepart as $item)
                        <tr>
                            <td>{{ $item->id_sparepart }}</td>
                            <td>{{ $item->sparepart->name_sparepart }}</td>
                            <td>{{ $item->sparepart->brand_sparepart }}</td>
                            <td style="text-align:right;">Rp. {{ $item->sparepart->sell_price }}</td>
                            <td style="text-align:right;">{{ $item->amount_transaction_sparepart }}</td>
                            <td style="text-align:right;">Rp. {{ $item->subtotal_transaction_sparepart}}</td>
     
                        </tr>
                    @endforeach
              
                </tbody>
            </table>
        </div>
        <div>
                <table class="sparepart-details border_bottom_upper">
                        <thead>
                            <tr >
                                <th class="col-1"></th>
                                <th class="col-2"></th>
                                <th class="col-3"></th>
                                <th class="col-4"></th>
                                <th class="col-5"></th>
                                <th class="col-6"></th>
        
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <!-- <td style="text-align:right;">Rp. 100000</td> -->
                                <td style="text-align:right;">{{$transaction->detail_transaction_sparepart->sum('subtotal_transaction_sparepart')}}</td>

                                
                            </tr>
                      
                        </tbody>
                    </table>
        </div>

        <hr>
        <div class="text-xs-center sub-title">
            SERVICE
        </div>
        <hr>
        <div>
                <table>
                    <tbody>
                        <tr>
                            <!-- <td>Honda Supra X 125 AB2345BA</td> -->
                            
                            <td>
                                {{ 
                                    $motor->motorcycletype->motorcyclebrand->name_motorcycle_brand . ' ' .
                                    $motor->motorcycletype->name_motorcycle_type . ' ' .
                                    $motor->plate_number
                                }}
                            </td>
                        </tr>
                        <!-- <tr>
                                <td>Honda Supra X 125 AB2345BA</td>
                        </tr> -->
                      
                    </tbody>
                </table>
            </div>
        <br>                    
        <div>
            <table class="service-details border_bottom_upper">
                <thead>
                    <tr>
                        <th class="col-1">Kode</th>
                        <th class="col-2">Nama</th>
                        <th class="col-3"></th>
                        <th style="text-align:left;" class="col-4">Harga</th>
                        <th style="text-align:right;" class="col-5">Jumlah</th>
                        <th style="text-align:right;" class="col-6">Subtotal</th>
 
                    </tr>
                </thead>
                <tbody>
                   
                    <!-- <tr> -->
                        <!-- <td>003</td>
                        <td>Service Roda</td>
                        <td></td>
                        <td style="text-align:right;">Rp. 50000</td>
                        <td style="text-align:right;">1</td>
                        <td style="text-align:right;">Rp. 50000</td>
                    </tr> -->
                    @foreach ($transaction->detail_transaction_service as $item)
                        <tr>
                            <td>{{ $item->id_service }}</td>
                            <td>{{ $item->service->name_service }}</td>
                            <td></td>
                            <td style="text-align:right;">Rp. {{ $item->service->price_service }}</td>
                            <td style="text-align:right;">{{ $item->amount_transaction_service }}</td>
                            <td style="text-align:right;">Rp. {{ $item->subtotal_transaction_service}}</td>
                           
                        </tr>
                    @endforeach
           
                </tbody>
            </table>
        </div>
        <div>
            <table class="service-details border_bottom_upper">
                <thead>
                    <tr>
                            <th class="col-1"></th>
                            <th class="col-2"></th>
                            <th class="col-3"></th>
                            <th class="col-4"></th>
                            <th class="col-5"></th>
                            <th class="col-6"></th>
    
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!-- <td style="text-align:right;">Rp. 50000</td> -->
                        <td style="text-align:right;">{{$transaction->detail_transaction_service->sum('subtotal_transaction_service')}}</td>

                    </tr>
            
                </tbody>
            </table>
        </div>
        <br>
        <div>
            <table class="service-details">
                <thead>
                    <tr>
                            <th class="col-1"></th>
                            <th class="col-2"></th>
                            <th class="col-3"></th>
                            <th class="col-4"></th>
                            <th class="col-5"></th>
                            <th class="col-6"></th>
    
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>Cust</td>
                        <td></td>
                        <td>Kasir</td>
                        <td></td>
                        <td style="text-align:left;">Subtotal</td>
                        <!-- <td style="text-align:right;">Rp. 50000</td> -->
                        <td style="text-align:right;">
                        {{
                            $transaction->detail_transaction_sparepart->sum('subtotal_transaction_sparepart') +
                            $transaction->detail_transaction_service->sum('subtotal_transaction_service') 
                        }}
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:left;">Diskon</td>
                        <!-- <td style="text-align:right;">Rp. 50000</td> -->
                        <td style="text-align:right;">{{ $transaction->discount_transaction}}</td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:left;">TOTAL</td>
                        <!-- <td style="text-align:right; font-weight: bold; font-size: 18px;">Rp. 5000000</td> -->
                        <td style="text-align:right; font-weight: bold; font-size: 18px;">
                        {{
                            ($transaction->detail_transaction_sparepart->sum('subtotal_transaction_sparepart') 
                            +
                            $transaction->detail_transaction_service->sum('subtotal_transaction_service') ) 
                            - 
                            $transaction->discount_transaction
                        }}
                        </td>

                    </tr>
                    <tr>
                        <!-- <td>(Stefanus Rojali)</td> -->
                        <td>({{$transaction->customer->name_customer}})</td>

                        <td></td>
                        <!-- <td>(Thoriq)</td> -->
                        @foreach ($transaction->employee as $item)
                            @if ($item->id_role === 3)
                                <td>({{ $item->name_employee }})</td>
                            @endif
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <!-- @foreach ($transaction->detail_transaction_service as $item)
                        <tr>
                            <td>{{ $item->id_service }}</td>
                            <td>{{ $item->service->name_service }}</td>
                            <td>{{ $item->amount_transaction_service }}</td>
                        </tr>
                    @endforeach -->
            
                </tbody>
            </table>
        </div>
	</div>
</body>
</html>