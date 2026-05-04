<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataRR->idreqform}} </title>
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
                margin-top: 20px;
            }

            body {
                -webkit-print-color-adjust: exact;
                margin: 0; /* Hilangkan margin default */
                padding: 10mm; /* Tambahkan padding agar ada jarak pada kanan dan kiri */
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
                            <tr>
                                <td>
                                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <table width="200" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif;">
                                                <tbody>
                                                    <tr>
                                                        <td class="flex justify-end {{ strlen($dataRR->address) > 50 ? 'mr-3' : '' }}">
                                                            @if ($dataRR->logo_filename != null)
                                                            <img src="http://ayoda.integrated-os.cloud/{{$dataRR->logo_filename}}" width="100" height="50" alt="companyLogo">
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
                                                    <div class="text-xs font-medium mb-1" style="font-family: Arial, Helvetica, sans-serif; font-size: 30px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataRR->company_type}}.&nbsp; {{$dataRR->companyName}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataRR->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataRR->address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
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
                                    <table width="1570" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <div class="text-xs text-black font-bold mb-2 border-black bg-gray-5002" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; letter-spacing: -1px; line-height: 2; vertical-align: top; text-align: center;">
                                                        REIMBURSE REQUEST FORM
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
                                    <table width="1570" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                                                <table width="150%" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="50%" valign="top">
                                                            <div class="table-container2">
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Reimbursement Form #</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataRR->idreqform}}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Request Date</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{ date('d F Y', strtotime($dataRR->datereq)) }}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Company (Charged To)</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        @if ($dataRR->company_name != null)
                                                                        {{$dataRR->company_name}}
                                                                        @else
                                                                        {{$dataRR->companyName}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2 table-stripped">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Amount Beneficiary</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2 bg-gray-5002 text-right" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        @if ($dataRR->approved_total != null)
                                                                        {{$dataRR->currency}}&emsp; &emsp; {{number_format($dataRR->approved_total, 0, '.', '.')}}
                                                                        @else
                                                                        {{$dataRR->currency}}&emsp; &emsp; {{number_format($dataRR->gtotal, 0, '.', '.')}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="50%" valign="top">
                                                            <div class="table-container2">
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Employee</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataRR->employee}} {{$dataRR->last_name}}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Bank</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataRR->bank}}
                                                                    </div>
                                                                </div>
                                                                @if ($dataRR->bank != 'Cash')
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Account</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataRR->number_account}}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Name</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataRR->name_account}}
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
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
                                    <table width="1570" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                                                    <table class="table table-bordered mb-10" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; border-radius: 0 0 5px 5px; border-collapse: collapse; border-width: 1px; border-color: black;"> 
                                                        <thead>
                                                            <tr class="font-bold text-black bg-gray-5002">
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 5px;">NO.</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 100px;">DATE</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 120px;">REIMBURSE TYPE</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 120px;">VEHICLE NUMBER</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">DESCRIPTION</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">SUBTOTAL</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">TYPE VAT</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">VAT</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">TYPE WHT</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">WHT</th>
                                                                <th class="text-sm text-center" style="font-size: 12px;">AMOUNT PAID</th>
                                                                {{-- <th class="text-sm text-center" style="font-size: 9px;">REMARKS</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $itemIndex = 1;
                                                            $rowSpan = count($RRDetail); // Set rowspan based on the total number of rows
                                                            @endphp
                                                            @foreach ($RRDetail as $item)
                                                                <tr>
                                                                    {{-- @if($itemIndex === 1) Only add rowspan for the first row
                                                                        <td rowspan="{{ $rowSpan }}"></td>
                                                                    @endif --}}
                                                                    <td class="text-sm text-center" style="font-size: 12px;">{{ $itemIndex }}</td>
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{ date('d F Y', strtotime($item->date)) }}</td>
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{$item->reimburse_type}}</td>
                                                                    @if ($item->no_vehicle == null || $item->no_vehicle == 'null')
                                                                    <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                    @else
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{ $item->no_vehicle }}</td>
                                                                    @endif
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{ $item->reimburse_to }}</td>
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{number_format($item->subtotal, 0, '.', '.')}}</td>
                                                                    @if ($item->vat == null || $item->vat == 'null')
                                                                    <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                    @else
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{ $item->vat }}</td>
                                                                    @endif
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{number_format($item->total_vat, 0, '.', '.')}}</td>
                                                                    @if ($item->wht == null || $item->wht == 'null')
                                                                    <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                    @else
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{ $item->wht }}</td>
                                                                    @endif
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{number_format($item->total_wht, 0, '.', '.')}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{number_format($item->paid_total, 0, '.', '.')}}</td>
                                                                    {{-- @if ($item->remarks == null || $item->remarks == 'null')
                                                                    <td class="text-sm text-left" style="font-size: 7px;"></td>
                                                                    @else
                                                                    <td class="text-xs text-left font-semibold remarks" style="font-size: 7px;">{{$item->remarks}}</td>
                                                                    @endif --}}
                                                                    @php
                                                                    $itemIndex++;
                                                                    @endphp
                                                                </tr>
                                                            @endforeach
                        
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="7">GRAND TOTAL REIMBURSE</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;">{{$dataRR->currency}} {{number_format($dataRR->total_vat, 0, ',', '.')}}</td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;">{{$dataRR->currency}} {{number_format($dataRR->total_wht, 0, ',', '.')}}</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;">{{$dataRR->currency}} {{number_format($dataRR->gtotal, 0, ',', '.')}}</td>
                                                                {{-- <td></td> --}}
                                                            </tr>
                                                            @if ($dataRR->approved_total != null)
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 15px;" colspan="7">REIMBURSE PAID</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 15px;">{{$dataRR->currency}} {{number_format($dataRR->approved_total, 0, ',', '.')}}</td>   
                                                                {{-- <td></td> --}}
                                                            </tr>
                                                            @endif
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
                            @if ($dataRR->remarks1 != null || $dataRR->remarks2 != null)
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff"> 
                                <tr>
                                <td>
                                    <table width="1570" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                        <tbody>
                                                            @if ($dataRR->remarks1 != null)
                                                            <tr class="">
                                                                <td class="text-center font-bold" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: top; text-align: left; width: 170px;">
                                                                    APPROVAL 1 REMARKS:
                                                                </td>
                                                                <td class="text-left font-medium" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: top; text-align: left;">
                                                                    {{$dataRR->remarks1}}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if ($dataRR->remarks2 != null)
                                                            <tr class="">
                                                                <td class="text-center font-bold" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: top; text-align: left; width: 150px;">
                                                                    APPROVAL 2 REMARKS:
                                                                </td>
                                                                <td class="text-left font-medium" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: top; text-align: left;">
                                                                    {{$dataRR->remarks2}}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                            @endif
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
                                    @if ($dataRR->approved2by != null)
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                        <tbody>
                                                            <tr class="font-bold bg-gray-5002">
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    PREPARED BY:
                                                                </td>
                                                                <td colspan="4" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    APPROVED BY:
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    RECEIVED BY:
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="td1 text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px; width: 12.5%;">Not Required, Printed Automatically by System</td>
                                                                <td colspan="2" class="text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left; width: 25%;">
                                                                Not Required, Approved Automatically by System</td>
                                                                <td colspan="2" class="text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left; width: 25%;">
                                                                Not Required, Approved Automatically by System</td>
                                                                <td colspan="2" class="text-center text-gray-400" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                </td>
                                                            </tr>
                                                            <tr class="font-bold">
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->prepared_by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->approved1by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->approved2by}}
                                                                </td>
                                                                @if ($dataRR->bank_account == '1')
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->employee}} {{$dataRR->last_name}}
                                                                </td>
                                                                @else
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->employee}} {{$dataRR->last_name}}
                                                                </td>
                                                                @endif
                                                            </tr>
                                                            <tr class="mb-5 font-bold">
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{date('d F Y', strtotime($dataRR->datereq))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                    {{date('d F Y', strtotime($dataRR->approval1_date))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                    {{date('d F Y', strtotime($dataRR->approval2_date))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        
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
                                    @else
                                    <table width="850" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                        <tbody>
                                                            <tr class="font-bold bg-gray-5002">
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    PREPARED BY:
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    APPROVED BY:
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    RECEIVED BY:
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="td1 text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px; width: 12.5%;">Not Required, Printed Automatically by System</td>
                                                                <td colspan="2" class="text-center text-gray-400 mt-5" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left; width: 12.5%;">
                                                                Not Required, Approved Automatically by System</td>
                                                                <td colspan="2" class="text-center text-gray-400" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                </td>
                                                            </tr>
                                                            <tr class="font-bold">
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->prepared_by}}
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->approved1by}}
                                                                </td>
                                                                @if ($dataRR->bank_account == '1')
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->employee}} {{$dataRR->last_name}}
                                                                </td>
                                                                @else
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{$dataRR->employee}} {{$dataRR->last_name}}
                                                                </td>
                                                                @endif
                                                            </tr>
                                                            <tr class="mb-5 font-bold">
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{date('d F Y', strtotime($dataRR->datereq))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    {{date('d F Y', strtotime($dataRR->approval1_date))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 12.5%;">
                                                                        
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
                                    @endif
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
                <td height="30"></td>
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