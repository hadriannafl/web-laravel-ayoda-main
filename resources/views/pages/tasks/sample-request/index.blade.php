<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Sample Request ✨
                        </h1>
            </div>
        </div>
        <div class="table-responsive">
            <table id="request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Offerings ID</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Sample Item</th>
                        <th class="text-center">Sample Sent</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Request To </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#request').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search Offerings ID:"
                },
                ajax: {
                    url: "{{ route('sample.getdata') }}",
                },
                columns: [
                    {
                        data: "id_offerings",
                        name: "id_offerings"
                    },
                    {
                        data: "company_id",
                        name: "company_id"
                    },
                    {
                        data: "item_count",
                        name: "item_count"
                    },
                    {
                        data: "sample_flag",
                        name: "sample_flag"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "request_to",
                        name: "request_to"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2, 3, 4, 5, 6] },
                ],  lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                
            }); 

            // $('#request').on("click", ".btn-modal", function () {
            //     const id = $(this).data('id');
            //     const company = $(this).data('company');
            //     const address = $(this).data('address');
            //     const flag = $(this).data('flag');
            //     const offerings = $(this).data('offerings');

            //     $.ajax({
            //         type: "GET",
            //         url: `/tasks/document-request/getdetail/${id}`,
            //         success: function (response) {
            //             const csrf_token = $('meta[name="csrf-token"]').attr('content');

            //             $(".modal-content").html(`
            //             <form method="post" class="sample_update" enctype="multipart/form-data" action="/tasks/sample-request/update/${offerings}/${id}">
            //                 <input type="hidden" name="_token" value="${csrf_token}" />
            //                         <div class="modal-content text-xs px-5 py-4">
            //                                 <input type="" name="id_offering" value="${offerings}"/>
            //                                 <input type="hidden" name="offering_id" value="${id}"/>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
            //                                     class="text-rose-500">*</span>
            //                                     </label>
            //                                     <input id="company" name="company"
            //                                         class="company form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 "
            //                                         type="text" value="${company}" readonly required />
            //                                     <input id="companyId" name="companyId"
            //                                         class="companyId form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
            //                                         type="text" value="" readonly required hidden/>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="address">Address :
            //                                     </label>
            //                                     <textarea id="address" name="address"
            //                                         class="address form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly required>${address}</textarea>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Sample Delivery Date :
            //                                     </label>
            //                                     <input id="date" name="date" type="date" value="{{date('Y-m-d')}}"
            //                                         class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
            //                                         required/>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
            //                                         for="currency3">Currency :
            //                                     </label>
            //                                     <select id="currency3" name="currency3"
            //                                         class="currency3 form-select w-full md:w-3/4 px-2 py-1">
            //                                         <option value="Yes" ${flag == "Yes" ? ' selected' : '' }>Yes</option>
            //                                         <option value="No" ${flag == "No" ? ' selected' : '' }>No</option>
            //                                     </select>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes">Sample Delivery Note :
            //                                     </label>
            //                                     <textarea id="notes" name="notes"
            //                                         class="notes form-input w-full md:w-3/4 px-2 py-1" rows="3" required></textarea>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <label class="block text-sm font-medium mb-1" for="task_id">Product Sample :
            //                                     </label>
            //                                 </div>
            //                                 <div class="flex flex-col md:flex-row ml-5 mb-3">
            //                                     <table id="tableSampleRequest" class="tableSampleRequest table table-striped table-bordered mt-3"
            //                                         style="width:100%">
            //                                         <thead>
            //                                             <tr>
            //                                                 <th class="text-sm text-center">Check</th>
            //                                                 <th class="text-sm text-center">Product Name</th>
            //                                                 <th class="text-sm text-center">Currency</th>
            //                                                 <th class="text-sm text-center">Price</th>
            //                                                 <th class="text-sm text-center">Sample Qty</th>
            //                                                 <th class="text-sm text-center">Sample Status</th>
            //                                                 <th class="text-sm text-center">Notes Sample</th>
            //                                                 <th class="text-sm text-center">Action</th>
            //                                             </tr>
            //                                         </thead>
            //                                         <tbody class="tableSampleRequest" id="tableSampleRequest">
                    
            //                                         </tbody>
            //                                     </table>

            //                                 <div class="space-y-3">
            //                                 </div>
            //                         </div>
            //                         <!-- Modal footer -->
            //                                 <div class="px-5 py-4 border-t border-slate-200">
            //                                     <div class="flex flex-wrap justify-end space-x-2">
            //                                         <button type="button"
            //                                             class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
            //                                             @click="modalOpen = false">Close</button>
            //                                         <button type="submit"
            //                                             class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
            //                                             id="addProposal">Make Sample Delivery Reff</button>
            //                                     </div>
            //                                 </div>
            //                 </form>
            //             `); 
            //             $.ajaxSetup({
            //                 headers: {
            //                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //                 }
            //             });
            //             let tableRow = '';
            //             for (const value of response) {
            //                 var idens = makeid(3);
            //                 var modal_content1 = '';
            //                         modal_content1 += `<div class="modal-content text-xs px-5 py-4">
            //                                                 <div class="flex justify-between flex-col md:flex-row mb-3">
            //                                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
            //                                                         for="currency3">Currency :
            //                                                     </label>
            //                                                     <select id="currency3_${idens}" name="currency3"
            //                                                         class="currency3 form-select w-full md:w-3/4 px-2 py-1">
            //                                                         <option selected hidden>Set Currency</option>
            //                                                         <option value="AUD" ${value.m_currency == "AUD" ? ' selected' : '' }>AUD</option>
            //                                                         <option value="EUR" ${value.m_currency == "EUR" ? ' selected' : '' }>EUR</option>
            //                                                         <option value="GBP" ${value.m_currency == "GBP" ? ' selected' : '' }>GBP</option>
            //                                                         <option value="IDR" ${value.m_currency == "IDR" ? ' selected' : '' }>IDR</option>
            //                                                         <option value="JPY" ${value.m_currency == "JPY" ? ' selected' : '' }>JPY</option>
            //                                                         <option value="SGD" ${value.m_currency == "SGD" ? ' selected' : '' }>SGD</option>
            //                                                         <option value="USD" ${value.m_currency == "USD" ? ' selected' : '' }>USD</option>
            //                                                     </select>
            //                                                 </div>
            //                                                 <div class="flex justify-between flex-col md:flex-row mb-3">
            //                                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
            //                                                         for="product_price3">Product Price :
            //                                                     </label>
            //                                                     <input id="product_price3_${idens}" name="product_price3"
            //                                                         class="product_price3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
            //                                                         type="number" value="${value.price}"/>
            //                                                 </div>
            //                                                 <div class="flex justify-between flex-col md:flex-row mb-3">
            //                                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
            //                                                         for="order_quantity3">Delivery Sample Quantity :
            //                                                     </label>
            //                                                     <input id="order_quantity3_${idens}" name="order_quantity3"
            //                                                         class="order_quantity3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
            //                                                         type="number" value="${value.sample_qty}"/>
            //                                                 </div>
            //                                                 <div class="flex justify-between flex-col md:flex-row mb-3">
            //                                                     <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
            //                                                         for="product_note3">Notes :
            //                                                     </label>
            //                                                     <textarea id="product_note3_${idens}" name="product_note3"
            //                                                         class="product_note3 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
            //                                                         type="text" rows="2">${value.notes_sample}</textarea>
            //                                                 </div>

            //                                                 <div class="space-y-3">
            //                                                 </div>

            //                                                 <!-- Modal footer -->
            //                                                 <div class="px-5 py-4 border-t border-slate-200">
            //                                                     <div class="flex flex-wrap justify-end space-x-2">
            //                                                         <button type="button"
            //                                                             class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
            //                                                             @click="modalOpen = false">Close</button>
            //                                                         <button type="button"
            //                                                             class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
            //                                                             @click="modalOpen = false" onclick="updateDataProduct1('${idens}')">Update</button>
            //                                                     </div>
            //                                                 </div>
            //                                             </div>`
            //                 tableRow += `<tr>
            //                                 <td class="text-center"><input class="mt-1" type="checkbox" id="check_${idens}" name="check_${idens}" value="1"/></td>
            //                                 <td><input type="text" name="idens[]" value="${idens}" hidden/><input type="text" name="ids1_${idens}" value="${value.product_id}" hidden/><input type="text" name="ids2" value="${value.product_id}" hidden/>${value.product_name}</td>
            //                                 <td class="text-center"><input type="text" name="m_currency1_${idens}" id="m_currency1_${idens}" value="${value.m_currency}" hidden/><span id="m_currency1_text_${idens}">${value.m_currency}</span></td>
            //                                 <td class="text-right"><input type="text" name="price1_${idens}" id="price1_${idens}" value="${value.price}" hidden/><span id="price1_text_${idens}">${value.price}</span></td>
            //                                 <td class="text-right"><input type="text" name="qty1_${idens}" id="qty1_${idens}" value="${value.sample_qty}" hidden/><span id="qty1_text_${idens}">${value.sample_qty}</span></td>
            //                                 <td class="text-center"><input type="text" name="flag_sample1_${idens}" id="flag_sample1_${idens}" value="${value.flag_sample}" hidden/>${value.flag_sample}</span></td>
            //                                 <td class="text-left"><input type="text" name="notes1_${idens}" id="notes1_${idens}" value="${value.notes_sample}" hidden/><span id="notes1_text_${idens}">${value.notes_sample}</span></td>
            //                                 <td class="block text-center justify-center flex flex-row">
            //                 <div x-data="{ modalOpen: false }">
            //                         <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
            //                             @click.prevent="modalOpen = true" aria-controls="feedback-modal">
            //                             <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>pen</title><g stroke-width="1" stroke-linecap="round" fill="none" stroke="#ffff" stroke-miterlimit="10" class="nc-icon-wrapper" stroke-linejoin="round"><line x1="10" y1="3" x2="13" y2="6" data-cap="butt" stroke="#ffff"></line> <polygon points="12,1 15,4 5,14 1,15 2,11 " data-cap="butt"></polygon> </g></svg>
            //                             <span></span>
            //                         </button>
            //                         <!-- Modal backdrop -->
            //                         <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
            //                             x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
            //                             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            //                             x-transition:leave="transition ease-out duration-100"
            //                             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            //                             aria-hidden="true" x-cloak></div>
            //                         <!-- Modal dialog -->
            //                         <div id="feedback-modal"
            //                             class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
            //                             role="dialog" aria-modal="true" x-show="modalOpen"
            //                             x-transition:enter="transition ease-in-out duration-200"
            //                             x-transition:enter-start="opacity-0 translate-y-4"
            //                             x-transition:enter-end="opacity-100 translate-y-0"
            //                             x-transition:leave="transition ease-in-out duration-200"
            //                             x-transition:leave-start="opacity-100 translate-y-0"
            //                             x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

            //                             <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
            //                                 @click.outside="modalOpen = false"
            //                                 @keydown.escape.window="modalOpen = false">
            //                                 <!-- Modal header -->
            //                                 <div class="px-5 py-3 border-b border-slate-200">
            //                                     <div class="flex justify-between items-center">
            //                                         <div class="font-semibold text-slate-800">Custom Offering Sample</div>
            //                                         <button type="button" class="text-slate-400 hover:text-slate-500"
            //                                             @click="modalOpen = false">
            //                                             <div class="sr-only">Close</div>
            //                                             <svg class="w-4 h-4 fill-current">
            //                                                 <path
            //                                                     d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
            //                                             </svg>
            //                                         </button>
            //                                     </div>
            //                                 </div>
            //                                 <!-- Modal content -->
            //                                 `+modal_content1+`
            //                             </div>
            //                         </div>
            //                 </div>    
            //                         </td>  
            //                     </tr>`;
            //                         }
            //                         $(".tableSampleRequest").find('tbody').append(tableRow);
            //         },
            //     });
            //     function makeid(length) {
            //         var result           = '';
            //         var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            //         var charactersLength = characters.length;
            //         for ( var i = 0; i < length; i++ ) {                       
            //         result += characters.charAt(Math.floor(Math.random() * charactersLength));
            //         }
            //         return result;
            //     }
            // });

        });
        // function updateDataProduct1(idens) {
        //                     var currency1 = $('#currency3_'+idens).val();
        //                     $('#m_currency1_'+idens).val(currency1);
        //                     $('#m_currency1_text_'+idens).text(currency1);

        //                     var price1 = $('#product_price3_'+idens).val();
        //                     $('#price1_'+idens).val(price1);
        //                     $('#price1_text_'+idens).text(price1);

        //                     var oq1 = $('#order_quantity3_'+idens).val();
        //                     $('#qty1_'+idens).val(oq1);
        //                     $('#qty1_text_'+idens).text(oq1);
                                                
        //                     var notes1 = $('#product_note3_'+idens).val();
        //                     $('#notes1_'+idens).val(notes1);
        //                     $('#notes1_text_'+idens).text(notes1);
        //                     console.log(idens,currency1,price1,oq1,notes1);
        //                     console.log($('#m_currency1_'+idens))
        //                     console.log($('#m_currency1_'+idens).val())          
        //                 }

    </script>
    @endsection
</x-app-layout>
