<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataCPdetail->id_payment}} </title>
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
    <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
    body { margin: 0; padding: 0; background: #e1e1e1; }
    div, p, a, li, td { -webkit-text-size-adjust: none; }
    .ReadMsgBody { width: 100%; background-color: #ffffff; }
    .ExternalClass { width: 100%; background-color: #ffffff; }
    body { width: 100%; height: 100%; background-color: #e1e1e1; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
    html { width: 100%; }
    p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
    .visibleMobile { display: none; }
    .hiddenMobile { display: block; }

    @media only screen and (max-width: 600px) {
    body { width: auto !important; }
    table[class=fullTable] { width: 96% !important; clear: both; }
    table[class=fullPadding] { width: 85% !important; clear: both; }
    table[class=col] { width: 45% !important; }
    .erase { display: none; }
    }

    @media only screen and (max-width: 420px) {
    table[class=fullTable] { width: 100% !important; clear: both; }
    table[class=fullPadding] { width: 85% !important; clear: both; }
    table[class=col] { width: 100% !important; clear: both; }
    table[class=col] td { text-align: left !important; }
    .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
    .visibleMobile { display: block !important; }
    .hiddenMobile { display: none !important; }
    }
    </style>
     <!-- style -->
     <link rel="stylesheet" href="/resources/css/mystyle.css">
     <!-- Fonts -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
     
     <!-- Styles -->
     @livewireStyles
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.jqueryui.min.css">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <style>
       @media print {
            .header {
                width: 100%;
            }

            body {
                -webkit-print-color-adjust: exact;
            }

            .footer2 {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: right; /* Untuk memposisikan teks di tengah-tengah */
            }

            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: left; /* Untuk memposisikan teks di tengah-tengah */
            }

            .footer2::after {
                content: counter(page) ' / ' counter(pages);
            }
        }

        .bg-gray-5002 {
        background-color: #ccc !important;
        color: black !important;   
        }
        .bg-companys {
        background-color: #000 !important;
        color: white !important;   
        }

        .table-row2 {
            display: table-row;
        }
        .table-cell2 {
            display: table-cell;
            padding: 2px 5px;
        }
        .text-xs2 {
            font-size: 12px; /* Sesuaikan dengan ukuran teks yang sesuai */
        }
        .font-bold2 {
            font-weight: bold;
        }
        .td1 {
            height: 100px;
        }
       
        .border-black {
            border: 2px solid black; /* Mengatur border menjadi 2px tebal dan berwarna hitam */
        }
        
        td.remarks {
            max-width: 120px;
        }
        table.table-bordered {
            border-collapse: collapse; /* Menggabungkan garis tepi */
            border: 1px solid black; /* Lebar border utama tabel */
        }

        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid black; /* Lebar border untuk sel header dan sel data */
            padding: 4px 8px; /* Atur padding agar teks tidak terlalu dekat dengan border */
        }

        /* CSS untuk mengatur font size pada thead dan tbody */
        table.table-bordered thead th {
            font-size: 10px; /* Font size untuk header */
        }

        table.table-bordered tbody td {
            font-size: 9px; /* Font size untuk sel data */
        }
         /* Chrome, Safari, Edge, Opera */
         input::-webkit-outer-spin-button,
         input::-webkit-inner-spin-button {
         -webkit-appearance: none;
         margin: 0;
         }
         .pointer {cursor: pointer;}
     </style>
</head>
<body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
        <thead>
            <tr>
                <td>
                    <!-- Header -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                        <tr>
                        <td>
                            <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                            {{-- <tr class="hiddenMobile">
                                <td height="40"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="30"></td>
                            </tr> --}}
                    
                            <tr>
                                <td>
                                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <table width="150" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif;">
                                                <tbody>
                                                    <tr>
                                                            <td class="flex justify-end {{ strlen($dataCPdetail->address) > 50 ? 'mr-3' : '' }}">
                                                                @if ($dataCPdetail->logo_filename != null)
                                                                <img src="http://ayoda.integrated-os.cloud/{{$dataCPdetail->logo_filename}}" width="100" height="50" alt="companyLogo">
                                                                @else
                                                                <img src="{{ asset('images/Logo.png') }}" width="100" height="50" alt="companyLogo">
                                                                @endif
                                                            </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif;">
                                                <tbody>
                                                <tr>
                                                    <div class="text-xs font-medium mb-1" style="font-size: 20px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataCPdetail->company_type}}.&nbsp; {{$dataCPdetail->companyName}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-size: 15px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataCPdetail->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataCPdetail->address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                <tbody><tr></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="page">
                        <p>
                            <!-- /Header -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="10"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <div class="text-xs text-black font-bold mb-2 border-black bg-gray-5002" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; letter-spacing: -1px; line-height: 2; vertical-align: top; text-align: center;">
                                                        PAYMENT VOUCHER
                                                    </div>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <tr class="hiddenMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="10"></td>
                                        </tr>
                                    <tr>
                                        <td>
                                            <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right">
                                                                            <!-- Tambahkan tabel di sini -->
                                                                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                                                                <tbody>
                                                                                    <div class="table-container2 justify-end" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                        <div class="table-row2">
                                                                                            <div class="table-cell2 text-xs2 font-bold2">Payment Voucher #</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                                                {{$dataCPdetail->id_payment}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                            <div class="table-cell2 text-xs2 font-bold2">Payment Voucher Date</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                                                {{date('d F Y', strtotime($dataCPdetail->date))}}
                                                                                            </div>
                                                                                        </div>
                                                                                        @if ($dataCPdetail->companyId == null && $dataCPdetail->payee_bank == null && $dataCPdetail->payee_number == null)
                                                                                            <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                                <div class="table-cell2 text-xs2 font-bold2">Paid By</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                                                    Cash
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($dataCPdetail->companyId != null)
                                                                                            <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                                <div class="table-cell2 text-xs2 font-bold2">Bank CID</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                                                    {{$dataCPdetail->companyId}}
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($dataCPdetail->payee_bank != null)
                                                                                            <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                                <div class="table-cell2 text-xs2 font-bold2">Bank Company</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                                                    {{$dataCPdetail->payee_bank}}
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($dataCPdetail->payee_number != null)
                                                                                            <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                                <div class="table-cell2 text-xs2 font-bold2">Bank Account</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                                                    {{$dataCPdetail->payee_number}}
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                            <div class="table-cell2 text-xs2 font-bold2">Scheduled Payment Date</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                                                {{date('d F Y', strtotime($dataCPdetail->payment_date))}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                                            <div class="table-cell2 text-xs2 font-bold2">Bank Date</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px;">:</div>
                                                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                                                ............................
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- Akhir tabel -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <tr class="hiddenMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="10"></td>
                                        </tr>
                                    <tr>
                                </tbody>
                            </table>    
                            <!-- Order Details -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="10"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-10" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; border-radius: 0 0 5px 5px; border-collapse: collapse; border-width: 1px; border-color: black;"> 
                                                        <thead style="font-family: Arial, Helvetica, sans-serif;">
                                                            <tr class="font-bold text-black bg-gray-5002">
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 7px;">REFF #</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 78px;">REFF DATE</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 250px;">DESCRIPTION</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 150px;">AMOUNT</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">PREVIOUS PAYMENT</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">AMOUNT PAID</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-family: Arial, Helvetica, sans-serif;">
                                                            {{-- <tr>
                                                                <td class="text-sm text-left" style="font-size: 10px;">{{$dataCPdetail->id_costpayment}}</td>
                                                                <td class="text-sm text-right" style="font-size: 10px;">{{date('d F y', strtotime($dataCPdetail->dateForm))}}</td>
                                                                <td class="text-sm text-left" style="font-size: 10px;">{{$dataCPdetail->remarks}}</td>
                                                                <td class="text-sm text-right" style="font-size: 10px;">{{number_format($dataCPdetail->beforeRounding, 0, ',', '.')}}</td>
                                                                <td class="text-sm text-right" style="font-size: 10px;">{{number_format($dataCPdetail->previous_payment, 0, ',', '.')}}</td>
                                                                <td class="text-sm text-right" style="font-size: 10px;">{{number_format($dataCPdetail->beforeRounding, 0, ',', '.')}}</td>
                                                            </tr> --}}
                                                            @foreach ($dataCPdetail1 as $items)
                                                                <tr>
                                                                    <td class="text-sm text-left" style="font-size: 10px;">{{$items->id_costpayment}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 10px;">{{date('d F y', strtotime($items->dateForm))}}</td>
                                                                    <td class="text-sm text-left" style="font-size: 10px;">{{$items->remarks}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 10px;">{{number_format($items->amount_paid, 0, ',', '.')}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 10px;">{{number_format($items->previous_payment, 0, ',', '.')}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 10px;">{{number_format($items->amount_paid, 0, ',', '.')}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">SUBTOTAL</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($mathPayment->mounts, 0, ',', '.')}}</td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">ROUNDING</td>
                                                                @if ($dataCPdetail->rounding > 0)
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} +{{number_format($dataCPdetail->rounding, 0, ',', '.')}}</td>
                                                                @else
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($dataCPdetail->rounding, 0, ',', '.')}}</td>
                                                                @endif
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">BANK CHARGE</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($dataCPdetail->bank_charge, 0, ',', '.')}}</td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">DUTY STAMP CHARGE</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($dataCPdetail->duty_stamp_charge, 0, ',', '.')}}</td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">OTHER CHARGE</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($dataCPdetail->other_charge, 0, ',', '.')}}</td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="5">TOTAL</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;" colspan="2">{{$dataCPdetail->currency}} {{number_format($totalsAmount, 0, ',', '.')}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="margin-bottom: 2rem;">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="3"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="3"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <div class="table-container2">
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2 text-red-500">Pay To:</div>
                                                        </div>
                                                        <div class="table-row2" style="font-family: Arial, Helvetica, sans-serif;">
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">Beneficiary</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; text-indent: 20px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                @if ($dataCPdetail->beneficiary_bank != 'Cash')
                                                                {{$dataCPdetail->beneficiary_name}}
                                                                @else
                                                                {{$dataCPdetail->beneficiary_name}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">Bank Beneficiary</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; text-indent: 20px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                @if ($dataCPdetail->beneficiary_bank == '' || $dataCPdetail->beneficiary_bank == null || $dataCPdetail->beneficiary_bank == ' ')
                                                                    -
                                                                @else
                                                                    {{$dataCPdetail->beneficiary_bank}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($dataCPdetail->beneficiary_bank != 'Cash')
                                                            <div class="table-row2">
                                                                <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">Bank Account</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; text-indent: 20px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif;">
                                                                    {{$dataCPdetail->beneficiary_acc}}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <!-- /Total -->
                            <!-- Information -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="5"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="5"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- /Information -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff">
                            
                                <tr>
                                <td>
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                    <tbody>
                                                        <tr class="font-bold bg-gray-5002">
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Prepared By:
                                                            </td>
                                                            {{-- <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Checked By:
                                                            </td> --}}
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Approved By:
                                                            </td>
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Released By:
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="td1 text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;"></td>
                                                            {{-- Not Required, Printed Automatically by System --}}
                                                            <td colspan="2" class="text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;"></td>
                                                            <td colspan="2" class="text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;"></td>
                                                        </tr>
                                                        <tr class="font-bold">
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                @if (is_numeric($dataCPdetail->created_by))
                                                                {{$dataCPdetail->username}}
                                                                @else
                                                                {{$dataCPdetail->created_by}}
                                                                @endif
                                                            </td>
                                                            {{-- <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                {{$dataCPdetail->checked_by}}
                                                            </td> --}}
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                {{$dataCPdetail->approved_by}}
                                                            </td>
                                                            <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                {{$dataCPdetail->released_by}}
                                                            </td>
                                                        </tr>
                                                        <tr class="mb-5 font-bold">
                                                            <td class="text-center" style="font-size: 10px; font-family: 'Arial'; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Date:
                                                            </td>
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                {{date('d F Y', strtotime($dataCPdetail->date))}}
                                                            </td>
                                                            {{-- <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Date:
                                                            </td>
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                
                                                            </td> --}}
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Date:
                                                            </td>
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">

                                                            </td>
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                Date:
                                                            </td>
                                                            <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 129px;">
                                                                    
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="spacer">
                                            <td height="20"></td>
                                        </tr>
                                    </table>
                                </td>
                                </tr>
                                <tr>
                                </tr>
                            </table>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="hiddenMobile">
                @if ($dataCPdetail1Count >= 50)
                    <td height="90"></td>
                @else
                    <td height="30"></td>
                @endif
            </tr>
            <tr class="visibleMobile">
                <td height="10"></td>
            </tr>
            <tr>
                <td>
                    {{-- <div class="flex flex-row justify-between">
                        <div class="footer">
                            <p>{{date('Y-m-d H:i:s')}}</p>
                        </div>
                        <div class="footer2">
                            <p> </p>
                        </div>
                    </div> --}}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<script>
    <?php if ($dataCPdetail->aktifyn != 'P'): ?>
        window.print();
    <?php endif; ?>
</script>