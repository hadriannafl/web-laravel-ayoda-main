<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
               
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            {{date('F d, Y', strtotime(app('request')->input('start_time')))}}
                        </h1>
                        <h2 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Daily Product Offering Activity ✨
                        </h2>
            </div>
        </div>

        <select class="users_schedule ml-3 mb-3 text-xs" id="users_schedule" name="users_schedule" hidden>
            <option value=""></option>
                @foreach ($dataUsers as $dataUser)
                    <option value="{{ $dataUser->id }}" {{ $dataUser->id == app('request')->input('users_schedule') ? 'selected' : '' }}>{{ $dataUser->username }}</option>
                @endforeach
        </select>
        
        <input type="date" id="start_time" name="start_time" class="start_time form-input" value="{{ date('Y-m-d', strtotime(app('request')->input('start_time'))) }}" hidden></input>

        <div class="table-responsive">
            <table id="offering" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Offerings ID</th>
                        <th class="text-center">Start Time</th>
                        <th class="text-center">End Time</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">PIC</th>
                        <th class="text-center">Offering Tag</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#offering').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                language: {
                    search: "Search Customer:"
                },
                ajax: {
                    url: "{{ route('offering.getdata') }}",
                    data:function(d){
                        d.start_time = $("#start_time").val()
                        d.end_time = $("#end_time").val()
                    }
                },
                columns: [
                    {
                        data: "id_offerings",
                        name: "id_offerings"
                    },
                    {
                        data: "start_time",
                        name: "start_time"
                    },
                    {
                        data: "end_time",
                        name: "end_time"
                    },
                    {
                        data: "company_id",
                        name: "company_id"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "color_tag",
                        name: "color_tag"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2, 4, 5, 6 ] },
                    { className: 'flex justify-center', targets: [7] },
                ],  lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                
            });

            $(".start_time").on('change', function (e) {
                $('#offering').DataTable().ajax.reload();
            })  
            $(".end_time").on('change', function (e) {
                $('#offering').DataTable().ajax.reload();
            })  

            $('#offering').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const company = $(this).data('company');
                const pic = $(this).data('pic');
                const tag = $(this).data('tag');
                const start = $(this).data('start');
                const end = $(this).data('end');
                const notes = $(this).data('notes');
                const result = $(this).data('result');
                const by = $(this).data('by');
                const offerings = $(this).data('offerings');

                $.ajax({
                    type: "GET",
                    url: `/tasks/offering/productoffering/getdetail/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1 mt-2" for="company1">Company Name :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <input id="company1" name="company1"
                                                                class="company1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                type="text" value="${company}" readonly required/>
                                                        </div>
                                                        <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="pic1">PIC :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <input id="pic1" name="pic1"
                                                                class="pic1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                type="text" value="${pic}" readonly required/>
                                                        </div>
                                                        <div class="flex flex-row md:flex-row ml-5 mb-3">
                                                            <label class="block text-sm font-medium mb-1" for="task_id">Product : <span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                        </div>
                                                        <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody1"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-sm text-center">Product Name</th>
                                                                        <th class="text-sm text-center">Currency</th>
                                                                        <th class="text-sm text-center">Price</th>
                                                                        <th class="text-sm text-center">Minimun Order Qty</th>
                                                                        <th class="text-sm text-center">Quantity</th>
                                                                        <th class="text-sm text-center">Status</th>
                                                                        <th class="text-sm text-center">Document Status</th>
                                                                        <th class="text-sm text-center">Sample Status</th>
                                                                        <th class="text-sm text-center">Notes</th>
                                                                        <th class="text-sm text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                            
                                                                </tbody>
                                                        </table>
                                                        <div class="flex flex-col md:flex-row ml-5 mb-3 mt-3">
                                                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="offeringTag1">Offering Tag :<span
                                                            class="text-rose-500">*</span>
                                                            </label>
                                                            <select id="offeringTag1" name="offeringTag1" class="offeringTag1 form-select w-full md:w-1/2 px-2 py-1" disabled>
                                                                <option value="${tag}">${tag}</option>
                                                            </select>
                                                        </div>
                                                        <form method="post" class="form_offering_schedule" enctype="multipart/form-data" action="/tasks/offering/productoffering/offeringreschedule/${id}">
                                                            <input type="hidden" name="_token" value="${csrf_token}" />
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="start_time1">Start Date :<span
                                                                    class="text-rose-500">*</span></label>
                                                                <input id="start_time1" name="start_time1" class="start_time2 form-input px-2 py-1"
                                                                    type="datetime-local" required value="${start}"/>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="end_time1">End Date :<span
                                                                    class="text-rose-500">*</span></label>
                                                                <input id="end_time1" name="end_time1" class="end_time2 form-input px-2 py-1"
                                                                    type="datetime-local" required value="${end}"/>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notes1">Note :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <textarea id="notes1" name="notes1"
                                                                class="notes1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                type="text"required rows="3" value="">${notes}</textarea>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="notulens">Meeting Result :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <textarea id="notulens" name="notulens"
                                                                    class="notulens form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text"required rows="3" value="">${result}</textarea>
                                                            </div>
                                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="add_by1">Add By :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <input id="add_by1" name="add_by1"
                                                                    class="add_by1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text" readonly required value="${by}" />
                                                            </div>
                                                            <div class="space-y-3">
                                                            </div>
                                                            <!-- Modal footer -->
                                                            <div class="px-5 py-4 border-t border-slate-200 btn-action">
                                                                <div class="flex flex-wrap justify-end space-x-2 btn-action">
                                                                    <button type="button" data-id="${id}"
                                                                        class="btn-sm bg-red-400 border-slate-200 hover:border-slate-300 text-white btn-delete">
                                                                        Delete
                                                                    </button>
                                                                    <button type="submit" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">Reschedule</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                        `); 
                        let tableRow = '';
                        for (const value of response) {
                            tableRow += `<tr>
                                            <td><input type="text" name="rows1[ids1]" value="${value.product_id}" hidden/><input type="text" name="rows1[offer]" value="${value.id_offerings}" hidden/>${value.product_name}</td>
                                            <td class="text-center"><input type="text" name="rows1[m_currency1]" value="${value.m_currency}" hidden/>${value.m_currency}</td>
                                            <td class="text-right"><input type="text" name="rows1[price1]" value="${value.price}" hidden/>${value.price}</td>
                                            <td class="text-right"><input type="text" name="rows1[moqty1]" value="${value.moqty}" hidden/>${value.moqty}</td>
                                            <td class="text-right"><input type="text" name="rows1[qty1]" value="${value.qty}" hidden/>${value.qty}</td>
                                            <td class="text-center"><input type="text" name="rows1[status1]" value="${value.status}" hidden/>${value.status}</td>
                                            <td class="text-center"><input type="text" name="rows1[documentstatus1]" value="${value.rnd_flag}" hidden/>${value.rnd_flag}</td>
                                            <td class="text-center"><input type="text" name="rows1[samplestatus1]" value="${value.flag_sample}" hidden/>${value.flag_sample}</td>
                                            <td class="text-left"><input type="text" name="rows1[notes1]" value="${value.notes}" hidden/>${value.notes}</td>
                                            <td class="text-center flex flex-row justify-center">
                <div x-data="{ modalOpen: false }">
                    <button type="button" class="btn bg-emerald-500 hover:bg-emerald-600 text-white" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>img</title><g stroke-width="1" stroke-linejoin="round" fill="none" stroke="#ffff" stroke-linecap="round" class="nc-icon-wrapper"><polyline points="0.5 12.5 3.5 9.5 5.5 11.5 10.5 6.5 15.5 11.5" stroke="#ffff"></polyline><path d="M14,15.5H2A1.5,1.5,0,0,1,.5,14V2A1.5,1.5,0,0,1,2,.5H14A1.5,1.5,0,0,1,15.5,2V14A1.5,1.5,0,0,1,14,15.5Z"></path><circle cx="5" cy="5" r="1.5" stroke="#ffff"></circle></g></svg></button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                        x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        aria-hidden="true" x-cloak></div>
                    <!-- Modal dialog -->
                    <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                    <!-- Modal header -->
                    <div class="px-5 py-3 border-b border-slate-200">
                        <div class="flex justify-between items-center">
                            <div class="font-semibold text-slate-800">View Product Offering Image</div>
                                    <button type="button" class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('calendar.createschedule')}}" method="post">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="px-5">
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div></div>
                                        <div class="${value.photo2 == 1 ? '' : 'hidden'}">
                                            <label class="text-sm font-medium mb-1">Product Offering Image Not Uploaded Yet :</label>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Product Offering Image 1 :</label>
                                            <a href="/tasks/offering/productoffering/photo1/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_1}" width="259" height="142" alt="Product Image" />
                                        </div>
                                        <div></div>
                                        <div class="${value.photo2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Product Offering Image 2 :</label>
                                            <a href="/tasks/offering/productoffering/photo2/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_2}" width="259" height="142" alt="Product Image" />
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-data="{ modalOpen: false }">
                    <button type="button" class="btn bg-purple-500 hover:bg-purple-600 text-white ml-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 16 16"><title>file text</title><g stroke-width="1" stroke-linecap="round" stroke="#ffff" stroke-miterlimit="10" fill="none" class="nc-icon-wrapper w-4 h-4" stroke-linejoin="round"><line x1="4.5" y1="11.5" x2="11.5" y2="11.5" stroke="#ffff"></line> 
                            <line x1="4.5" y1="8.5" x2="11.5" y2="8.5" stroke="#ffff"></line> <line x1="4.5" y1="5.5" x2="6.5" y2="5.5" stroke="#ffff"></line> <polygon points="9.5,0.5 1.5,0.5 1.5,15.5 14.5,15.5 14.5,5.5 "></polygon> <polyline points="9.5,0.5 9.5,5.5 14.5,5.5 "></polyline></g>
                        </svg></button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                        x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        aria-hidden="true" x-cloak></div>
                    <!-- Modal dialog -->
                    <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                    <!-- Modal header -->
                    <div class="px-5 py-3 border-b border-slate-200">
                        <div class="flex justify-between items-center">
                            <div class="font-semibold text-slate-800">View Product Offering Document</div>
                                    <button type="button" class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="px-5">
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div></div>
                                        <div class="${value.photo2 == 1 ? '' : 'hidden'}">
                                            <label class="text-sm font-medium mb-1">Product Offering Document Not Uploaded Yet :</label>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Product Offering Document 1 :</label>
                                            <a href="/tasks/offering/productoffering/file1/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                        </div>
                                        <div></div>
                                        <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Product Offering Document 2 :</label>
                                            <a href="/tasks/offering/productoffering/file2/${value.id_offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                </td>
                                        </tr>`;
                                    }
                            $(".tableProductAddBody1").find('tbody').append(tableRow);
                    },
                });
                // <form method="post" class="form_do_update" enctype="multipart/form-data" action="/logistic/doupdate/${id}">
                //                     <input type="hidden" name="_token" value="${csrf_token}" />
                //                     <div class="grid md:grid-cols-3 gap-3 mt-3">
                //                         <div>
                //                             <label class="block text-sm font-medium mb-1" for="file">AWB DO Upload:</label>
                //                             <input name="photo1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/*" onchange="loadFileMultiple(event, 'output1-${id}')" required />
                //                             <img id="output1-${id}" style="max-width: 300px; max-height: 150px"/>
                //                         </div>
                //                         <div></div>
                //                         <div>
                //                             <label class="block text-sm font-medium mb-1" for="file">Signed DO Upload:</label>
                //                             <input name="photo2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/*" onchange="loadFileMultiple(event, 'output2-${id}')" required />
                //                             <img id="output2-${id}" style="max-width: 300px; max-height: 150px"/>
                //                         </div>
                //                     </div>
                //                     <div class="grid md:grid-cols-3 gap-3 mt-3">
                //                             <input type="submit" value="Delivery Confirmed" name="status" class="btn-sm bg-green-500 hover:bg-green-600 text-white" />
                //                             <input type="submit" value="Partially Delivered" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" />
                //                             <input type="submit" value="Lost in Delivery" name="status" class="btn-sm bg-red-400 border-slate-200 hover:bg-red-500 text-white" />
                //                     </div>
                //                 </form>
            });

            $('#offering').on("click", ".btn-delete",  function () {
                const id_offering = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Product Offering!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `/tasks/offering/productoffering/offeringdelete/${id_offering}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Offering has been deleted.',
                                        message
                                    )
                                    window.location.reload(true);
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });

            
        });
    </script>
    @endsection
</x-app-layout>