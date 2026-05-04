<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Generate Serial Number Fixed Asset 📝</h1>
        </div>
        @if ($dataForm->invoice_pdf != null)
            <div class="px-5 py-4 border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <a href="{{ route('fixedasset.file', ['idForm' => $dataForm->idrec]) }}" target="_blank" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">View Attachment Invoice</a>
                </div>
            </div>
        @endif
        <div class="px-5 py-4">
            <div class="space-y-3">
                <form method="post" enctype="multipart/form-data" id="myForm" action="{{ route('fixedasset.generate') }}">
                    @csrf
                    <div class="flex justify-between flex-col md:flex-row mb-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date</label>
                        <input id="date" name="date"
                        class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        Value="{{date('d F Y', strtotime($dataForm->form_date))}}" required readonly/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="no_form">M. Input #
                        </label>
                            <input id="no_form" name="no_form"
                            class="no_form form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->no_form}}" readonly/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="company">Company
                        </label>
                            <input id="company1" name="company1"
                            class="company1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->company}}" readonly/>
                            <input id="company" name="company"
                            class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->id_company}}" readonly hidden/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="waddress">Warehouse Address
                        </label>
                        <textarea id="waddress" name="waddress"
                        class="waddress form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly>{{$dataForm->w_address}}</textarea>
                        <input id="wid" name="wid"
                        class="wid form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataForm->id_warehouse}}" readonly hidden/>
                        <input id="w_name" name="w_name"
                        class="w_name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataForm->w_name}}" readonly hidden/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row mt-3">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                            for="invoice_number">Invoice Number
                        </label>
                            <input id="invoice_number" name="invoice_number"
                            class="invoice_number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$dataForm->invoice_number}}" readonly/>
                    </div>
                    
                        <div class="flex flex-row md:flex-row mb-3 mt-3">
                            <label class="block text-sm font-medium mb-1" for="task_id">FORM Fixed Asset Detail
                            </label>
                        </div>
                        <div class="flex flex-row md:flex-row">
                            <table class="tableProductAddBody table table-striped table-bordered mt-3"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-sm text-center">M. Input Detail #</th>
                                        <th class="text-sm text-center">Asset Code</th>
                                        <th class="text-sm text-center">Inventory Name</th>
                                        <th class="text-sm text-center">Quantity</th>
                                        <th class="text-sm text-center">Currency</th>
                                        <th class="text-sm text-center">Price</th> 
                                        <th class="text-sm text-center">Total</th> 
                                        <th class="text-sm text-center">Detail</th> 
                                    </tr>
                                </thead>
                                <tbody class="tableProductAddBody" id="tableProductAddBody">
                                </tbody>
                            </table>
                        </div>
                    <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    @if ($dataForm->generate == 'N')
                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="generateAsset">
                        <span class="xs:block ml-5 mr-5">Generate Fixed Asset</span>
                    </button> </center>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @section('js-page')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataFormDetail?>;
        let tableRow = '';
        
        for (const value of dataProducts) {
            // var iden = makeid(3);
            var iden = dataProducts.indexOf(value);

            tableRow += `<tr id=row-${iden}>
                            <td><input type="text" name="idrecss_${iden}" value="${value.idrec}" hidden/><input type="text" name="idnfa_${iden}" value="${value.idnfa}" hidden/>${value.idnfa}</td>
                            <td><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.idassets}" hidden/><span id="ids-text_${iden}">${value.idassets}</span></td>
                            <td><input type="text" name="assetName_${iden}" id="assetName_${iden}" value="${value.assetName}" hidden/><span id="assetName-text_${iden}">${value.assetName}</span></td>
                            <td class="text-right"><input type="text" name="qty_${iden}" id="qty_${iden}" value="${newDivider2(value.qty)}" hidden/><span id="qty-text_${iden}">${newDivider1(value.qty)}</span></td>
                            <td class="text-center">{{$dataForm->currency}}</td>
                            <td class="text-right"><input type="text" name="price_${iden}" id="price_${iden}" value="${newDivider2(value.price)}" hidden/><span id="price-text_${iden}">${newDivider1(value.price)}</span></td>
                            <td class="text-right"><input type="text" name="total_${iden}" id="total_${iden}" value="${newDivider2(value.total)}" hidden/><span id="total-text_${iden}">${newDivider1(value.total)}</span></td>
                            <td><textarea name="details_${iden}" id="details_${iden}" hidden>${value.detail === 'null' ? '' : (value.detail || '')}</textarea><span id="details-text_${iden}">${value.detail === 'null' ? '' : (value.detail || '')}</span><textarea name="details123_${iden}" id="details123_${iden}" hidden>${value.detail}</textarea></td>
            </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);
        var grandTotalRow = `<tr class="grandTotalRow">
                                <td class="text-center font-bold text-lg" colspan="3">Qty Total</td>
                                <td class="text-right font-bold text-lg" id="grandTotal_text"><span id="grandTotal_text">{{number_format($dataForm->qty, 0, ',', '.')}}</span></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;
        $("#tableProductAddBody").append(grandTotalRow);
        var grandTotalRow1 = `<tr class="grandTotalRow1">
                                <td class="text-center font-bold text-lg" colspan="3">Grand Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right font-bold text-lg" id="grandTotal_text1"><span id="grandTotal_text1">{{number_format($dataForm->gtotal, 0, ',', '.')}}</span></td>
                                <td></td>
                            </tr>`;
        $("#tableProductAddBody").append(grandTotalRow1);

    $('#myForm').submit(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Want to release {{$dataForm->no_form}} Fixed Asset!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Release it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with form submission
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (_response) {
                            if (_response.st == '0') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'SNFA Already Generated',
                                    icon: 'error',
                                }).then(() => {
                                    // Redirect to the specified URL after the success message is closed
                                    var urlRedirect = '/ga/fixedasset/list';
                                    window.open(urlRedirect, '_self');
                                });
                            } else if (_response.st == '1') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'SNFA Has Been Generated',
                                    icon: 'success',
                                }).then(() => {
                                    // Redirect to the specified URL after the success message is closed
                                    var urlRedirect = '/ga/fixedasset/list';
                                    window.open(urlRedirect, '_self');
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error',
                                text: 'error occurred',
                                icon: 'error',
                            }).then(() => {
                                // Redirect to the specified URL after the success message is closed
                                var urlRedirect = '/ga/fixedasset/list';
                                window.open(urlRedirect, '_self');
                            });
                        }
                    });
                }
            });
        });

        // $('#myForm').submit(function (e, params) {
        //     e.preventDefault();
        //     var formData = new FormData($(this)[0]);
        //     console.log(formData, $(this).attr('action'));
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Want to release {{$dataForm->no_form}} Fixed Asset!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, Release it!'
        //     }).then((result) => {
        //         $.ajax({
        //             url      : $(this).attr('action'),
        //             type     : 'POST',
        //             dataType : 'json',
        //             data: formData,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //                 success: function(_response){
        //                     if(_response.st == '1'){
        //                         var idRec = _response.id;
        //                         urlRedirect = '/ga/fixedasset/list';
        //                         window.open(urlRedirect, '_self');
        //                     } else if(_response.st == '0'){
        //                         alert('Terjadi kesalahan');
        //                     }
        //                 },
        //                     error: function(){
        //                     alert('Terjadi kesalahan');
        //                 }
        //         });
        //     })
        // })

        // $('#generateAsset').on("click", ".btn-generate",  function () {
        //     const idassets = $(this).data('id');
        //     $("input[name!='_token']").val("");
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Want to release {{$dataForm->no_form}} Fixed Asset!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, Release it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 headers: {
        //                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 type: "POST",
        //                 url: `/ga/fixedasset/generate`,
        //                 success: function (response) {
        //                 console.info("response: ", response)
        //                 }
        //              })
    
        //         }
        //     })
        // });
    </script>
    @endsection
</x-app-layout>