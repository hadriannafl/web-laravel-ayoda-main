<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    BD - Annual Budgeting 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 mt-1 text-sm" for="year">Year :</p>
                    <select id="year" class="year flex flex-row ml-3 mb-3 text-xs" name="year">
                        <option value="">All</option>
                        <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                        <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                    </select>

                {{-- <div x-data="{ modalOpen: false }">
                    <button class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>Create New Budgeting</button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                        x-cloak></div>
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
                        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                        @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Create Budgeting</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('budget.create')}}" method="post">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="sales_id">Sales Representative<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="username" name="username" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="{{Auth::user()->username}}" readonly required/>
                                            <input id="sales_id" name="sales_id" class="form-input w-full px-2 py-1" type="text" value="{{Auth::user()->sales_id}}" hidden required/>
                                        </div>
                                        <div>
                                            
                                            <label class="block text-sm font-medium mb-1" for="periode">Periode<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="periode" name="periode"
                                                class=" periode form-input w-full px-2 py-1" type="date"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="sales">Budget Sales<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="b_sales" name="b_sales" type="number"
                                                class=" b_sales form-input w-full px-2 py-1"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="customer">Budget Customer<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="b_customer" name="b_customer" type="number"
                                                class=" b_customer form-input w-full px-2 py-1"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="product">Budget Product<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="b_product" name="b_product" type="number"
                                                class=" b_product form-input w-full px-2 py-1"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="offer">Budget Offering<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="b_offering" name="b_offering" type="number"
                                                class=" b_offering form-input w-full px-2 py-1"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="px-5 py-4 border-t border-slate-200">
                                    <div class="flex flex-wrap justify-end space-x-2">
                                        <button type="button"
                                            class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                            @click="modalOpen = false">Cancel</button>
                                        <button type="submit" id="submit"
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                
            </label>
        </div>
        <div class="table-responsive">
            <table id="total" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Year</th>
                        <th class="text-center">Total Budget Sales</th>
                        <th class="text-center">Total Budget Customer (IDR)</th>
                        <th class="text-center">Total Budget Customer (Qty) - Year</th>
                        <th class="text-center">Total Budget Product (IDR)</th>
                        <th class="text-center">Total Budget Product (Qty) - Year</th>
                        <th class="text-center">Total Budget Offering</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive mt-5">
            <table id="budget" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Sales Representative</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Budget Sales</th>
                        <th class="text-center">Budget Customer (IDR)</th>
                        <th class="text-center">Budget Customer (Qty) - Year</th>
                        <th class="text-center">Budget Product (IDR)</th>
                        <th class="text-center">Budget Product (Qty) - Year</th>
                        <th class="text-center">Budget Offering</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#budget').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                "order": [[ 9, "asc" ]],
                ajax: {
                    url: "{{ route('budget.getdata') }}",
                    data:function(d){
                        d.year = $("#year").val()
                    }
                },
                columns: [
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "b_sales",
                        name: "b_sales"
                    },
                    {
                        data: "b_customer",
                        name: "b_customer"
                    },
                    {
                        data: "b_customer_qty",
                        name: "b_customer_qty"
                    },
                    {
                        data: "b_product",
                        name: "b_product"
                    },
                    {
                        data: "b_product_qty",
                        name: "b_product_qty"
                    },
                    {
                        data: "b_offering",
                        name: "b_offering"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 8] },
                    { className: 'text-right', targets: [2, 3, 4, 5, 6, 7] },
                    { className: 'flex justify-center', targets: [9] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".year").on('change', function (e) {
                $('#budget').DataTable().ajax.reload();
            })

            $('#budget').on("click", ".btn-edit", function () {
                const budgetId = $(this).data('id');
                const sales = $(this).data('sales');
                const periode = $(this).data('periode');
                const users = $(this).data('users');
                const b_sales = $(this).data('b_sales');
                const b_customer = $(this).data('b_customer');
                const b_customer_qty = $(this).data('b_customer_qty');
                const b_product = $(this).data('b_product');
                const b_product_qty = $(this).data('b_product_qty');
                const b_offering = $(this).data('b_offering');

                $.ajax({
                    type: "GET",
                    url: `/tasks/budget/getdata/${budgetId}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/kpi/budget/update/${budgetId}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="sales_id">Sales Representative<span class="text-rose-500">*</span></label>
                                                <input id="username" name="username1" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${users}" readonly required/>
                                                <input id="sales_id" name="sales_id1" class="form-input w-full px-2 py-1" type="text" value="${sales}" hidden required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="periode">Periode<span class="text-rose-500">*</span></label>
                                                <input id="periode" name="periode1" class=" periode form-input w-full px-2 py-1 read-only:bg-slate-200" type="date" value="${periode}" required readonly/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="sales">Budget Sales<span class="text-rose-500">*</span></label>
                                                <input id="b_sales" name="b_sales1" type="number" class=" b_sales form-input w-full px-2 py-1" value="${b_sales}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="customer">Budget Customer (IDR)<span class="text-rose-500">*</span></label>
                                                <input id="b_customer" name="b_customer1" type="number" class=" b_customer form-input w-full px-2 py-1" value="${b_customer}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="customer">Budget Customer (Qty) - Year<span class="text-rose-500">*</span></label>
                                                <input id="b_customer_qty" name="b_customer_qty_1" type="number" class=" b_customer_qty form-input w-full px-2 py-1" value="${b_customer_qty}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="product">Budget Product (IDR)<span class="text-rose-500">*</span></label>
                                                <input id="b_product" name="b_product1" type="number" class=" b_product form-input w-full px-2 py-1" value="${b_product}" required />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="product">Budget Product (Qty) - Year<span class="text-rose-500">*</span></label>
                                                <input id="b_product_qty" name="b_product_qty_1" type="number" class=" b_product_qty form-input w-full px-2 py-1" value="${b_product_qty}" required />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="offer">Budget Offering<span class="text-rose-500">*</span></label>
                                                <input id="b_offering" name="b_offering1" type="number" class=" b_offering form-input w-full px-2 py-1" value="${b_offering}" required />
                                            </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Cancel</button>
                                            <button type="submit"
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Change</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });
            $('#total').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "paging":   false,
                "searching": false,
                "order": [[ 0, "desc" ]],
                ajax: {
                    url: "{{ route('budget.getdata1') }}",
                    data:function(d){
                        d.year = $("#year").val()
                    }
                },
                columns: [
                    {
                        data: "year",
                        name: "year"
                    },
                    {
                        data: "sales",
                        name: "sales"
                    },
                    {
                        data: "cust",
                        name: "cust"
                    },
                    {
                        data: "cust1",
                        name: "cust1"
                    },
                    {
                        data: "product",
                        name: "product"
                    },
                    {
                        data: "product1",
                        name: "product1"
                    },
                    {
                        data: "offer",
                        name: "offer"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                    { className: 'text-right', targets: [1, 2, 3, 4, 5, 6] }
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".year").on('change', function (e) {
                $('#total').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>