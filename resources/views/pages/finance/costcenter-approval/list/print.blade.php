<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataCC->idreqform}} </title>
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
                                                            <td class="flex justify-end {{ strlen($dataCC->address) > 50 ? 'mr-3' : '' }}">
                                                                @if ($dataCC->logo_filename != null)
                                                                <img src="http://ayoda.integrated-os.cloud/{{$dataCC->logo_filename}}" width="100" height="50" alt="companyLogo">
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
                                                    <div class="text-xs font-medium mb-1" style="font-family: Arial, Helvetica, sans-serif; font-size: 30px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataCC->company_type}}.&nbsp; {{$dataCC->companies}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataCC->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataCC->address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
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
                                                            COST CENTER
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
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Cost Center Form #</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataCC->idreqform}}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Form Date</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{ date('d F Y', strtotime($dataCC->datereq)) }}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Due Date</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{ date('d F Y', strtotime($dataCC->due_date)) }}
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;"></div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;"></div>
                                                                    <div class="table-cell2 text-xs2 font-bold2 text-right" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; opacity: 0;">
                                                                        @if ($dataCC->approved_total != null)
                                                                        {{$dataCC->currency}}&emsp; &emsp; {{number_format($dataCC->approved_total, 0, '.', '.')}}
                                                                        @else
                                                                        {{$dataCC->currency}}&emsp; &emsp; {{number_format($dataCC->gtotal, 0, '.', '.')}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Amount</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2 bg-gray-5002 text-right" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        @if ($dataCC->approved_total != null)
                                                                        {{$dataCC->currency}}&emsp; &emsp; {{number_format($dataCC->approved_total, 0, '.', '.')}}
                                                                        @else
                                                                        {{$dataCC->currency}}&emsp; &emsp; {{number_format($dataCC->gtotal, 0, '.', '.')}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="50%" valign="top">
                                                            <div class="table-container2">
                                                                {{-- <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataCC->applicant}}
                                                                    </div>
                                                                </div> --}}
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Company Name</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        @if ($dataCC->vendorsType == '-' || $dataCC->vendorsType == 'Perseorangan')
                                                                            {{$dataCC->vendorsName}}
                                                                        @else
                                                                        {{$dataCC->vendorsType}} {{$dataCC->vendorsName}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if ($dataCC->bank != 'Cash')
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Account Name</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataCC->name_account}}
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Account Name</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        -
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="table-row2">
                                                                    @if ($dataCC->bank == 'Cash')
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Payment To Beneficiary By</div>
                                                                    @else
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Bank</div>
                                                                    @endif
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        @if ($dataCC->bank == '' || $dataCC->bank == null || $dataCC->bank == ' ')
                                                                            -
                                                                        @else
                                                                        {{$dataCC->bank}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if ($dataCC->bank != 'Cash')
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Account</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        {{$dataCC->number_account}}
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="table-row2">
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Beneficiary Account</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="text-indent: 20px; font-size: 12px;">:</div>
                                                                    <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                                        -
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
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                        <div class="text-xs text-black font-bold mb-2 border-black" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; letter-spacing: -1px; line-height: 2; vertical-align: top; text-align: center;">
                                            {{$dataCC->department}}
                                        </div>
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
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 10px;">NO.</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 80px;">DATE</th>
                                                            <th class="text-sm text-center" style="font-size: 12px;">REFF #</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 150px;">DESCRIPTION</th>
                                                            <th class="text-sm text-center" style="font-size: 12px;">QTY</th>
                                                            <th class="text-sm text-center" style="font-size: 12px;">UNIT PRICE</th>
                                                            <th class="text-sm text-center" style="font-size: 12px;">FOREX</th>
                                                            <th class="text-sm text-center" style="font-size: 12px;">PRICE</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 150px;">INVOICE AMOUNT</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 120px;">TYPE VAT</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 100px;">VAT</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 120px;">TYPE WHT</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 100px;">WHT</th>
                                                            <th class="text-sm text-center" style="font-size: 12px; width: 150px;">AMOUNT PAID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $itemIndex = 1;
                                                        $rowSpan = count($CCDetail); // Set rowspan based on the total number of rows
                                                        @endphp
                                                        <script>
                                                            function formatNumber(num) {
                                                                const parts = num.toString().split('.');
                                                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                                            
                                                                if (parts[1]) {
                                                                    parts[1] = parts[1].replace(/0+$/, '').substring(0, 4);
                                                                }
                                                            
                                                                return parts.length > 1 && parts[1] !== '' ? parts.join(',') : parts[0];
                                                            }
                                                            </script>
                                                        @foreach ($CCDetail as $item)
                                                            <tr>
                                                                {{-- @if($itemIndex === 1) Only add rowspan for the first row
                                                                    <td rowspan="{{ $rowSpan }}"></td>
                                                                @endif --}}
                                                                <td class="text-sm text-center" style="font-size: 12px;">{{ $itemIndex }}</td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">{{ date('d F Y', strtotime($item->date)) }}</td>
                                                                @if ($item->invoice_number == null || $item->invoice_number == 'null')
                                                                <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                @else
                                                                <td class="text-sm text-left" style="font-size: 12px;">{{ $item->invoice_number }}</td>
                                                                @endif
                                                                <td class="text-sm text-left" style="font-size: 12px;">{{ $item->desc }}</td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->qty }}));
                                                                    </script>
                                                                </td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    {{ $item->currency }} 
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->unit_price }}));
                                                                    </script>
                                                                </td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->forex }}));
                                                                    </script>
                                                                </td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->price }}));
                                                                    </script>
                                                                </td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->subtotal }}));
                                                                    </script>
                                                                    {{-- {{number_format($item->subtotal, 0, ',', '.')}} --}}
                                                                </td>
                                                                @if ($item->vat == null || $item->vat == 'null')
                                                                <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                @else
                                                                <td class="text-sm text-left" style="font-size: 12px;">{{ $item->vat }}</td>
                                                                @endif
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->total_vat }}));
                                                                    </script>
                                                                    {{-- {{number_format($item->total_vat, 0, ',', '.')}} --}}
                                                                </td>
                                                                @if ($item->wht == null || $item->wht == 'null')
                                                                <td class="text-sm text-left" style="font-size: 12px;"></td>
                                                                @else
                                                                <td class="text-sm text-left" style="font-size: 12px;">{{ $item->wht }}</td>
                                                                @endif
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->total_wht }}));
                                                                    </script>
                                                                    {{-- {{number_format($item->total_wht, 0, ',', '.')}} --}}
                                                                </td>
                                                                <td class="text-sm text-right" style="font-size: 12px;">
                                                                    <script>
                                                                        document.write(formatNumber({{ $item->paid_total }}));
                                                                    </script>
                                                                    {{-- {{number_format($item->paid_total, 0, ',', '.')}} --}}
                                                                </td>
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
                                                        <tr class="totalRow bg-gray-5002">                    
                                                            @if ($dataCC->dp_amount != 0)
                                                            <td class="text-center font-bold text-lg" style="font-size: 15px;" colspan="8">Total Cost Center</td>
                                                            @else
                                                            <td class="text-center font-bold text-lg" style="font-size: 15px;" colspan="8">Grand Total Cost Center</td>
                                                            @endif
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="grandTotal_text">{{number_format($dataCC->subtotal, 0, ',', '.')}}</td>
                                                            <td></td>
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="grandTotal_text">{{number_format($dataCC->total_vat, 0, ',', '.')}}</td>
                                                            <td></td>
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="grandTotal_text">{{number_format($dataCC->total_wht, 0, ',', '.')}}</td>
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="grandTotal_text">{{number_format($dataCC->gtotal, 0, ',', '.')}}</td>
                                                        </tr>
                                                        @if ($dataCC->dp_amount != 0)
                                                        <tr class="DPRow bg-gray-5002">
                                                            <td class="text-center font-bold text-lg" style="font-size: 15px;" colspan="8">Previous DP</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="previousDP_text">-({{number_format($dataCC->dp_amount, 0, ',', '.')}})</td>
                                                        </tr>
                                                        <tr class="gradTotalRow bg-gray-5002">
                                                            <td class="text-center font-bold text-lg" style="font-size: 15px;" colspan="8">Grand Total Cost Center</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right font-bold text-lg" style="font-size: 15px;" id="grandeTotal_text">{{number_format($dataCC->grandeTotal, 0, ',', '.')}}</td>
                                                        </tr>
                                                        @endif
                                                        {{-- @if ($dataCC->approved_total != null)
                                                        <tr class="bg-gray-5002">
                                                            <td class="text-sm text-center font-bold" style="font-size: 12px;" colspan="8">COST PAID</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-sm text-right font-bold" style="font-size: 12px;">{{$dataCC->currency}} {{number_format($dataCC->approved_total, 0, ',', '.')}}</td>   
                                                        </tr>
                                                        @endif --}}
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
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                        <tr>
                                            <td>
                                                <div class="table-responsive" style="page-break-after: avoid;">
                                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="table table-bordered" style="border-collapse: collapse; border-width: 1px; border-color: black;">
                                                        <tbody>
                                                            <tr class="font-bold bg-gray-5002">
                                                                <td colspan="2" class="text-center" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 50%;">
                                                                    PREPARED BY:
                                                                </td>
                                                                <td colspan="2" class="text-center" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 50%;">
                                                                    RECEIVED BY:
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-center text-gray-400 mt-5" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px;">Not Required, Printed Automatically by System</td>
                                                                </td>
                                                                <td colspan="2" class="td1 text-center text-gray-400 mt-5" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left;">
                                                                </td>
                                                            </tr>
                                                            <tr class="font-bold">
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataCC->prepared_by}}
                                                                </td>
                                                                @if ($dataCC->bank_account == '1')
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataCC->name_account}}
                                                                </td>
                                                                @else
                                                                <td colspan="2" class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{$dataCC->name_account}}
                                                                </td>
                                                                @endif
                                                            </tr>
                                                            <tr class="mb-5 font-bold">
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    {{date('d F Y', strtotime($dataCC->datereq))}}
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Date:
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 70px;">
                                                                        
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