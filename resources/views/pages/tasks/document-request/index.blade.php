<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Document Request ✨
                        </h1>
            </div>
        </div>
        <div class="table-responsive">
            <table id="request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Offerings ID</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Addres</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Request To </th>
                        <th class="text-center">Uploaded Date</th>
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
                    url: "{{ route('document.getdata') }}",
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
                        data: "address",
                        name: "address"
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
                        data: "document_date",
                        name: "document_date"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4, 5] },
                    { className: 'flex justify-center', targets: [6] },
                ],  lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                
            }); 

            $('#request').on("click", ".btn-modal", function () {
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
                const address = $(this).data('address');

                $.ajax({
                    type: "GET",
                    url: `/tasks/document-request/getdetail/${offerings}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                        <div class="modal-content text-xs px-5 py-4">
                                            <input type="hidden" name="id_offering" value="${offerings}"/>
                                            <input type="hidden" name="offering_id" value="${id}"/>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name :<span
                                                class="text-rose-500">*</span>
                                                </label>
                                                <input id="company1" name="company1"
                                                    class="company1 form-input md:w-3/4 px-2 py-1 read-only:bg-slate-200 "
                                                    type="text" value="${company}" readonly required />
                                                <input id="companyId" name="companyId"
                                                    class="companyId form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                    type="text" value="" readonly required hidden/>
                                            </div>
                                            <div class="flex flex-col md:flex-row ml-5 mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Address :
                                                </label>
                                                <textarea id="description" name="description"
                                                    class="description form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" rows="3" readonly required>${address}</textarea>
                                            </div>
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
                                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="add_by1">Add By :<span
                                                                class="text-rose-500">*</span>
                                                                </label>
                                                                <input id="add_by1" name="add_by1"
                                                                    class="add_by1 form-input w-full md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                                                                    type="text" readonly required value="${by}" />
                                                            </div>
                                                        <div class="flex flex-row md:flex-row ml-5 mb-3">
                                                            <label class="block text-sm font-medium mb-1" for="task_id">Product List : <span
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
                                                                        <th class="text-sm text-center">Notes Document</th>
                                                                        <th class="text-sm text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                            
                                                                </tbody>
                                                        </table>
                                                            <div class="space-y-3">
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
                                            <td class="text-left"><input type="text" name="rows1[notes1]" value="${value.notes_document}" hidden/>${value.notes_document}</td>
                                            <td class="text-center flex flex-row justify-center">
                <a href = "/tasks/document-request/form/${offerings}/${value.product_id}" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white ml-3"
                >Upload Document</a>

                <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-docs text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDocument->id.'" 
                            data-offerings="'.$dataDocument->id_offerings.'" data-product="'.$dataDocument->product_id.'" data-img1="'.$dataDocument->img_1.'" data-img2="'.$dataDocument->img_2.'"
                            data-doc1="'.$dataDocument->doc1.'" data-doc2="'.$dataDocument->doc2.'" data-blob1="'.$dataDocument->blob1.'" data-blob2="'.$dataDocument->blob2.'"
                        >View Document</button>
            
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
                        <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Offering Product Document</div>
                                    <button class="text-slate-400 hover:text-slate-500"
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
                            <div class="modal-content">
                                <div class="px-5">
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div></div>
                                        <div class="${value.rnd_flag == 'Yes' ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">Offering Document Not Uploaded Yet</label>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.rnd_flag == 'Yes' ? '' : 'hidden'}">
                                            <label class="text-sm font-medium mb-1">View Document 1 :</label>
                                            <a href="/tasks/document-request/file1/${offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                        </div>
                                        <div></div>
                                        <div class="${value.rnd_flag == 'Yes' ? '' : 'hidden'}">
                                            <label class="text-sm font-medium mb-1">View Document 2 :</label>
                                            <a href="/tasks/document-request/file2/${offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Document</a>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div class="${value.photo1 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">View Image 1 :</label>
                                            <a href="/tasks/document-request/photo1/${offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_1}" width="259" height="142" alt="Product Image" />
                                        </div>
                                        <div></div>
                                        <div class="${value.photo2 == 1 ? 'hidden' : ''}">
                                            <label class="text-sm font-medium mb-1">View Image 2 :</label>
                                            <a href="/tasks/document-request/photo2/${offerings}/${value.product_id}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
                                            <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/${value.img_2}" width="259" height="142" alt="Product Image" />
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <!-- Modal footer -->
                            <div class="px-5 py-4 border-t border-slate-200">
                                <div class="flex flex-wrap justify-end space-x-2">
                                    <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
                                        Close
                                    </button>
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
            });

            
        });
    </script>
    @endsection
</x-app-layout>
