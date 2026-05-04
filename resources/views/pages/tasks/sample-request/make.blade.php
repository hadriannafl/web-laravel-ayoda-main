<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Update Sample Request ✨
                        </h1>
            </div>
        </div>
        <form method="post" id="myForm" class="sample_update" enctype="multipart/form-data" action="{{ route('sample.update', ['offeringId' => $dataSample->id_offerings])}}">
            @csrf
                    <div class="modal-content text-xs px-5 py-4">
                            <input type="hidden" name="id_offering" value="{{$dataSample->id_offerings}}"/>
                            <input type="hidden" name="offering_id" value="{{$dataSample->id}}"/>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
                                class="text-rose-500">*</span>
                                </label>
                                <input id="company" name="company"
                                    class="company form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 "
                                    type="text" value="{{$dataSample->company_id}}" readonly required />
                                <input id="companyId" name="companyId"
                                    class="companyId form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                    type="text" value="" readonly required hidden/>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Address :
                                </label>
                                <textarea id="address" name="address"
                                    class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly required>{{$dataSample->address}}</textarea>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                    for="sent">Sample Sent :
                                </label>
                                <input id="sent" name="sent" type="sent" value="{{$dataSample->sample_flag}}"
                                class="sent form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                required readonly/>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Sample Delivery Date :
                                </label>
                                <input id="date" name="date" type="date" value="{{date('Y-m-d')}}"
                                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                    required/>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Sample Delivery Note :
                                </label>
                                <textarea id="notes" name="notes"
                                    class="notes form-input w-full md:w-3/4 px-2 py-1" rows="3"></textarea>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <label class="block text-sm font-medium mb-1" for="task_id">Product Sample :
                                </label>
                            </div>
                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                <table id="tableSampleRequest" class="tableSampleRequest table table-striped table-bordered mt-3"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-sm text-center">Check</th>
                                            <th class="text-sm text-center">Product Name</th>
                                            <th class="text-sm text-center">Sample Qty</th>
                                            <th class="text-sm text-center">Sample Status</th>
                                            <th class="text-sm text-center">Principle</th>
                                            <th class="text-sm text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableSampleRequest" id="tableSampleRequest">
    
                                    </tbody>
                                </table>

                            <div class="space-y-3">
                            </div>
                    </div>
                    <center>
                        @if ($dataSample->sample_flag != 'Yes')
                            <button type="submit"class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white disabled:bg-indigo-500"
                            id="toPrint" disabled>Make Sample Delivery Reff</button>
                        @endif
                    </center>
            </form>
    </div>

    @section('js-page')
    <script>
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        const dataProducts = <?=$dataSamp?>;
                        let tableRow = '';
                        for (const value of dataProducts) {
                            var idens = makeid(3);
                            var modal_content1 = '';
                                    modal_content1 += `<div class="modal-content text-xs px-5 py-4">
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="order_quantity3">Delivery Sample Quantity :
                                                                </label>
                                                                <input id="order_quantity3_${idens}" name="order_quantity3"
                                                                    class="order_quantity3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="text" value="${value.sample_qty}"/>
                                                            </div>
                                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                                    for="product_note3">Principle :
                                                                </label>
                                                                <textarea id="product_note3_${idens}" name="product_note3"
                                                                    class="product_note3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                                    type="text" rows="2">${value.notes_sample}</textarea>
                                                            </div>

                                                            <div class="space-y-3">
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="px-5 py-4 border-t border-slate-200">
                                                                <div class="flex flex-wrap justify-end space-x-2">
                                                                    <button type="button"
                                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                                        @click="modalOpen = false">Close</button>
                                                                    <button type="button"
                                                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                        @click="modalOpen = false" onclick="updateDataProduct1('${idens}')">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>`
                            tableRow += `<tr>
                                            <td class="text-center"><input type="text" name="idens[]" value="${idens}" hidden/><input class="mt-1 ${value.flag_sample == 'Yes' ? 'hidden':''}" type="checkbox" id="check_${idens}" name="check_${idens}" value="1"/><input type="text" name="offering_${idens}" value="${value.id}" hidden/><input type="text" name="offerings_${idens}" value="${value.id_offerings}" hidden/></td>
                                            <td class="text-left">${value.product_name}<input type="text" name="ids1_${idens}" value="${value.product_id}" hidden/><input type="text" name="ids2" value="${value.product_id}" hidden/><input type="text" name="quantity_${idens}" value="${value.qty}" hidden/><input type="text" name="moqty_${idens}" value="${value.moqty}" hidden/><input type="text" name="stat_${idens}" value="${value.status}" hidden/></td>
                                            <td class="text-center" hidden><input type="text" name="m_currency1_${idens}" id="m_currency1_${idens}" value="${value.m_currency}" hidden/><span id="m_currency1_text_${idens}">${value.m_currency}</span><input type="text" name="notes_${idens}" value="${value.notes}" hidden/><input type="text" name="rnd_user_${idens}" value="${value.rnd_user_id}" hidden/><input type="text" name="rnd_flag_${idens}" value="${value.rnd_flag}" hidden/></td>
                                            <td class="text-right" hidden><input type="text" name="price1_${idens}" id="price1_${idens}" value="${value.price}" hidden/><span id="price1_text_${idens}">${value.price}</span><input type="text" name="document_date_${idens}" value="${value.document_date}" hidden/><input type="text" name="document_sent_by_${idens}" value="${value.document_sent_by}" hidden/><input type="text" name="sample_user_${idens}" value="${value.sample_user_id}" hidden/><input type="text" name="img1_${idens}" value="${value.img_1}" hidden/></td>
                                            <td class="text-right"><input type="text" name="qty1_${idens}" id="qty1_${idens}" value="${value.sample_qty}" hidden/><span id="qty1_text_${idens}">${value.sample_qty}</span><input type="text" name="img2_${idens}" value="${value.img_2}" hidden/><input type="text" name="show_${idens}" value="${value.show_product}" hidden/><input type="text" name="notes_document_${idens}" value="${value.notes_document}" hidden/><input type="text" name="created_at_${idens}" value="${value.created_at}" hidden/></td>
                                            <td class="text-center"><input type="text" name="flag_sample1_${idens}" id="flag_sample1_${idens}" value="${value.flag_sample}" hidden/>${value.flag_sample}</span></td>
                                            <td class="text-left"><input type="text" name="notes1_${idens}" id="notes1_${idens}" value="${value.notes_sample}" hidden/><span id="notes1_text_${idens}">${value.notes_sample}</span></td>
                                            <td class="text-center">
                            <div x-data="{ modalOpen: false }">
                                    <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white ${value.flag_sample == 'Yes' ? 'hidden':''}" type="button"
                                        @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
                                        <span></span>
                                    </button>
                                    <!-- Modal backdrop -->
                                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                        x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-out duration-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        aria-hidden="true" x-cloak></div>
                                    <!-- Modal dialog -->
                                    <div id="feedback-modal"
                                        class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                        role="dialog" aria-modal="true" x-show="modalOpen"
                                        x-transition:enter="transition ease-in-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in-out duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                                        <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                                            @click.outside="modalOpen = false"
                                            @keydown.escape.window="modalOpen = false">
                                            <!-- Modal header -->
                                            <div class="px-5 py-3 border-b border-slate-200">
                                                <div class="flex justify-between items-center">
                                                    <div class="font-semibold text-slate-800">Custom Offering Sample</div>
                                                    <button type="button" class="text-slate-400 hover:text-slate-500"
                                                        @click="modalOpen = false">
                                                        <div class="sr-only">Close</div>
                                                        <svg class="w-4 h-4 fill-current">
                                                            <path
                                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal content -->
                                            `+modal_content1+`
                                        </div>
                                    </div>
                            </div>    
                                    </td>  
                                </tr>`;
                        }
                        $(".tableSampleRequest").find('tbody').append(tableRow);
            function makeid(length) {
                    var result           = '';
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    var charactersLength = characters.length;
                    for ( var i = 0; i < length; i++ ) {                       
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                    return result;
                }

        function updateDataProduct1(idens) {
                            var oq1 = $('#order_quantity3_'+idens).val();
                            $('#qty1_'+idens).val(oq1);
                            $('#qty1_text_'+idens).text(oq1);
                            $('#check_'+idens).prop('checked', true);
                            $('#toPrint').removeAttr('disabled');
                                                
                            var notes1 = $('#product_note3_'+idens).val();
                            $('#notes1_'+idens).val(notes1);
                            $('#notes1_text_'+idens).text(notes1);
                            console.log(idens,oq1,notes1);
                            console.log($('#m_currency1_'+idens))
                            console.log($('#m_currency1_'+idens).val())          
                        }

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
                                    if(_response.st == '1'){
                                        urlRedirect = '/tasks/sample-request/delivery-reff/'+_response.id;
                                        window.open(urlRedirect, '_self');
                                    } else if(_response.st == '0'){
                                        alert('Terjadi kesalahan');
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
