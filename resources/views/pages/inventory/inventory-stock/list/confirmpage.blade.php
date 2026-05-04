<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Confirm Inbound Inventory 📝</h1>
        </div>
        @if ($dataInbound->file != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('inbound-inventory.viewfile', ['inboundId' => $dataInbound->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment</a>
                </div>
            </div>
        @endif
        <form method="post" id="myForm" enctype="multipart/form-data" action="{{ route('inbound-approval.confirm', ['inboundId' => $dataInbound->idrec]) }}">
            @csrf
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Inbound # / Date Form / Company</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->id_inbound}}" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="date" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('d F Y', strtotime($dataInbound->date))}}" readonly>
                </div>
                <div>
                    <input id="id_cp" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{date('F Y', strtotime($dataInbound->companyName))}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Name / Address / City</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataInbound->w_name}}" type="text" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <textarea id="address" name="address" class="address form-input w-full px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataInbound->w_address}}</textarea>
                </div>
                <div>
                    <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->w_city}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Warehouse Province / Country / POS Code</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="benef_bank" class="form-input w-full px-2 py-1 read-only:bg-slate-200" value="{{$dataInbound->w_province}}" type="text" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="benef_name" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->w_country}}" readonly>
                </div>
                <div>
                    <input id="benef_acc" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->w_zipcode}}" readonly/>
                </div>
        </div>
        <div class="flex flex-row mb-3 mt-3">
            <label class="block w-full md:w-1/4 text-sm font-medium mt-1" for="payee_bank">Reff # / Courier Name / Vehicle #</label>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="form_type" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->reff}}" readonly/>
                </div>
                <div style="width: 20.8rem; margin-right: 20px;">
                    <input id="status" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->courier_name}}" readonly>
                </div>
                <div>
                    <input id="company" style="width: 21.2rem;" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{$dataInbound->vehicle}}" readonly/>
                </div>
        </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id"> List Inbound Inventory
                    </label>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Inventory Code</th>
                                <th class="text-sm text-center">Inventory Name</th>
                                <th class="text-sm text-center">Qty</th>
                                <th class="text-sm text-center">Unit</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Upload Confirmation File<span
                        class="text-rose-500">*</span>&nbsp;: </label>
                    <input id="file" name="file" class="file form-input w-full md:w-3/4 px-2 py-1" type="file" accept="application/pdf" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"></label>
                    <div class="text-xs mt-1 text-rose-500 w-full md:w-3/4 px-2 py-1">File max size 12MB</div>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="date">Received Date<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date" value="{{date('Y-m-d')}}"
                        class="date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
            @if ($dataInbound->status == "Scheduled" || $dataInbound->status == "Printed")
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Confirm Inbound Inventory</span>
                </button> </center>
            @endif
        </form>
    </div>

    @section('js-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataInboundItem?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {

            tableRow += `<tr id=row1-productIdx>
                            <td>${value.idassets}</td>
                            <td>${value.name}</td>
                            <td class="text-right">${newDivider1(value.qty)}</td>
                            <td class="text-center">${value.unit}</td>
                                        </tr>`;
        }
        tableRow += `<tr>
                    <td class="text-center font-bold text-lg" colspan="2">Total</td>
                    <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataInbound->grandTotal, 0, '.', '.')}}</span></td>
                    <td></td>
                </tr>`;
        $(".tableProductAddBody").find('tbody').append(tableRow);

        $('#myForm').submit(function (e, params) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            console.log(formData, $(this).attr('action'));
            $.ajax({
                url      : $(this).attr('action'),
                type     : 'POST',
                dataType : 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(_response){
                    if (_response.st == '1') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Inbound Inventory has been Confirmed',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                urlRedirect = '/inventory/inbound-inventory/list/printconfirm';
                                window.open(urlRedirect, '_self');
                            }else {
                                urlRedirect = '/inventory/inbound-inventory/list/printconfirm';
                                window.open(urlRedirect, '_self');
                            }
                        });
                        urlRedirect = '/inventory/inbound-inventory/list/printconfirm';
                        window.open(urlRedirect, '_self');
                        // Swal.fire({
                        //     title: 'Success',
                        //     text: 'Reimburse #' + RRID + ' Has Been Created',
                        //     icon: 'success',
                        //     showCancelButton: false,
                        //     confirmButtonText: 'Ok',
                        //     cancelButtonText: 'No, cancel'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         Swal.close();
                        //     }else {
                        //         Swal.close();
                        //     }
                        // });
                    }else if (_response.st == '2') {
                        Swal.fire({
                            title: 'File to Large',
                            text: 'Please Compress File',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }else if (_response.st == '3') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Inbound Inventory Already Confirmed',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }else if (_response.st == '4') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Received Date cannot before now',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }else {
                                Swal.close();
                            }
                        });
                    }
                },
                    error: function(){
                    alert('Terjadi kesalahan');
                }
            });
        })
        
    </script>
    @endsection
</x-app-layout>