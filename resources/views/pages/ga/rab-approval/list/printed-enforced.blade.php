<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataRab->name}} </title>
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
        .td2 {
            width: 200px;
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
                                            <table width="150" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif; ">
                                                <tbody>
                                                    <tr>
                                                            <td class="flex justify-end {{ strlen($dataRab->address) > 50 ? 'mr-3' : '' }}">
                                                                @if ($dataRab->logo_filename != null)
                                                                <img src="http://ayoda.integrated-os.cloud/{{$dataRab->logo_filename}}" width="100" height="50" alt="companyLogo">
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
                                                    <div class="text-xs font-medium mb-1" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataRab->company_type}}.&nbsp; {{$dataRab->name}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataRab->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataRab->address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                <tbody><tr></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="hiddenMobile">
                                        <td height="30"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="10"></td>
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
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <div class="text-xs text-black font-bold mb-2 border-black bg-gray-5002" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; letter-spacing: -1px; line-height: 2; vertical-align: top; text-align: center;">
                                                        RENCANA ANGGARAN BIAYA
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
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif;">
                                                    <div class="table-container2">
                                                        <div class="table-row">
                                                            <div class="table-cell2 text-xs2 font-bold2">RAB DATE</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 35px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{ date('d F Y', strtotime($dataRab->form_date)) }}
                                                            </div>
                                                        </div>
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2">NO</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 74px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataRab->id_rab}}
                                                            </div>
                                                        </div>
                                                        <div class="table-row">
                                                            <div class="table-cell2 text-xs2 font-bold2">RAB PERIOD</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 22px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{ date('F Y', strtotime($dataRab->date_rab)) }}
                                                            </div>
                                                        </div>
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2">RAB TITLE</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 13px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataRab->name_rab}}
                                                            </div>
                                                        </div>
                                                        <div class="table-row2">
                                                            <div class="table-cell2 text-xs2 font-bold2">DEPARTMENT</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 13px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2">
                                                                {{$dataRab->dept}}
                                                            </div>
                                                        </div>
                                                        <div class="table-row2 table-stripped">
                                                            <div class="table-cell2 text-xs2 font-bold2">TOTAL</div>
                                                            <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 13px;">:</div>
                                                            <div class="table-cell2 text-xs2 font-bold2 bg-gray-5002">
                                                                {{$dataRab->currency}}&emsp; &emsp;{{number_format($dataRab->gtotal, 0, '.', '.')}}
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
                                                    <table class="table table-bordered mb-10" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; border-radius: 0 0 5px 5px; border-collapse: collapse; border-width: 1px; border-color: black;"> 
                                                        <thead>
                                                            <tr class="font-bold text-black bg-gray-5002">
                                                                <th class="text-sm text-center" style="font-size: 10px;" colspan="4">DESKRIPSI</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 30px;">QTY</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 30px;">UNIT</th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 10px;"></th>
                                                                <th class="text-sm text-center" style="font-size: 10px; width: 50px;">HARGA SATUAN</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">TOTAL</th>
                                                                <th class="text-sm text-center" style="font-size: 10px;">REMARKS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;">SITE</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                {{-- <td class="text-sm text-left font-bold" style="font-size: 9px;">IDR</td> --}}
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @php
                                                            $alphabet = 'A'; // Inisialisasi alfabet
                                                            $currentDepartment = null;
                                                            @endphp
                                                            @foreach ($dataRabDepartment as $departement)
                                                            @if ($currentDepartment != $departement->category)
                                                                {{-- Mulai ulang penomoran angka ketika sub_department berubah --}}
                                                                @php
                                                                $alphabet = 'A';
                                                                $currentDepartment = $departement->category;
                                                                @endphp
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;" colspan="3">{{$departement->category}}</td>
                                                                <td></td>
                                                                {{-- <td></td> --}}
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @php
                                                            $itemIndex = 1; // Inisialisasi penomoran angka untuk setiap sub_department
                                                            $currentSubDepartment = null; // Inisialisasi sub_department saat ini
                                                            @endphp
                                                            @foreach ($dataRabSubDepartment as $sub)
                                                            @if ($departement->category == $sub->category)
                                                                @if ($currentSubDepartment != $sub->sub_category)
                                                                    {{-- Mulai ulang penomoran angka ketika sub_department berubah --}}
                                                                    @php
                                                                    $itemIndex = 1;
                                                                    $currentSubDepartment = $sub->sub_category;
                                                                    @endphp
                                                                @endif
                                                            <tr>
                                                                <td></td>
                                                                <td class="text-sm text-center font-bold" style="font-size: 9px;">{{$alphabet}}</td>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;" colspan="2">{{$sub->sub_category}}</td>
                                                                <td></td>
                                                                {{-- <td></td> --}}
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 9px;" id="totaly" onchange="">{{number_format($sub->Totaly, 0, '.', '.')}}</td>
                                                            </tr>
                                                            @php
                                                            $alphabet++; // Inkremen alfabet
                                                            @endphp
                                                            @foreach ($dataRabItem as $item)
                                                            @if ($item->sub_category == $sub->sub_category)
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                {{-- <td></td> --}}
                                                                <td class="text-sm text-right" style="font-size: 9px;">{{$itemIndex}}</td>
                                                                <td class="text-sm text-left" style="font-size: 9px;">{{$item->detail}}</td>
                                                                @if ($item->unit == 'Lump Sum')
                                                                <td class="text-sm text-right" style="font-size: 9px;"></td>
                                                                @else
                                                                <td class="text-sm text-right" style="font-size: 9px;">{{number_format($item->qty, 0, '.', '.')}}</td>
                                                                @endif
                                                                <td class="text-sm text-left" style="font-size: 9px;">{{$item->unit}}</td>
                                                                <td class="text-sm text-center" style="font-size: 9px;">{{$dataRab->currency}}</td>
                                                                <td class="text-sm text-right" style="font-size: 9px;">{{number_format($item->amount, 0, '.', '.')}}</td>
                                                                <td class="text-sm text-right" style="font-size: 9px;" id="total">{{number_format($item->total, 0, '.', '.')}}</td>
                                                                @if ($item->remarks == null || $item->remarks == 'null')
                                                                <td class="text-sm text-left" style="font-size: 9px;"></td>
                                                                @else
                                                                <td class="text-xs text-left font-semibold remarks" style="font-size: 9px;">{{$item->remarks}}</td>
                                                                @endif
                                                            </tr>
                                                            @php
                                                            $itemIndex++; // Inkremen penomoran angka
                                                            @endphp
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            @endforeach
                                                            @endforeach
                                                            <tr style="height: 15px;">
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 12px;" colspan="8">GRAND TOTAL ({{$dataRab->currency}})</td>
                                                                {{-- <td class="text-sm text-right font-bold" style="font-size: 9px;">{{number_format($dataRab->qtyTotal, 0, '.', '.')}}</td> --}}
                                                                <td class="text-sm text-right font-bold" style="font-size: 12px;">{{number_format($dataRab->gtotal, 0, '.', '.')}}</td>
                                                                <td></td>
                                                            </tr>
                                                            {{-- <tr class="bg-gray-5002">
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;">RAB TAHAP I</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 9px;">RP. {{number_format($dataRab->gtotal, 0, '.', '.')}}</td>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;">31 Juli 2023</td>
                                                            </tr>
                                                            <tr class="bg-gray-5002">
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-left font-bold" style="font-size: 9px;">RAB TAHAP II</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 9px;">RP. {{number_format($dataRab->gtotal, 0, '.', '.')}}</td>
                                                                <td></td>
                                                            </tr> --}}
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
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 25%;">
                                                                        PREPARED BY:
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 25%;">
                                                                        APPROVED 1 BY:
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 25%;">
                                                                        APPROVED 2 BY:
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 25%;">
                                                                        APPROVED 3 BY:
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="td1 text-center" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;">Not Required, Approved Automatically by System</td>
                                                                    <td colspan="2" class="text-center" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;">
                                                                     Not Required, Approved Automatically by System</td>
                                                                    <td colspan="2" class="text-center" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;">
                                                                    Not Required, Approved Automatically by System</td>
                                                                    <td colspan="2" class="text-center" style="font-size: 8px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;">
                                                                    Not Required, Approved Automatically by System</td>
                                                                </tr>
                                                                <tr class="font-bold">
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{$dataRab->prepared_by}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{$dataRab->approved1by}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{$dataRab->approved2by}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        @if ($dataRab->approved3by != null || $dataRab->approved3by != 'null')
                                                                            {{$dataRab->approved3by}}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr class="mb-5 font-bold">
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{date('d F Y', strtotime($dataRab->created_at))}}
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        @if ($dataRab->prepared_date < $dataRab->approvaldate)
                                                                        {{date('d F Y', strtotime($dataRab->approvaldate))}}
                                                                        @else
                                                                        {{date('d F Y', strtotime($dataRab->prepared_date))}}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        @if ($dataRab->approved2_date < $dataRab->approvaldate)
                                                                        {{date('d F Y', strtotime($dataRab->approvaldate))}}
                                                                        @else
                                                                        {{date('d F Y', strtotime($dataRab->approved2_date))}}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 130px;">
                                                                        @if ($dataRab->approval3_to == null)
                                                                        -
                                                                        @elseif ($dataRab->approved3_date < $dataRab->approvaldate)
                                                                        {{date('d F Y', strtotime($dataRab->approvaldate))}}
                                                                        @else
                                                                        {{date('d F Y', strtotime($dataRab->approved3_date))}}
                                                                        @endif
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
                @if ($dataRabItemCount >= 50)
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
    window.print();
</script>