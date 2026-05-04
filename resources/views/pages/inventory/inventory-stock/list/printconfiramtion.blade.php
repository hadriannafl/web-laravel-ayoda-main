<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> {{$dataInbound->id_inbound}} </title>
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
                                            <table width="150" border="0" cellpadding="0" cellspacing="0" align="left" class="col" style="font-family: Arial, Helvetica, sans-serif;">
                                                <tbody>
                                                    <tr>
                                                            <td class="flex justify-end {{ strlen($dataInbound->address) > 50 ? 'mr-3' : '' }}">
                                                                @if ($dataInbound->logo_filename != null)
                                                                <img src="http://ayoda.integrated-os.cloud/{{$dataInbound->logo_filename}}" width="100" height="50" alt="companyLogo">
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
                                                        {{$dataInbound->company_type}}.&nbsp; {{$dataInbound->companyName}}
                                                    </div>
                                                    <div class="text-xs text-slate-800 font-medium" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; letter-spacing: -1px; line-height: 1; vertical-align: top; text-align: left;">
                                                        {{$dataInbound->address}}
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="{{ strlen($dataInbound->address) < 50 ? '100' : '20' }}" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
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
                            <!-- /Header -->
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
                                                        INBOUND CONFIRMATION
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
                                            <td width="50%" valign="top">
                                                <div class="table-container2">
                                                    <div class="table-row2">
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">INBOUND FORM #</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                            {{$dataInbound->id_inbound}}
                                                        </div>
                                                    </div>
                                                    <div class="table-row2">
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">FORM DATE</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                            {{ date('d F Y', strtotime($dataInbound->date)) }}
                                                        </div>
                                                    </div>
                                                    <div class="table-row2">
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">REFF #</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                            {{$dataInbound->reff}}
                                                        </div>
                                                    </div>
                                                    <div class="table-row2">
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">COURIER NAME</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                            {{$dataInbound->courier_name}}
                                                        </div>
                                                    </div>
                                                    <div class="table-row2">
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">VEHICLE #</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-indent: 20px;">:</div>
                                                        <div class="table-cell2 text-xs2 font-bold2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                            {{$dataInbound->vehicle}}
                                                        </div>
                                                    </div>
                                                </div>
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
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 150px; width: 10px;">Inventory Code</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 150px;">Inventory Name</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 150px; width: 10px;">Qty</th>
                                                                <th class="text-sm text-center" style="font-size: 12px; width: 150px; width: 10px;">Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($dataInboundItem as $datas)
                                                                <tr>
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{$datas->idassets}}</td>
                                                                    <td class="text-sm text-left" style="font-size: 12px;">{{$datas->name}}</td>
                                                                    <td class="text-sm text-right" style="font-size: 12px;">{{number_format($datas->qty, 0, '.', '.')}}</td>
                                                                    <td class="text-sm text-center" style="font-size: 12px;">{{$datas->unit}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr class="bg-gray-5002">
                                                                <td class="text-sm text-center font-bold" style="font-size: 12px;" colspan="2">TOTAL</td>
                                                                <td class="text-sm text-right font-bold" style="font-size: 12px;">{{number_format($dataInbound->total_qty, 0, '.', '.')}}</td>
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
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        COURIERED BY:
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        RELEASED BY:
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        RECEIVED BY:
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-center text-gray-400 mt-5 td1" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px; width: 25%;">
                                                                        {{-- Not Required, Printed Automatically by System --}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center text-gray-400 mt-5" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px;">
                                                                        {{-- Not Required, Printed Automatically by System --}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center text-gray-400 mt-5" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px;"></td>
                                                                    <td colspan="2" class="text-center text-gray-400 mt-5" style="font-family: Arial, Helvetica, sans-serif; font-size: 8px; line-height: 18px; vertical-align: bottom; text-align: left; margin-block: 5px;"></td>
                                                                </tr>
                                                                <tr class="font-bold">
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{-- {{$dataInbound->approve_by}} --}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{-- {{$dataInbound->released_by}} --}}
                                                                    </td>
                                                                    <td colspan="2" class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{-- {{$dataInbound->received_by}} --}}
                                                                    </td>
                                                                </tr>
                                                                <tr class="mb-5 font-bold">
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        {{date('d-M-y', strtotime($dataInbound->date))}}
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 150px;">
                                                                        {{-- {{date('d-M-y', strtotime($dataInbound->approvaldate))}} --}}
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 150px;">
                                                                        {{date('d-M-y', strtotime($dataInbound->updated_at))}}
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                        Date:
                                                                    </td>
                                                                    <td class="text-center" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left; width: 150px;">
                                                                        
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
            @if ($dataInboundItemCount >= 50)
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
            </td>
        </tr>
    </tfoot>
</body>
</html>
<script>
    window.print();
</script>