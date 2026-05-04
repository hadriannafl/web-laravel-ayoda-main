{{-- <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Direct VS Indirect</h2>
    </header>
    <div id="dashboard-card-04-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow">
        <canvas id="dashboard-card-04" width="595" height="248"></canvas>
    </div>
</div> --}}
@if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
    <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200 test-1">
        @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Global Sales Achievement</h2>
            </header>
        @endif
        @if (Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Sales Achievement</h2>
            </header>
        @endif
        <div class="flex justify-between flex-col md:flex-row">
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
                <label class="flex flex-row text-xs justify-start mt-2 ml-5">
                    <p class="flex flex-row text-slate-800 mt-1 mr-3 text-sm" for="year1">Year :</p>
                        <select id="year1" class="year1 flex flex-row text-xs" name="year1">
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
                </label>
            @endif
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
                <a href="{{route('dashboard.achievsales')}}" target="_blank" class="btn btn-sales bg-indigo-500 hover:bg-indigo-600 text-white justify-end mt-2 mr-5">
                    <span class="xl:block ml-5 mr-5">Detail</span>
                </a>
                {{-- <div x-data="{ modalOpen: false }">
                    <button class="btn btn-sales bg-indigo-500 hover:bg-indigo-600 text-white justify-end mt-2 mr-5"
                        @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                        <span class="xl:block ml-5 mr-5">Detail</span>
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
                                    <div class="font-semibold text-slate-800">Global Sales Achievement Detail</div>
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
                                <div class="p-3">
                                    <div class="table-responsive">
                                        <table id="globalSalesDetail" class="table table-striped table-bordered text-xs" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Periode</th>
                                                    <th class="text-center">Sales Name</th>
                                                    <th class="text-center">Realized</th>
                                                    <th class="text-center">Budget</th>
                                                    <th class="text-center">Achievement %</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                    <div class="space-y-3">
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
                </div> --}}
            @endif
        </div>
        @if (Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <label class="flex flex-row text-xs justify-end mt-2 mr-5">
                <p class="flex flex-row text-slate-800 mt-1 mr-3 text-sm" for="year1">Year :</p>
                    <select id="year1" class="year1 flex flex-row text-xs" name="year1">
                        <option value="">All</option>
                        <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                        <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
                    </select>
            </label>
        @endif
        @if (Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="p-3">
                <div class="table-responsive">
                    <table id="percent1" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Periode</th>
                                <th class="text-center">Sales Name</th>
                                <th class="text-center">Realized</th>
                                <th class="text-center">Budget</th>
                                <th class="text-center">Achievement %</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endif
        @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
            <div class="p-3">
                <div class="table-responsive">
                    <table id="globalsales" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Month</th>
                                <th class="text-center">Realized</th>
                                <th class="text-center">Budget</th>
                                <th class="text-center">Achievement %</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endif
    </div>     
    @endif

    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
        <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                <h2 class="font-semibold text-slate-800">Global Sales Achievement Chart</h2>
                @endif
                @if (Auth::user()->role == '202' || Auth::user()->role == '203')
                <h2 class="font-semibold text-slate-800">Sales Achievement Chart</h2>
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

    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
    <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Order By Principal</h2>
        </header>
        <div class="flex justify-between flex-col md:flex-row">
                <label class="flex flex-row text-xs justify-start mt-2 ml-5">
                    <p class="flex flex-row text-slate-800 mt-1 mr-3 text-sm" for="year2">Year :</p>
                        <select id="year2" class="year2 flex flex-row text-xs" name="year2">
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
                </label>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <table id="orderPrincipal" class="table table-striped table-bordered text-xs" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Principal</th>
                            <th class="text-center">Currency</th>
                            <th class="text-center">Total Orders</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> 
    @endif

    @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
        <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Ongoing Orders</h2>
            </header>

            <div class="p-3">
                <div class="overflow-x-auto">
                    <table id="ongoingOrders" class="table-auto w-full ongoingOrders">
                        <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Sales Orders</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Total SO</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Total DPP</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100">
                            <!-- Row -->
                                <tr>
                                    <td class="p-2">
                                        <div class="flex items-center">
                                            <div class="text-slate-800"></div>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center"></div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-right text-emerald-500"></div>
                                    </td>
                                </tr>  
                        </tbody>
                    </table>
                </div>
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
 
@if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203'
|| Auth::user()->role == '800' || Auth::user()->role == '801' || Auth::user()->role == '802' || Auth::user()->role == '803' || Auth::user()->role == '900' || Auth::user()->role == '901'
|| Auth::user()->role == '902' || Auth::user()->role == '903')
<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
     <header class="px-5 py-4 border-b border-slate-100">
         <h2 class="font-semibold text-slate-800">Total AR Days - All Customers</h2>
     </header>
     <form class="flex justify-end mb-3 mt-3" id="form-ar">
        <label class="block text-sm font-medium text-lg mt-1" for="form-search">Year :</label>
        <div class="relative ml-2 w-3/4 md:w-1/4">
            <select id="ar-search" name = "year" class="getAchiev form-input w-20">
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
     <div id="ar-days-legend" class="px-5 py-3">
         <ul class="flex flex-wrap"></ul>
     </div>
     <div class="grow">
         <canvas id="ar-days-chart" width="300" height="100"></canvas>
     </div>
 </div>
 @endif
{{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4 border-b border-slate-100">
            @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
            <h2 class="font-semibold text-slate-800">Global Year Sales</h2>
            @endif
            @if (Auth::user()->role == '202' || Auth::user()->role == '203')
            <h2 class="font-semibold text-slate-800">This Year Sales</h2>
            @endif
        </header>
        <div id="dashboard-sales-chart-legend" class="px-5 py-3">
            <ul class="flex flex-wrap"></ul>
        </div>
        <div class="grow">
            <canvas id="dashboard-sales-chart" width="300" height="100"></canvas>
        </div>
    </div>
@endif --}}

{{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Purchase Orders Report</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Realized</th>
                                    <th class="text-center">Budget</th>
                                    <th class="text-center">Achievement %</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>   
@endif   --}}
