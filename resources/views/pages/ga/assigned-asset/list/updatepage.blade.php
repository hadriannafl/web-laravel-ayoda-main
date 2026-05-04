<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Assigned Asset Request 📝</h1>
        </div>
        <form action="{{ route('assigned-asset.update', ['idassign' => $dataAssigned->idrec]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Form Date</label>
                    <input id="date" name="date"
                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{date('d F Y', strtotime($dataAssigned->borrow_date))}}" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="type">Type Assigned
                    </label>
                    <input id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" 
                    value="{{$dataAssigned->type_assign}}" readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="company">Company
                    </label>
                        <input id="company" name="company"
                        class="company form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataAssigned->company}}" readonly/>
                        <input id="company1" name="company1"
                        class="company1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{$dataAssigned->id_company}}" hidden readonly/>
                </div>
                <div class="flex flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="employee1">Employee
                    </label>
                    <input class="employee form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" id="employee" name="employee" value="{{$dataAssigned->name}}" readonly>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add List Fixed Asset
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
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
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add RAB Item</div>
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
                                <div class="modal-content text-xs px-5 py-4">
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="nama_product">Fixed Asset Name :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="nama_product" name="nama_product"
                                        class="nama_product form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required/>
                                        <input id="assetId" name="assetId"
                                        class="assetId form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <input id="companiess1" name="companiess1"
                                        class="companiess1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <input id="warehouses1" name="warehouses1"
                                        class="warehouses1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text" readonly required hidden/>
                                        <div x-data="{ modalOpen: false }">
                                            <button type="button"
                                                class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="feedback-modal">
                                                <svg class="w-4 h-4" viewBox="0 0 16 16"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path class="fill-current text-slate-200"
                                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                                    <path class="fill-current text-slate-200"
                                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                                </svg>
                                                <span></span>
                                            </button>
                                            <!-- Modal backdrop -->
                                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="modalOpen"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true"
                                                x-cloak>
                                            </div>
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
                                                            <div class="font-semibold text-slate-800">Select Fixed Asset</div>
                                                            <button type="button"
                                                                class="text-slate-400 hover:text-slate-500"
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
                                                    <div class="modal-content text-xs px-5 py-4">
                                                        <div class="table-responsive">
                                                            <!-- label -->
                                                            <div class="flex flex-row mb-3">
                                                                <div class="rounded-full bg-sky-500 columns-1 h-5 w-5"></div>
                                                                <p class="flex flex-row ml-1 text-sm font-medium">Ready</p>
                                                                <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
                                                                <p class="flex flex-row ml-1 text-sm font-medium">In Use/Assigned</p>
                                                            </div>
                                                            <div class="flex flex-row text-xs mb-3">
                                                                <label class="flex flex-row text-xs">
                                                                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="status123">Available Status :</p>
                                                                    <select id="status123" class="status123 flex flex-row ml-3 mb-3 text-xs" name="status123">
                                                                        <option value="">All</option>
                                                                        @if ($dataAssigned->type_assign == 'Assign')
                                                                        <option value="Y" selected>Ready</option>
                                                                        @elseif($dataAssigned->type_assign == 'Return')
                                                                        <option value="N" selected>In Use/Assigned</option>
                                                                        @endif
                                                                    </select>
                                                            </div>
                                                            <table id="assetInv"
                                                                class="table table-striped table-bordered text-xs"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th class="text-center">Fixed Asset Code</th>
                                                                        <th class="text-center">Asset Name</th>
                                                                        <th class="text-center">Company</th>
                                                                        <th class="text-center">Warehouse Address</th>
                                                                        <th class="text-center">Available</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                    
                                                        <div class="space-y-3">
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="px-5 py-4 border-t border-slate-200">
                                                        <div class="flex flex-wrap justify-end space-x-2">
                                                            <button type="button"
                                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                                @click="modalOpen = false">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="remarks">Remarks
                                        </label>
                                        <input id="remarks" name="remarks"
                                            class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="text"/>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add List</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Fixed Asset Code</th>
                                <th class="text-sm text-center">Asset Name</th>
                                <th class="text-sm text-center">Company</th>
                                <th class="text-sm text-center">Warehouse Address</th>
                                <th class="text-sm text-center">Remarks</th> 
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                @if ($dataAssigned->approvalstat == 'Requested')
                <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                    <span class="xs:block ml-5 mr-5">Save Assigned Request</span>
                </button> </center>
                @endif
            </form>
    </div>

    @section('js-page')
    <script>
        $('#company1').on('change', function (e) {
            const site = $('#company1').val();
            if ($('#company1').val() !== null) {
                $('#company12').val(site);
                $('#company123').val(site);
                $('#employee-table').DataTable().ajax.reload();
                $('#assetInv').DataTable().ajax.reload();
            }
        })
        $(document).ready(function () {
            $('#assetInv').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "asc" ]],
                language: {
                            search: "Search Fixed Asset Code : "
                        },
                        ajax: {
                            url: "{{ route('fixedasset.getdata') }}",
                                data:function(d){                    
                                    d.status123 = $("#status123").val()
                                    d.company123 = $("#company1").val()
                                }
                        },
                        columns: [
                            {
                                data: "label",
                                name: "label"
                            },
                            {
                                data: "idfa",
                                name: "idfa"
                            },
                            {
                                data: "assetName",
                                name: "assetName"
                            },
                            {
                                data: "company",
                                name: "company"
                            },
                            {
                                data: "warehouse",
                                name: "warehouse"
                            },
                            {
                                data: "avail",
                                name: "avail"
                            },
                            {
                                data: "action",
                                name: "action"
                            },
                        ],
                        columnDefs: [
                            { className: 'text-center', targets: [1, 5, 6] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $('#status123').on('change', function (e) {
                $('#assetInv').DataTable().ajax.reload();
            })
            $('#company1').on('change', function (e) {
                $('#assetInv').DataTable().ajax.reload();
            })
        });

        $('#assetInv').on("click", ".btn-select", function () {
            const idAsset = $(this).data("id");
            const nameAsset = $(this).data("nama");
            const company = $(this).data("company");
            const warehouse = $(this).data("warehouse");
                        
            $("#assetId").val(idAsset);
            $("#nama_product").val(nameAsset);
            $("#companiess1").val(company);
            $("#warehouses1").val(warehouse);
        });

        // data product
            $(document).ready(function () {
                $("#addProduct").click(function () {
                    var id = $('#assetId').val();
                    var name = $('#nama_product').val();
                    var com = $('#companiess1').val();
                    var ware = $('#warehouses1').val();
                    var remarks = $('#remarks').val();

                    // Check for duplicate ID
                    var isDuplicate = $('#tableProductAddBody tr').filter(function () {
                        return $(this).find('[name*="[ids2]"]').val() === id;
                    }).length > 0;

                    if (isDuplicate) {
                        alert('Same Fixed Asset cannot be added again.');
                        return false;
                    }

                    var idExists = false;

                    console.log('Checking for id:', id);

                    $('#tableProductAddBody tr').each(function () {
                        var existingIdElement = $(this).find('[name^="ids"]');
                        if (existingIdElement.length > 0) {
                            var existingId = existingIdElement.val();
                            console.log('Existing ID:', existingId);
                            
                            if (id == existingId) {
                                idExists = true;
                                return false; // Exit the loop if the id is found
                            }

                        }
                    });

                    console.log('idExists:', idExists);

                    if (idExists) {
                        alert('Same Fixed Asset cannot be added again.');
                        return false;
                    }
                    
                        var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                        "  <td class=\"text-center\">" + id + "<textarea name = \"rows[" + productIdx + "][ids2]\" hidden>" + id + "</textarea></td>\n" +
                        "  <td class=\"text-left\">" + name + "</td>\n" +
                        "  <td class=\"text-left\">" + com + "</td>\n" +
                        "  <td class=\"text-left\">" + ware + "</td>\n" +
                        "  <td class=\"text-left\">" + remarks + "<textarea name = \"rows[" + productIdx + "][remarkss]\" hidden>" + remarks + "</textarea></td>\n" +
                        "  <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(" + productIdx + "," + null + ")\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
                        "</tr>";


                        if (!name || !id) {
                            return false;
                        }

                    $("#tableProductAddBody").append(tr);

                    $('#assetId').val('');
                    $('#nama_product').val('');
                    $('#companiess1').val('');
                    $('#warehouses1').val('');
                    $('#remarks').val('');

                    productIdx++;
                });
            });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataProducts = <?=$dataAssignedDetail?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            var iden = makeid(3);

            const prods = <?=$dataAssignedDetail?>;
            var modal_content = '';

            $.each(prods, function (i,item1) {
                if(value.idfa == item1.idfa){
                    modal_content += `<div class="modal-content text-xs px-5 py-4">
                                            <div class="flex justify-between flex-col md:flex-row mb-3">
                                                <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                                    for="remarks">Remarks :
                                                </label>
                                                <input id="remarks2_${iden}" name="remarks"
                                                    class="remarks form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                                    type="text" value="${value.remarks === 'null' ? '' : (value.remarks || '')}" />
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
                                                        @click="modalOpen = false" onclick="updateDataProduct('${iden}')">Update</button>
                                                </div>
                                            </div>
                                        </div>`
                }
                // console.log(item)
            })

            tableRow += `<tr id=row-${iden}>
                            <td class="text-center"><input type="text" name="iden[]" value="${iden}" hidden/><input type="text" name="ids_${iden}" value="${value.idfa}" hidden/><input type="text" name="createdby_${iden}" value="${value.created_by}" hidden/>${value.idfa}</td>
                            <td><input type="text" name="assetName_${iden}" id="assetName_${iden}" value="${value.assetName}" hidden/><input type="text" name="createdat_${iden}" value="${value.created_at}" hidden/>${value.assetName}</td>
                            <td>${value.company}<input type="text" name="company_${iden}" id="company_${iden}" value="${value.company}" hidden/></td>
                            <td><input type="text" name="warehouse_${iden}" id="warehouse_${iden}" value="${value.w_address}" hidden/>${value.w_address}</td>
                            <td><input type="text" name="remarks1_${iden}" id="remarks1_${iden}" value="${value.remarks}" hidden/><span id="remarks1_text_${iden}">${value.remarks === 'null' ? '' : (value.remarks || '')}</span></td>
                            <td class="flex flex-row justify-center">
                <button type="button" onclick="deleteDataProduct('${iden}', ${value.idrec})" class="btn btn-delete border-slate-200 hover:border-slate-300" > <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16"> <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></button>   
                <div x-data="{ modalOpen: false }">
                                <button class="ml-2 btn bg-emerald-500 hover:bg-emerald-600 text-white" type="button"
                                    @click.prevent="modalOpen = true" aria-controls="feedback-modal" onclick="rabCalcTypes('${iden}')">
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
                                                <div class="font-semibold text-slate-800">Edit Budget RAB Item</div>
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
                                        `+modal_content+`
                                    </div>
                                </div>
                </div>             
                </td>
                                        </tr>`;
        }
        $(".tableProductAddBody").find('tbody').append(tableRow);

        function updateDataProduct(iden) {
            var remarks = $('#remarks2_'+iden).val();
            $('#remarks1_'+iden).val(remarks);
            $('#remarks1_text_'+iden).text(remarks);

            console.log(iden, remarks);
        }
        
        function deleteDataProduct(positionTableRow, dataFromDatabase) {
            const positionTableRowVariable = positionTableRow;
            const dataFromDatabaseVariable = dataFromDatabase;
            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            console.log('dataFromDatabaseVariable:', dataFromDatabaseVariable);
            console.log('positionTableRowVariable:', positionTableRowVariable);

            if (dataFromDatabaseVariable !== null) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Want to Delete Assigned Asset!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: `/ga/assigned-asset/list/deleteitem/${dataFromDatabaseVariable}`,
                            success: function (response) {
                                console.info('response: ', response);
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Fixed Asset has been Deleted from List.',
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                    // Remove the corresponding row using the iden
                                    $(`#tableProductAddBody tr[id="row-${positionTableRowVariable}"]`).remove();
                                }
                            },
                            error: function (data) {
                                console.error('Error:', data);
                            }
                        });
                    }
                });
            } else if (dataFromDatabaseVariable === null) {
                // Remove the corresponding row by positionTableRow
                $(`#tableProductAddBody tr[id="row-${positionTableRowVariable}"]`).remove();
            }
            console.info('positionTableRowVariable: ', positionTableRowVariable);
            console.info('dataFromDatabaseVariable: ', dataFromDatabaseVariable);
        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    </script>
    @endsection
</x-app-layout>