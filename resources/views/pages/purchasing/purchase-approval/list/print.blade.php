<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataPR->companyName}} </title>
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
            .table-responsive {
                overflow: visible !important; /* Hilangkan overflow */
                height: auto !important; /* Setel tinggi agar sesuai dengan konten */
            }
           .fullTable {
                width: 100% !important; /* Pastikan tabel menggunakan 100% dari lebar halaman cetak */
            }
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
                    <table class="header" width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                        <tr>
                        <td>
                            <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                            <tr class="hiddenMobile">
                                <td height="40"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="30"></td>
                            </tr>
                    
                            <tr>
                                <td>
                                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <table width="150" border="0" cellpadding="0" cellspacing="0" align="left" class="col" >
                                                <tbody>
                                                    <tr>
                                                            <td class="flex justify-end {{ strlen($dataPR->address) > 50 ? 'mr-3' : '' }}">
                                                                @if ($dataPR->logo_filename != null)
                                                                <img src="http://ayoda.integrated-os.cloud/{{$dataPR->logo_filename}}" width="100" height="50" alt="companyLogo">
                                                                @else
                                                                <img src="{{ asset('images/Logo.png') }}" width="100" height="50" alt="companyLogo">
                                                                @endif
                                                            </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                <tbody>
                                                <tr>
                                                    <div class="text-xs font-medium mb-1" style="font-size: 20px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataPR->company_type}}.&nbsp; {{$dataPR->companyName}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-size: 14px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataPR->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataPR->delivery_address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                <tbody><tr></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr class="hiddenMobile">
                                <td height="30"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="10"></td>
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
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <div class="text-xs text-black font-bold mb-2 border-black bg-gray-5002" style="font-size: 15px; letter-spacing: -1px; line-height: 2; vertical-align: top; text-align: center;">
                                                        PURCHASE REQUEST
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
                                    <td>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                                                    <div class="table-container2">
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2">No. PR</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 34px;">&nbsp; :</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataPR->idreqform}}
                                                            </div>
                                                        </div>
                                                        <div class="table-row">
                                                            <div class="table-cell2 text-xs2 font-bold2">PR TITLE</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 30px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataPR->pr_title}}
                                                            </div>
                                                        </div>
                                                        <div class="table-row">
                                                            <div class="table-cell2 text-xs2 font-bold2">PR Date</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 34px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{ date('d F Y', strtotime($dataPR->pr_date)) }}
                                                            </div>
                                                        </div>
                                                        <div class="table-row">
                                                            <div class="table-cell2 text-xs2 font-bold2">Department</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataPR->departmentName}}
                                                            </div>
                                                        </div>
                                                        @if ($dataPR->id_rab != null)
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">No. RAB</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 32px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataPR->id_rab}}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">No. RAB</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 32px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                -
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($dataPR->id_rab != null)
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">RAB</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 55px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataPR->name_rab}}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">RAB</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 55px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                -
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($dataPR->rab_date != null)
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">RAB Period</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 15px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                    {{ date('F Y', strtotime($dataPR->rab_date)) }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="table-row">
                                                                <div class="table-cell2 text-xs2 font-bold2">RAB Period</div>
                                                                <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 15px;">:</div>
                                                                <div class="table-cell2 text-xs2 font-bold2">
                                                                    -
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="table-row2 table-stripped">
                                                            <div class="table-cell2 text-xs2 font-bold2">Total</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 51px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2 bg-gray-5002">
                                                                RP&emsp; &emsp;{{number_format($dataPR->gtotal, 0, '.', '.')}}
                                                            </div>
                                                        </div>
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
                            <!-- Order Details -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="798" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table class="table table-bordered mb-10" style="font-size: 10px; border-radius: 0 0 5px 5px; border-collapse: collapse; border-width: 1px; border-color: black;"> 
                                                        <thead>
                                                            <tr class="font-bold text-black bg-gray-5002">
                                                                <th class="text-sm text-center" style="font-size: 10px;" colspan="3">DESCRIPTION</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 30px;">QTY</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 30px;">UNIT</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 10px;"></th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 50px;">PRICE</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">TOTAL</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">REMARKS</th>
                                                                {{-- <th class="text-sm text-center" style="font-size: 10px;">Nama & No Kontak Vendor</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="8"></td>
                                                            </tr>
                                                            @php
                                                            $itemIndex = 1;
                                                            $rowSpan = count($PRDetail); // Set rowspan based on the total number of rows
                                                            @endphp
                                                            @foreach ($PRDetail as $item)
                                                                <tr>
                                                                    @if($itemIndex === 1) {{-- Only add rowspan for the first row --}}
                                                                        <td rowspan="{{ $rowSpan }}"></td>
                                                                    @endif
                                                                    <td class="text-sm text-center" style="font-size: 9px;">{{ $itemIndex }}</td>
                                                                    <td class="text-sm text-left" style="font-size: 9px;">{{ $item->name_rab_detail }}</td>
                                                                    <td class="text-sm text-center" style="font-size: 9px;">{{number_format($item->qty, 0, '.', '.')}}</td>
                                                                    <td class="text-sm text-center" style="font-size: 9px;">{{$item->unit}}</td>
                                                                    <td class="text-sm text-center" style="font-size: 9px;">{{$dataPR->currency}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 9px;">{{number_format($item->price, 0, '.', '.')}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 9px;" id="total">{{number_format($item->total, 0, '.', '.')}}</td>
                                                                    @if ($item->remarks == null || $item->remarks == 'null')
                                                                    <td></td>
                                                                    @else
                                                                    <td class="text-sm text-left" style="font-size: 9px;">{{$item->remarks}}</td>
                                                                    @endif
                                                                    {{-- @if ($item->idsupplier != null)
                                                                        <td class="text-sm text-center" style="font-size: 9px;">{{$item->vendor}} - {{$item->phone}}</td>
                                                                    @else
                                                                        <td class="text-sm text-center" style="font-size: 9px;"></td>
                                                                    @endif --}}
                                                                    @php
                                                                    $itemIndex++;
                                                                    @endphp
                                                                </tr>
                                                            @endforeach
                        
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 12px;" colspan="6">GRAND TOTAL</td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 12px;">{{number_format($dataPR->gtotal, 0, '.', '.')}}</td>
                                                                <td></td>
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
                            <!-- /Order Details -->
                            <!-- Total -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
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
                                            <td height="10"></td>
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
                                    <table width="798" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                        <tbody>
                                                            <tr class="font-bold bg-gray-5002">
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    PREPARED BY:
                                                                </td>
                                                                <td colspan="4" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    REVIEWED BY
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    APPROVED BY:
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="td1"></td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                </td>
                                                            </tr>
                                                            <tr class="font-bold">
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataPR->prepared_by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataPR->reviewed_by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataPR->reviewed2_by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataPR->approved_by}}
                                                                </td>
                                                            </tr>
                                                            <tr class="mb-5 font-bold">
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{date('d F Y', strtotime($dataPR->prepared_date))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
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
                @if ($PRDetailCount >= 50)
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
    window.print()
</script>