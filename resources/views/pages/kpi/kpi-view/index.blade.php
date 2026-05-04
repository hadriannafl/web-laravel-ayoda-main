<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    BD - KPI View 🗄️
                </h1>
            </div>
        </div>

        {{-- <form class="mb-5" id="form-filter">
            <div class="relative ml-2">
                <input id="form-search" class="form-input w-60 pl-9" placeholder="Data In {{date('Y')}}" type="number" min="1999"
                    max="2050" autocomplete="off">
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z">
                        </path>
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z">
                        </path>
                    </svg>
                </button>
            </div>
        </form> --}}

        <div class="grid grid-cols-12 gap-6">
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                    <h2 class="font-semibold text-slate-800">Global Sales Achievement</h2>
                    @endif
                    @if (Auth::user()->role == '202' || Auth::user()->role == '203')
                    <h2 class="font-semibold text-slate-800">Sales Achievement</h2>
                    @endif
                </header>
                <form class="flex justify-end mb-3 mt-3" id="form-achiev">
                    <label class="block text-sm font-medium text-lg mt-1" for="form-search">Year :</label>
                    <div class="relative ml-2 w-3/4 md:w-1/4">
                        <select id="achiev-search" name = "year" class="getAchiev form-input w-20">
                            <option value="2020" {{ date('Y') == '2020' ? 'selected' : '' }}>2020</option>
                            <option value="2021" {{ date('Y') == '2021' ? 'selected' : '' }}>2021</option>
                            <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                            <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                            <option value="2028" {{ date('Y') == '2028' ? 'selected' : '' }}>2028</option>
                            <option value="2029" {{ date('Y') == '2029' ? 'selected' : '' }}>2029</option>
                            <option value="2030" {{ date('Y') == '2030' ? 'selected' : '' }}>2030</option>
                            <option value="2031" {{ date('Y') == '2031' ? 'selected' : '' }}>2031</option>
                            <option value="2032" {{ date('Y') == '2032' ? 'selected' : '' }}>2032</option>
                            <option value="2033" {{ date('Y') == '2033' ? 'selected' : '' }}>2033</option>
                            <option value="2034" {{ date('Y') == '2034' ? 'selected' : '' }}>2034</option>
                            <option value="2035" {{ date('Y') == '2035' ? 'selected' : '' }}>2035</option>
                        </select>
                    </div>
                </form>
                <div id="sales-achiev-legend" class="px-5 py-3">
                    <ul class="flex flex-wrap"></ul>
                </div>
                <div class="grow">
                    <canvas id="sales-achiev-chart" width="300" height="100"></canvas>
                </div>
            </div>
            @endif
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                    <h2 class="font-semibold text-slate-800">Global New Customer</h2>
                    @endif
                    @if (Auth::user()->role == '202' || Auth::user()->role == '203')
                    <h2 class="font-semibold text-slate-800">New Customer</h2>
                    @endif
                </header>
                <form class="flex justify-end mb-3 mt-3" id="form-cust">
                    <label class="block text-sm font-medium text-lg mt-1" for="form-search">Year :</label>
                    <div class="relative ml-2 w-3/4 md:w-1/4">
                        <select id="cust-search" name = "year" class="getAchiev form-input w-20">
                            <option value="2020" {{ date('Y') == '2020' ? 'selected' : '' }}>2020</option>
                            <option value="2021" {{ date('Y') == '2021' ? 'selected' : '' }}>2021</option>
                            <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                            <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                            <option value="2028" {{ date('Y') == '2028' ? 'selected' : '' }}>2028</option>
                            <option value="2029" {{ date('Y') == '2029' ? 'selected' : '' }}>2029</option>
                            <option value="2030" {{ date('Y') == '2030' ? 'selected' : '' }}>2030</option>
                            <option value="2031" {{ date('Y') == '2031' ? 'selected' : '' }}>2031</option>
                            <option value="2032" {{ date('Y') == '2032' ? 'selected' : '' }}>2032</option>
                            <option value="2033" {{ date('Y') == '2033' ? 'selected' : '' }}>2033</option>
                            <option value="2034" {{ date('Y') == '2034' ? 'selected' : '' }}>2034</option>
                            <option value="2035" {{ date('Y') == '2035' ? 'selected' : '' }}>2035</option>
                        </select>
                    </div>
                </form>
                <div id="new-customer-legend" class="px-5 py-3">
                    <ul class="flex flex-wrap"></ul>
                </div>
                <div class="grow">
                    <canvas id="new-customer-chart" width="300" height="100"></canvas>
                </div>
            </div>
            @endif
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                    <h2 class="font-semibold text-slate-800">Global New Product</h2>
                    @endif
                    @if (Auth::user()->role == '202' || Auth::user()->role == '203')
                    <h2 class="font-semibold text-slate-800">New Product</h2>
                    @endif
                </header>
                <form class="flex justify-end mb-3 mt-3" id="form-prod">
                    <label class="block text-sm font-medium text-lg mt-1" for="form-search">Year :</label>
                    <div class="relative ml-2 w-3/4 md:w-1/4">
                        <select id="prod-search" name = "year" class="getAchiev form-input w-20">
                            <option value="2020" {{ date('Y') == '2020' ? 'selected' : '' }}>2020</option>
                            <option value="2021" {{ date('Y') == '2021' ? 'selected' : '' }}>2021</option>
                            <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                            <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                            <option value="2028" {{ date('Y') == '2028' ? 'selected' : '' }}>2028</option>
                            <option value="2029" {{ date('Y') == '2029' ? 'selected' : '' }}>2029</option>
                            <option value="2030" {{ date('Y') == '2030' ? 'selected' : '' }}>2030</option>
                            <option value="2031" {{ date('Y') == '2031' ? 'selected' : '' }}>2031</option>
                            <option value="2032" {{ date('Y') == '2032' ? 'selected' : '' }}>2032</option>
                            <option value="2033" {{ date('Y') == '2033' ? 'selected' : '' }}>2033</option>
                            <option value="2034" {{ date('Y') == '2034' ? 'selected' : '' }}>2034</option>
                            <option value="2035" {{ date('Y') == '2035' ? 'selected' : '' }}>2035</option>
                        </select>
                    </div>
                </form>
                <div id="new-product-legend" class="px-5 py-3">
                    <ul class="flex flex-wrap"></ul>
                </div>
                <div class="grow">
                    <canvas id="new-product-chart" width="300" height="100"></canvas>
                </div>
            </div>
            @endif
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                    <h2 class="font-semibold text-slate-800">Global Offering</h2>
                    @endif
                    @if (Auth::user()->role == '202' || Auth::user()->role == '203')
                    <h2 class="font-semibold text-slate-800">Offering</h2>
                    @endif
                </header>
                <form class="flex justify-end mb-3 mt-3" id="form-offer">
                    <label class="block text-sm font-medium text-lg mt-1" for="form-search">Year :</label>
                    <div class="relative ml-2 w-3/4 md:w-1/4">
                        <select id="offer-search" name = "year" class="getAchiev form-input w-20">
                            <option value="2020" {{ date('Y') == '2020' ? 'selected' : '' }}>2020</option>
                            <option value="2021" {{ date('Y') == '2021' ? 'selected' : '' }}>2021</option>
                            <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                            <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                            <option value="2028" {{ date('Y') == '2028' ? 'selected' : '' }}>2028</option>
                            <option value="2029" {{ date('Y') == '2029' ? 'selected' : '' }}>2029</option>
                            <option value="2030" {{ date('Y') == '2030' ? 'selected' : '' }}>2030</option>
                            <option value="2031" {{ date('Y') == '2031' ? 'selected' : '' }}>2031</option>
                            <option value="2032" {{ date('Y') == '2032' ? 'selected' : '' }}>2032</option>
                            <option value="2033" {{ date('Y') == '2033' ? 'selected' : '' }}>2033</option>
                            <option value="2034" {{ date('Y') == '2034' ? 'selected' : '' }}>2034</option>
                            <option value="2035" {{ date('Y') == '2035' ? 'selected' : '' }}>2035</option>
                        </select>
                    </div>
                </form>
                <div id="offering-chart-legend" class="px-5 py-3">
                    <ul class="flex flex-wrap"></ul>
                </div>
                <div class="grow">
                    <canvas id="offering-chart" width="300" height="100"></canvas>
                </div>
            </div>
            @endif
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
                "order": [[ 6, "asc" ]],
                ajax: {
                    url: "{{ route('kpi-view.getdata') }}",
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
                        data: "b_product",
                        name: "b_product"
                    },
                    {
                        data: "b_offering",
                        name: "b_offering"
                    },
                    {
                        data: "year",
                        name: "year"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1] },
                    { className: 'text-right', targets: [2, 3, 4, 5] },
                    { className: 'flex justify-center', targets: [7] },
                    { className: 'hidden', targets: [6] },
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
                const b_product = $(this).data('b_product');
                const b_offering = $(this).data('b_offering');

                $.ajax({
                    type: "GET",
                    url: `/tasks/budget/getdata/${budgetId}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/tasks/budget/update/${budgetId}">
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
                                                <input id="periode" name="periode1" class=" periode form-input w-full px-2 py-1" type="date" value="${periode}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="sales">Budget Sales<span class="text-rose-500">*</span></label>
                                                <input id="b_sales" name="b_sales1" type="number" class=" b_sales form-input w-full px-2 py-1" value="${b_sales}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="customer">Budget Customer<span class="text-rose-500">*</span></label>
                                                <input id="b_customer" name="b_customer1" type="number" class=" b_customer form-input w-full px-2 py-1" value="${b_customer}" required/>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="product">Budget Product<span class="text-rose-500">*</span></label>
                                                <input id="b_product" name="b_product1" type="number" class=" b_product form-input w-full px-2 py-1" value="${b_product}" required />
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
                        data: "product",
                        name: "product"
                    },
                    {
                        data: "offer",
                        name: "offer"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                    { className: 'text-right', targets: [1, 2, 3, 4] }
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".year").on('change', function (e) {
                $('#total').DataTable().ajax.reload();
            })
        });
    </script>
    @endsection
</x-app-layout>