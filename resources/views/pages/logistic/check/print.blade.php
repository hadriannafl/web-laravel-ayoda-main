<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title> Delivery Orders Report </title>
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
    <!-- Header -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tr>
        <td height="20"></td>
        </tr>
        <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
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
                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                <tbody>
                                <tr>
                                    <div class="text-xs text-slate-800 font-bold mb-3" style="font-size: 20px; letter-spacing: -1px; font-family: Arial, Helvetica, sans-serif; line-height: 1; vertical-align: top; text-align: left;">
                                        Incident - Damage/Lost Goods Report 📦
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-2" for="code">Tracking Code :
                                        </label>
                                        <input id="code" name="code" style="font-size: 9px;"
                                            class="code form-input w-full md:w-3/4 mb-2" type="text"
                                            value="{{ $viewDo->code }}" readonly disabled />
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-3" for="company">Delivery Order Number : </label>
                                        <input id="number" name="number" style="font-size: 9px;"
                                            class="number form-input w-full md:w-3/4 mb-2" type="text"
                                            value="{{ $viewDo->do_number }}" readonly disabled />
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-3" for="status">Status : </label>
                                        <input id="status" name="status" style="font-size: 9px;"
                                            class="status form-input w-full md:w-3/4 mb-2" type="text"
                                            value="{{ $viewDo->name_status }}" readonly disabled />
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-3" for="date">Delivery Date : </label>
                                        <input id="date" name="date" style="font-size: 9px;"
                                            class="date form-input w-full md:w-3/4 mb-2" type="text"
                                            value="{{ date('Y-m-d', strtotime($viewDo->delivery_date)) }}" readonly disabled />
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-3" for="by">Delivery By : </label>
                                        <input id="by" name="by" style="font-size: 9px;"
                                            class="by form-input w-full md:w-3/4 mb-2" type="text"
                                            value="{{ $viewDo->delivery_by }}" readonly disabled />
                                    </div>
                                    <div class="flex flex-row">
                                        <label style="font-size: 9px;" class="text-xs w-1/4 mr-2 mb-2 mt-3" for="company">Delivery Address : </label>
                                        <textarea style="font-size: 9px;" id="notes" name="notes" class="notes form-input w-full md:w-1/2 mb-2"
                                            rows="3" readonly disabled>{{ $viewDo->delivery_address}} </textarea>
                                    </div>
                                </tr>
                                </tbody>
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
    <!-- /Header -->
    <!-- Order Details -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                        <label style="font-size: 9px;" class="block w-full md:w-1/4 text-xs font-medium mb-1" for="company">Delivery Product Items :</label>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th class="text-xs text-center" style="font-size: 10px;">Product Code</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Product Name</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Batch No</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Qty</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Status</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Damaged Qty</th>
                                        <th class="text-xs text-center" style="font-size: 10px;">Lost Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="detail-delivery-orders mt-5" id="detail-delivery-orders">
                                    <tr>
                                    <td class="text-center text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->product_code}}</td>
                                    <td class="text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->product_name}}</td>
                                    <td class="text-center text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->batch_no}}</td>
                                    <td class="text-center text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->qty}}</td>
                                    <td class="text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->status_order}}</td>
                                    <td class="text-center text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->qty_damaged}}</td>
                                    <td class="text-center text-xs" style="font-size: 10px;">{{$dataDeliveryOrders->qty_lost}}</td>
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
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                <tbody>
                <tr>
                    <td>
    
                    <!-- Table Total -->
                    {{-- <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                        <tbody>
                        <tr>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            Subtotal
                            </td>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
                            $329.90
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            Shipping &amp; Handling
                            </td>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                            $15.00
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                            <strong>Grand Total (Incl.Tax)</strong>
                            </td>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                            <strong>$344.90</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; "><small>TAX</small></td>
                            <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; ">
                            <small>$72.40</small>
                            </td>
                        </tr>
                        </tbody>
                    </table> --}}
                    <!-- /Table Total -->
    
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
    <div>
        @if ($dataDeliveryOrders->photo_damage1_name == null && $dataDeliveryOrders->photo_lost1_name == null)
        <center><label class="text-xs mb-1">Product Damaged/Lost Image Not Uploaded Yet :</label></center>
        @endif
    </div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
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
                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                        <tbody>
                        <tr>
                            <td>
                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
    
                                <tbody class="{{$dataDeliveryOrders->photo_damage1_name == null ? 'hidden' : ''}}">
                                    <tr>
                                        <td style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                        <strong>DAMAGED IMAGE 1</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" height="10"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                            <img class="w-full mt-3" src="/images/applications-image-04.jpg" width="259" height="160" alt="Do Image"/>
                                            {{-- <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataDeliveryOrders->photo_damage1_name}}" width="259" height="160" alt="Do Image"/> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
    
    
                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                <tbody class="{{$dataDeliveryOrders->photo_damage2_name == null ? 'hidden' : ''}}"> 
                                <tr class="visibleMobile">
                                    <td height="20"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                    <strong>DAMAGED IMAGE 2</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                        <img class="w-full mt-3" src="/images/applications-image-04.jpg" width="259" height="160" alt="Do Image"/>
                                        {{-- <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataDeliveryOrders->photo_damage2_name}}" width="259" height="160" alt="Do Image"/> --}}
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
                    <td>
                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                        <tbody class="{{$dataDeliveryOrders->photo_lost1_name == null ? 'hidden' : ''}}">
                        <tr>
                            <td>
                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                <tbody>
                                <tr class="hiddenMobile">
                                    <td height="35"></td>
                                </tr>
                                <tr class="visibleMobile">
                                    <td height="20"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                    <strong>LOST IMAGE 1</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                        <img class="w-full mt-3" src="/images/applications-image-04.jpg" width="259" height="160" alt="Do Image"/>
                                        {{-- <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataDeliveryOrders->photo_lost1_name}}" width="259" height="160" alt="Do Image"/> --}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
    
    
                            <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                <tbody class="{{$dataDeliveryOrders->photo_lost2_name == null ? 'hidden' : ''}}">
                                <tr class="hiddenMobile">
                                    <td height="35"></td>
                                </tr>
                                <tr class="visibleMobile">
                                    <td height="20"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                    <strong>LOST IMAGE 2</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px; font-family: Arial, Helvetica, sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                        <img class="w-full mt-3" src="/images/applications-image-04.jpg" width="259" height="160" alt="Do Image"/>
                                        {{-- <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/{{$dataDeliveryOrders->photo_lost2_name}}" width="259" height="160" alt="Do Image"/> --}}
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
                </tbody>
            </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- /Information -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    
        <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
            <tr>
                <td>
                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                    <tbody>
                    <tr>
                        {{-- <td style="font-size: 12px; color: #5b5b5b; font-family: Arial, Helvetica, sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                        Have a nice day.
                        </td> --}}
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
</body>
</html>
<script>
    window.print()
</script>