<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Welcome banner -->
        {{-- <x-dashboard.welcome-banner /> --}}

        <div class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

            <!-- Background illustration -->
            <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
                <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                        <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                        <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                            <stop stop-color="#A5B4FC" offset="0%" />
                            <stop stop-color="#818CF8" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                            <stop stop-color="#4338CA" offset="0%" />
                            <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
                        </linearGradient>
                    </defs>
                    <g fill="none" fill-rule="evenodd">
                        <g transform="rotate(64 36.592 105.604)">
                            <mask id="welcome-d" fill="#fff">
                                <use xlink:href="#welcome-a" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" />
                        </g>
                        <g transform="rotate(-51 91.324 -105.372)">
                            <mask id="welcome-f" fill="#fff">
                                <use xlink:href="#welcome-e" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                        <g transform="rotate(44 61.546 392.623)">
                            <mask id="welcome-h" fill="#fff">
                                <use xlink:href="#welcome-g" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                    </g>
                </svg>
            </div>
        
            <!-- Content -->
            <div class="relative">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">Welcome to {{ $CRM_ISS->nilai }}, {{ Auth::user()->username }} 👋</h1>
                <p>Responsibility to build Manpower</p>
            </div>
        
        </div>

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Avatars -->
            {{-- <x-dashboard.dashboard-avatars /> --}}
            <label class="bg-slate-100"></label>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Filter button -->
                {{-- <x-dropdown-filter align="left" /> --}}

                <!-- Datepicker built with flatpickr -->
                {{-- <x-datepicker /> --}}
                {{-- <form class="flex items-center mb-3" id="form-filter">
                    <label class="block text-sm font-medium text-lg mb-1" for="form-search">Select Year For Data Chart :</label>
                    <div class="relative ml-2 w-3/4 md:w-1/4">
                        <select id="form-search" name = "year" class="form-input w-60">
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
                </form> --}}
                

                <!-- Add view button -->
                {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Add View</span>
                </button> --}}
                
            </div>

        </div>
        
        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Bar chart (Direct vs Indirect) -->
            {{-- <x-dashboard.dashboard-card-04 /> --}}

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
            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
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
                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
                    <div class="flex justify-between flex-col md:flex-row p-3">
                        <label class="flex flex-row text-xs">
                            <p class="flex flex-row text-slate-800 mt-1 text-sm" for="year1">Year :</p>
                                <select id="year1" class="year1 flex flex-row text-xs ml-3" name="year1">
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
                        
                        <div class="mb-2"></div>
                            
                        <a href="{{route('dashboard.achievsales')}}" target="_blank" class="btn btn-sales bg-indigo-500 hover:bg-indigo-600 text-white">
                            <span class="xl:block ml-5 mr-5">Detail</span>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                    <label class="flex flex-row text-xs justify-end mt-2 mr-5">
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
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
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
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
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
                                    <th class="text-center"># Orders</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Grand Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div> 
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
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
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
            <div>
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
            @endif --}}
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


            <!-- Line chart (Real Time Value) -->
            {{-- <x-dashboard.dashboard-card-05 />

            <!-- Doughnut chart (Top Countries) -->
            <x-dashboard.dashboard-card-06 /> --}}
            
            <!-- Table (Top Channels) -->
            {{-- <x-dashboard.dashboard-card-07 /> --}}

            <!-- Line chart (Sales Over Time)  -->
            {{-- <x-dashboard.dashboard-card-08 />

            <!-- Stacked bar chart (Sales VS Refunds) -->
            <x-dashboard.dashboard-card-09 /> --}}

            <!-- Card (Recent Activity) -->
            {{-- <x-dashboard.dashboard-card-10 /> --}}
            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200" >
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Upcoming Product Offering</h2>
                </header>
                <div class="p-3">
            
                    <!-- Card content -->
                    <!-- "Today" group -->
                    <div class="grow" width="100" height="100">
                        <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Today</header>
                        <ul class="my-1">
                            <!-- Item -->
                            @if (count($dataOffering['today']) > 0)
                                @foreach ($dataOffering['today'] as $today)    
                                <li class="flex px-2">
                                    <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                        <div class="w-9 h-9 rounded-full shrink-0 {{$today->value_color}}"></div>
                                        <div class="grow flex justify-between">
                                            <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="#0">&nbsp;{{$today->color_tag}}</a> {{$today->company_id}} - {{$today->name}}, at {{date('Y-m-d H;i', strtotime($today->start_time))}}</div>
                                            <div class="shrink-0 self-end ml-2">
                                                <a href="{{route('productoffering')}}" class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span class="hidden sm:inline"> -&gt;</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li class="flex px-2 justify-center mb-2 text-sm">No Activity Found</li>
                            @endif
                        </ul>
                    </div>
                    <!-- "Yesterday" group -->
                    <div>
                        <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Tomorrow</header>
                        <ul class="my-1">
                            <!-- Item -->
                            @if (count($dataOffering['tomorrow']) > 0)
                                @foreach ($dataOffering['tomorrow'] as $tomorrow)    
                                <li class="flex px-2">
                                    <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                        <div class="w-9 h-9 rounded-full shrink-0 {{$tomorrow->value_color}}"></div>
                                        <div class="grow flex justify-between">
                                            <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="#0">&nbsp;{{$tomorrow->color_tag}}</a> {{$tomorrow->company_id}} - {{$tomorrow->name}}, at {{date('Y-m-d H:i', strtotime($tomorrow->start_time))}}</div>
                                            <div class="shrink-0 self-end ml-2">
                                                <a href="{{route('productoffering')}}" class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span class="hidden sm:inline"> -&gt;</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li class="flex px-2 justify-center mb-2 text-sm">No Activity Found</li>
                            @endif
                        </ul>
                    </div>
            
                </div>
            </div>

            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Project Proposal</h2>
                </header>
                <div class="p-3">
                    @if (Auth::user()->role == '100')
                    <div class="table-responsive">
                         <table id="proyek1" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Project</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Project Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
                    @if (Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                    <div class="table-responsive">
                         <table id="proyek" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Project</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Project Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '500' || Auth::user()->role == '501' || Auth::user()->role == '502' || Auth::user()->role == '503')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Purchase Order</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="purchase-order" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Purchase Order #</th>
                                    <th class="text-center">Created By</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203'
            || Auth::user()->role == '300' || Auth::user()->role == '301' || Auth::user()->role == '302' || Auth::user()->role == '303')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Today's Order</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="sales-order" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Invoice Number</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '600' || Auth::user()->role == '601' || Auth::user()->role == '602' || Auth::user()->role == '603')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Today's Attendance List</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="attendance-all" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Employee</th>
                                    <th class="text-center">Clock In</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '1000' || Auth::user()->role == '1001' || Auth::user()->role == '1002' || Auth::user()->role == '1003')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Asset Inventory Request List</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="asset-request" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Purchase Request #</th>
                                    <th class="text-center">Request Level</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '1000' || Auth::user()->role == '1001' || Auth::user()->role == '1002' || Auth::user()->role == '1003')
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Reimburse Request List</h2>
                </header>
                <div class="p-3">
                    <div class="table-responsive">
                         <table id="reimburse-request" class="table table-striped table-bordered text-xs" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Reimburse Request #</th>
                                    <th class="text-center">Applicant</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200" width="100" height="100">
                    <header class="px-5 py-4 border-b border-slate-100">
                        <h2 class="font-semibold text-slate-800">Upcoming Calendar</h2>
                    </header>
                    <div class="p-3">
                
                        <!-- Card content -->
                        <!-- "Today" group -->
                        <div class="grow" width="100" height="100">
                            <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Today</header>
                            <ul class="my-1">
                                <!-- Item -->
                                @if (count($dataCalendars['today']) > 0)
                                    @foreach ($dataCalendars['today'] as $today)    
                                    <li class="flex px-2">
                                        <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                            <div class="w-9 h-9 rounded-full shrink-0 {{$today->value_color}}"></div>
                                            <div class="grow flex justify-between">
                                                <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="#0">&nbsp;{{$today->color_tag}}</a> {{$today->calendar_name}}, at {{date('Y-m-d', strtotime($today->start_time))}}</div>
                                                <div class="shrink-0 self-end ml-2">
                                                    <a href="{{route('calendar')}}" class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span class="hidden sm:inline"> -&gt;</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="flex px-2 justify-center mb-2 text-sm">No Activity Found</li>
                                @endif
                            </ul>
                        </div>
                        <!-- "Yesterday" group -->
                        <div>
                            <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Tomorrow</header>
                            <ul class="my-1">
                                <!-- Item -->
                                @if (count($dataCalendars['tomorrow']) > 0)
                                    @foreach ($dataCalendars['tomorrow'] as $tomorrow)    
                                    <li class="flex px-2">
                                        <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                            <div class="w-9 h-9 rounded-full shrink-0 {{$tomorrow->value_color}}"></div>
                                            <div class="grow flex justify-between">
                                                <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="#0">&nbsp;{{$tomorrow->color_tag}}</a> {{$tomorrow->calendar_name}}, at {{date('Y-m-d', strtotime($tomorrow->start_time))}}</div>
                                                <div class="shrink-0 self-end ml-2">
                                                    <a href="{{route('calendar')}}" class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span class="hidden sm:inline"> -&gt;</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="flex px-2 justify-center mb-2 text-sm">No Activity Found</li>
                                @endif
                            </ul>
                        </div>
                
                    </div>
                </div> 

            {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203' || Auth::user()->role == '300'
            || Auth::user()->role == '301' || Auth::user()->role == '302' || Auth::user()->role == '303' || Auth::user()->role == '500' || Auth::user()->role == '501' || Auth::user()->role == '502' || Auth::user()->role == '503'
            || Auth::user()->role == '600' || Auth::user()->role == '601' || Auth::user()->role == '602' || Auth::user()->role == '603' || Auth::user()->role == '700' || Auth::user()->role == '701' || Auth::user()->role == '702' || Auth::user()->role == '703'
            || Auth::user()->role == '800' || Auth::user()->role == '801' || Auth::user()->role == '802' || Auth::user()->role == '803' || Auth::user()->role == '900' || Auth::user()->role == '901' || Auth::user()->role == '902' || Auth::user()->role == '903'
            || Auth::user()->role == '1000' || Auth::user()->role == '1001' || Auth::user()->role == '1002' || Auth::user()->role == '1003' || Auth::user()->role == '1100' || Auth::user()->role == '1101' || Auth::user()->role == '1102' || Auth::user()->role == '1103')
                <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                    <header class="px-5 py-4 border-b border-slate-100">
                        <h2 class="font-semibold text-slate-800">Leave Request</h2>
                    </header>
                    <div class="p-3">
                        <div class="table-responsive">
                            <table id="leave-request" class="table table-striped table-bordered text-xs" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Leave Request #</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endif --}}

            <!-- Card (Income/Expenses) -->
            {{-- <x-dashboard.dashboard-card-11 /> --}}

        </div>

    </div>
    @section('js-page')
    <script>
      $(document).ready(function () {
            $('#proyek').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                order: [[1, 'desc']],
                ajax: {
                    url: "{{ route('proyek-single.getdata') }}"
                },
                columns: [
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "companyname",
                        name: "companyname"
                    },
                    {
                        data: "status_name",
                        name: "status_name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4] },
                ], lengthMenu: [[10, 20], [10, 20]]
            });
            
            $('#proyek1').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                order: [[1, 'desc']],
                ajax: {
                    url: "{{ route('proyek.getdata') }}"
                },
                columns: [
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "companyname",
                        name: "companyname"
                    },
                    {
                        data: "status_name",
                        name: "status_name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4] },
                ], lengthMenu: [[10, 20], [10, 20]]
            });

            $('#leave-request').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                "order": [[ 1, "desc" ]],
                ajax: {
                    url: "{{ route('leaverequests.getdata') }}"
                },
                columns: [
                    {
                        data: "id",
                        name: "id"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2] },
                ], lengthMenu: [[10, 20], [10, 20]]
            });

            $('#leave-request').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const date = $(this).data('date');
                const from = $(this).data("from");
                const to = $(this).data("to");
                const employee = $(this).data("employee");
                const desc = $(this).data("desc");
                const status = $(this).data("stat");
                const image = $(this).data("image");
                const approve1_stat = $(this).data("approve1_stat");
                const approve1_name = $(this).data("approve1_name");
                const approve2_stat = $(this).data("approve2_stat");
                const approve2_name = $(this).data("approve2_name");
                const approve1_notes = $(this).data("approve1_notes");
                const approve2_notes = $(this).data("approve2_notes");
                const file_name = $(this).data("file_name");

                $.ajax({
                    type: "GET",
                    url: `/hr/leaverequest/leaverequests/getdetail/${id}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Leave Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${id}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Form Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${date}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="employee">Employee</label>
                                        <input id="employee" class="employee form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${employee}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status Leave</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval 1 Status</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve1_stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve2_stat">Approval 2 Status</label>
                                        <input id="approve2_stat" class="approve2_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve2_stat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_name">Approval 1 name</label>
                                        <input id="approve1_name" class="approve1_name form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve1_name}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve2_name">Approval 2 name</label>
                                        <input id="approve2_name" class="approve2_name form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approve2_name}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="description">Notes</label>
                                        <textarea rows="4" id="description" name="description" class="description form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${desc}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="approve1_notes">Approve 1 Notes</label>
                                        <textarea rows="4" id="approve1_notes" class="approve1_notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${approve1_notes}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="approve2_notes">Approve 2 Notes</label>
                                        <textarea rows="4" id="approve2_notes" class="approve2_notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${approve2_notes}</textarea>
                                    </div>
                                    <div class="mt-3 mb-5 text-left ${image == 1 ? 'hidden' : ''}">
                                        <label class="text-sm font-medium mb-1">Document Uploaded :</label>
                                        <a href="/hr/leaverequest/leaverequests/document/${id}" target="_blank" class="text-sm font-medium ml-5 text-blue-500 underline">View Document</a>
                                        <input id="file" name="file" class="file read-only:bg-slate-200 px-auto py-1 ml-5" type="text"
                                        readonly disabled value="${file_name}" />
                                    </div>
                            </div>
                        `); 
                    },
                });
            });

            $('#purchase-order').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                "order": [[ 0, "desc" ]],
                ajax: {
                    url: "{{ route('purchase-order.dashboard') }}"
                },
                columns: [
                    {
                        data: "idpo",
                        name: "idpo"
                    },
                    {
                        data: "addedby",
                        name: "addedby"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2] },
                ], lengthMenu: [[10, 20], [10, 20]]
            });

            $('#purchase-order').on("click", ".btn-modal", function () {
                const idpo = $(this).data('idpo');
                const datepo = $(this).data("datepo");
                const squotation = $(this).data("squotation");
                const idsupplier = $(this).data("idsupplier");
                const status = $(this).data("status");
                const notes = $(this).data("notes");
                const deliverydate = $(this).data("deliverydate");
                const idwarehouse = $(this).data("idwarehouse");
                const category = $(this).data("category");
                const currency = $(this).data("currency");
                const crossrate = $(this).data("crossrate");
                const pterm = $(this).data("pterm");
                const subtotal = $(this).data("subtotal");
                const pvat = $(this).data("pvat");
                const avat = $(this).data("avat");
                const gtotal = $(this).data("gtotal");
                const addedby = $(this).data("addedby");
                const remarks = $(this).data("remarks");
                const name = $(this).data("name");
                const matauang = $(this).data("matauang");

                $.ajax({
                    type: "GET",
                    url: `/purchasing/purchase-approval/getProduct/${idpo}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Order #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpo}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Purchase Order Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepo}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request By</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${addedby}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Supplier</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${name}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Delivery Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${deliverydate}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Remarks By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Exchange Rate</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${divider(crossrate)}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Payment Term</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${pterm} Days" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">PO Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${notes}</textarea>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">No</th>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="subtotal">Subtotal</label>
                                        <input id="subtotal" class="subtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${matauang} ${divider(subtotal)}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="pvat">PPN (%)</label>
                                        <input id="pvat" class="pvat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${pvat}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="avat">PPN (Count)</label>
                                        <input id="avat" class="avat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${avat}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                        <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${matauang} ${divider(gtotal)}" disabled readonly />
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1 text-left" for="remarks">Remarks</label>
                                    <textarea rows="4" id="remarks" name="remarks" class="remarks form-input w-full px-2 py-1 read-only:bg-slate-200"
                                    type="text" readonly>${remarks}</textarea>
                                </div>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td class="text-center">${value.no}</td>
                                                <td class="text-center">${value.code}</td>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${value.quantity}</td>
                                                <td class="text-center">${value.price}</td>
                                                <td class="text-center">${value.total}</td>
                                                <td class="text-center">${value.balance}</td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            // $('#sales-order').DataTable({
            //     responsive: true,
            //     scrollY: '100px',
            //     responsive: true,
            //     processing: true,
            //     serverSide: true,
            //     stateServe: true,
            //     "searching": false,
            //     "order": [[ 1, "desc" ]],
            //     ajax: {
            //         url: "{{ route('delivery-orders.getdashboard') }}",
            //     },
            //     columns: [
            //         {
            //             data: "created_at",
            //             name: "created_at"
            //         },
            //         {
            //             data: "do_number",
            //             name: "do_number"
            //         },
            //         {
            //             data: "company",
            //             name: "company"
            //         },
            //         {
            //             data: "action",
            //             name: "action"
            //         },
            //     ],
            //     columnDefs: [
            //         { className: 'text-center', targets: [0, 1, 3] },
            //     ],  lengthMenu: [[10, 20], [10, 20]]
                
            // });

            // $('#sales-order').on("click", ".btn-modal", function () {
            //     const id = $(this).data('id');
            //     const code = $(this).data("code");
            //     const number = $(this).data("number");
            //     const date = $(this).data("date");
            //     const by = $(this).data("by");
            //     const address = $(this).data("address");
            //     const status = $(this).data("stat");
            //     const photo1 = $(this).data("photo1");
            //     const photo2 = $(this).data("photo2");
            //     const inv = $(this).data("inv");

            //     $.ajax({
            //         type: "GET",
            //         url: `/logistic/doupdate/getdetail/${code}`,
            //         success: function (response) {
            //             const csrf_token = $('meta[name="csrf-token"]').attr('content');

            //             $(".modal-content").html(`
            //                 <div class="px-5">
            //                     <div class="text-sm">
            //                         <div class="font-medium text-slate-800 mb-3"></div>
            //                     </div>
            //                     <div class="grid md:grid-cols-3 gap-3">
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1"
            //                                 for="number">Delivery Order Number</label>
            //                             <input id="number" class="number form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${number}" disabled readonly/>
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1"
            //                                 for="code">Order Code</label>
            //                             <input id="code" class="code form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${code}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="status">Status</label>
            //                             <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${status}" disabled readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="date">Delivery Date</label>
            //                             <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${date}" disabled
            //                                 readonly />
            //                         </div>
            //                         <div>
            //                             <label class="block text-sm font-medium mb-1" for="by">Delivery By</label>
            //                             <input id="by" class="by form-input w-full px-2 py-1 bg-slate-100"
            //                                 type="text" value="${by}" disabled readonly />
            //                         </div>
            //                     </div>
            //                         <div class="mt-3">
            //                             <label class="block text-sm font-medium mb-1 text-left" for="address">Delivery Address</label>
            //                             <textarea rows="4" id="address" class="address form-input w-full px-2 py-1 bg-slate-100"
            //                             type="text" disabled readonly>${address}</textarea>
            //                         </div>
            //                         <div class="grid md:grid-cols-3 gap-3 mt-3">
            //                             <div class="${photo1 == 1 ? 'hidden' : ''}">
            //                                 <label class="text-sm font-medium mb-1">AWB DO :</label>
            //                                 <a href="/logistic/do/photo1/${code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
            //                             </div>
            //                             <div class="${inv == 1 ? 'hidden' : ''}">
            //                                 <label class="text-sm font-medium mb-1">View Invoice PDF :</label>
            //                                 <a href="/sales/sales-invoice/file/${id}" target="_blank" class="text-sm font-medium ml-5">View File</a>
            //                             </div>
            //                             <div class="${photo2 == 1 ? 'hidden' : ''}">
            //                                 <label class="text-sm font-medium mb-1">Signed By :</label>
            //                                 <a href="/logistic/do/photo2/${code}" target="_blank" class="text-sm font-medium ml-5">View Image</a>
            //                             </div>
            //                         </div>
            //                     <div class="table-responsive mt-4">
            //                         <label class="block text-sm font-medium mb-1 text-center" for="address">Delivery Product Items</label>
            //                         <table class="table table-striped table-bordered detail-delivery-orders"
            //                             style="width:100%">
            //                             <thead>
            //                                 <tr>
            //                                     <th class="text-sm text-center">Product Code</th>
            //                                     <th class="text-sm text-center">Product Name</th>
            //                                     <th class="text-sm text-center">Batch No</th>
            //                                     <th class="text-sm text-center">Qty</th>
            //                                     <th class="text-sm text-center">Status</th>
            //                                 </tr>
            //                             </thead>
            //                             <tbody>
                                            
            //                             </tbody>
            //                         </table>
            //                     </div>
            //                 </div>
            //             `); 
            //             let tableRow = '';
            //             for (const value of response) {
            //                 tableRow += `<tr>
            //                                 <td class="text-center">${value.product_code}</td>
            //                                 <td>${value.product_name}</td>
            //                                 <td class="text-center">${value.batch_no}</td>
            //                                 <td class="text-center">${value.qty}</td>
            //                                 <td class="text-center">${value.status_order}</td>
            //                             </tr>`;
            //             }

            //             $(".detail-delivery-orders").find('tbody').append(tableRow);
            //         },
            //     });
            // });

            $('#attendance-all').DataTable({
                responsive: true,
                scrollY: '100px',
                scrollCollapse: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                order:[0, 'DESC'],
                ajax: {
                    url: "{{ route('attendancelist-all.getdashboard') }}"
                },
                columns: [
                    {
                        data: "lastentry",
                        name: "lastentry"
                    },
                    {
                        data: "employee",
                        name: "employee"
                    },
                    {
                        data: "sdate",
                        name: "sdate"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2] }
                ], lengthMenu: [[10, 20], [10, 20]]
            });

            $('#asset-request').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                "searching": false,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                ajax: {
                    url: "{{ route('purchase-list.getdashboard') }}"
                },
                columns: [
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "reqlevel",
                        name: "reqlevel"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1] },
                    { className: 'text-right', targets: [] },
                ], lengthMenu: [[10, 20], [10, 20]]
            });

            $('#asset-request').on("click", ".btn-modal", function () {
                const idpr = $(this).data('idpr');
                const datepr = $(this).data("datepr");
                const applicant = $(this).data("applicant");
                const loc = $(this).data("loc");
                const reqlevel = $(this).data("reqlevel");
                const note = $(this).data("note");
                const daterequired = $(this).data("daterequired");
                const approvaldate = $(this).data("approvaldate");
                const approvalstat = $(this).data("approvalstat");
                const approved1by = $(this).data("approved1by");
                const approved2by = $(this).data("approved2by");
                const approval1_status = $(this).data("approval1_status");
                const approval2_status = $(this).data("approval2_status");
                const remarks1 = $(this).data("remarks1");
                const remarks2 = $(this).data("remarks2");
                const gtotal = $(this).data("gtotal");
                const currency = $(this).data("currency");

                $.ajax({
                    type: "GET",
                    url: `/ga/purchase-approval/getProduct/${idpr}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idpr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datepr}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${applicant}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Location</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${loc}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Request Level</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${reqlevel}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Required Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${daterequired}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approval 1 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approval 2 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved2by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvaldate}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 1</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1_status}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approval Status 2</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval2_status}" disabled readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Notes</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${note}</textarea>
                                    </div>
                                    <div class="mt-1">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Item Name</th>
                                                <th class="text-sm text-center">Unit</th>
                                                <th class="text-sm text-center">Quantity</th>
                                                <th class="text-sm text-center">Price</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Category</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="grid md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="gtotal">Grand Total</label>
                                            <input id="gtotal" class="gtotal form-input w-full px-2 py-1 bg-slate-100 mb-3"
                                                type="text" value="${currency} ${divider(gtotal)}" disabled readonly />
                                        </div>
                                    </div>
                                    <form met
                                <form class="${approvalstat == 'Approved' ? 'hidden' : ''} ${approvalstat == 'Denied' ? 'hidden' : ''}" method="post" class="form_do_update" enctype="multipart/form-data" action="/ga/purchase-approval/list/update/${idpr}">
                                    <input type="hidden" name="_token" value="${csrf_token}" />
                                    <div class="mt-2">
                                        <label class="block text-sm font-medium mb-1 text-left" for="remarks1">Remarks 1</label>
                                        <textarea rows="4" id="remarks1" name="remarks1" class="remarks1 form-input w-full px-2 py-1"
                                        type="text"></textarea>
                                    </div>
                                    <center>
                                        <div></div>
                                        <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                                        <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mb-3 mt-2" />
                                    </center>
                                </form>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.unit}</td>
                                                <td class="text-center">${divider(value.qty)}</td>
                                                <td class="text-center">${divider(value.price)}</td>
                                                <td class="text-center">${divider(value.total)}</td>
                                                <td class="text-center">${value.category}</td>
                                                <td class="text-center flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/${value.idassets}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                        ${value.pdf == 1 ? 'hidden' : ''}">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/${value.idassets}" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3 
                        ${value.image == 1 ? 'hidden' : ''}">
                        View Image
                        </a>

                    </td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            $('#reimburse-request').DataTable({
                scrollY: '100px',
                scrollCollapse: true,
                "searching": false,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                // "order": [[ 0, "desc" ]],
                ajax: {
                    url: "{{ route('reimburse-list.getdashboard') }}"
                },
                columns: [
                    {
                        data: "idreqform",
                        name: "idreqform"
                    },
                    {
                        data: "applicant",
                        name: "applicant"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 2] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $('#reimburse-request').on("click", ".btn-modal", function () {
                const idreqform = $(this).data('idreqform');
                const datereq = $(this).data("datereq");
                const applicant = $(this).data("applicant");
                const bank_account = $(this).data("bank_account");
                const number_account = $(this).data("number_account");
                const name_account = $(this).data("name_account");
                const note = $(this).data("note");
                const gtotal = $(this).data("gtotal");
                const approvaldate = $(this).data("approvaldate");
                const approved1by = $(this).data("approved1by");
                const approved2by = $(this).data("approved2by");
                const approval1_status = $(this).data("approval1_status");
                const approval2_status = $(this).data("approval2_status");
                const remarks1 = $(this).data("remarks1");
                const remarks2 = $(this).data("remarks2");
                const approvalstat = $(this).data("approvalstat");

                $.ajax({
                    type: "GET",
                    url: `/ga/reimburse-approval/getdetail/${idreqform}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Reimburse Request #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idreqform}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="date">Request Date</label>
                                        <input id="date" class="date form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${datereq}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="status">Status Request</label>
                                        <input id="status" class="status form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvalstat}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Applicant</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${applicant}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approved 1 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved1by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Approved 2 By</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approved2by}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="approve1_stat">Approved Date</label>
                                        <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approvaldate}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Status Approval 1</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval1_status}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="currency">Status Approval 2</label>
                                        <input id="currency" class="currency form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${approval2_status}" disabled
                                            readonly />
                                    </div>
                                </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Reimburse Note</label>
                                        <textarea rows="4" id="notes" class="notes form-input w-full px-2 py-1 bg-slate-100"
                                        type="text" disabled readonly>${note}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium mb-1 text-left" for="notes">Inventory Request :</label>
                                    </div>
                                    <table class="table table-striped table-bordered mt-2 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Reimburse Type</th>
                                                <th class="text-sm text-center">Reimburse Concern</th>
                                                <th class="text-sm text-center">Price (IDR)</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Total Reimbure (IDR)</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${divider(gtotal)}" disabled readonly />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Bank Account</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${bank_account}" disabled readonly />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Bank Account Number</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${number_account}" disabled readonly />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="approve1_stat">Under the Name of</label>
                                            <input id="approve1_stat" class="approve1_stat form-input w-full px-2 py-1 bg-slate-100"
                                                type="text" value="${name_account}" disabled readonly />
                                        </div>
                                    </div>
                                    <form class="${approvalstat == 'Approved' ? 'hidden' : ''} ${approvalstat == 'Denied' ? 'hidden' : ''}" method="post" class="form_do_update" enctype="multipart/form-data" action="/ga/reimburse-approval/list/update/${idreqform}">
                                        <input type="hidden" name="_token" value="${csrf_token}" />
                                        <div class="mt-2">
                                            <label class="block text-sm font-medium mb-1 text-left" for="remarks1">Remarks 1</label>
                                            <textarea rows="4" id="remarks1" name="remarks1" class="remarks1 form-input w-full px-2 py-1"
                                            type="text"></textarea>
                                        </div>
                                        <center>
                                            <div></div>
                                                <input type="submit" value="Approved" name="status" class="w-80 text-lg bg-green-500 hover:bg-green-600 text-white mt-3" />
                                                <input type="submit" value="Denied" name="status" class="w-80 text-lg bg-red-400 border-slate-200 hover:bg-red-500 text-white mb-3 mt-2" />
                                        </center>
                                    </form>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td class="text-left">${value.type}</td>
                                                <td class="text-left">${value.reimburse_to}</td>
                                                <td class="text-right">${divider(value.price)}</td>
                                                <td class="text-center flex flex-row justify-center">
                        <a href="/ga/reimburse-approval/file/${value.idreqform}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white
                        ${value.pdf == 1 ? 'hidden' : ''}">
                            View Reimburse File
                        </a>

                    </td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });

            $('#globalsales').DataTable({
                "searching": false,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "sort": false,
                ajax: {
                    url: "{{ route('dashboard.percent') }}",
                    data:function(d){
                        d.year1 = $("#year1").val()
                    }
                },
                columns: [
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "sales_r",
                        name: "sales_r"
                    },
                    {
                        data: "sales_b",
                        name: "sales_b"
                    },
                    {
                        data: "percent",
                        name: "percent"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [3] },
                    { className: 'text-right', targets: [1, 2] },
                ],lengthMenu: [[6, 12], [6, 12]]
            });
            $(".year1").on('change', function (e) {
                $('#globalsales').DataTable().ajax.reload();
            })

            $('#percent1').DataTable({
                "searching": false,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "sort": false,
                ajax: {
                    url: "{{ route('dashboard.percent1') }}",
                    data:function(d){
                        d.year1 = $("#year1").val()
                    }
                },
                columns: [
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "r_sales",
                        name: "r_sales"
                    },
                    {
                        data: "b_sales",
                        name: "b_sales"
                    },
                    {
                        data: "percent",
                        name: "percent"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 4] },
                    { className: 'text-right', targets: [2, 3] },
                ],lengthMenu: [[12], [12]]
            });
            $(".year1").on('change', function (e) {
                $('#percent1').DataTable().ajax.reload();
            })

            $('#globalSalesDetail').DataTable({
                "searching": false,
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "sort": false,
                ajax: {
                    url: "{{ route('dashboard.percent1') }}",
                    data:function(d){
                        d.year1 = $("#year1").val()
                    }
                },
                columns: [
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "r_sales",
                        name: "r_sales"
                    },
                    {
                        data: "b_sales",
                        name: "b_sales"
                    },
                    {
                        data: "percent",
                        name: "percent"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 4] },
                    { className: 'text-right', targets: [2, 3] },
                ],lengthMenu: [[12], [12]]
            });
            $(".year1").on('change', function (e) {
                $('#globalSalesDetail').DataTable().ajax.reload();
            })

            $('#orderPrincipal').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Supplier Name # : "
                },
                ajax: {
                    url: "{{ route('dashboard.orderprincipal') }}",
                    data:function(d){
                        d.year2 = $("#year2").val()
                    }
                },
                columns: [
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "invoice_count",
                        name: "invoice_count"
                    },
                    {
                        data: "currency",
                        name: "currency"
                    },
                    {
                        data: "grand_total",
                        name: "grand_total"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 2] },
                    { className: 'text-right', targets: [3] },
                ],lengthMenu: [[6, 12], [6, 12]]
            });
            $(".year2").on('change', function (e) {
                $('#orderPrincipal').DataTable().ajax.reload();
            })
            $('#orderPrincipal').on("click", ".btn-principal", function () {
                const id = $(this).data('id');
                const name = $(this).data("name");
                const supplier = $(this).data("supplier");
                const idpo = $(this).data("idpo");
                const year = $(this).data("year");

                $.ajax({
                    type: "GET",
                    url: `/dashboard/orderprincipaldetail/${year}/${supplier}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');
                        const modalTableBody = $("#ordersPrincipalDetails1").find("tbody");
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="ordersPrincipalDetails" class="table table-striped table-bordered text-xs ordersPrincipalDetails" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Principal</th>
                                                <th class="text-sm text-center">Invoice Date</th>
                                                <th class="text-sm text-center">Purchase Order #</th>
                                                <th class="text-sm text-center">Principal Invoice #</th>
                                                <th class="text-sm text-center">Currency</th>
                                                <th class="text-sm text-center">Total</th>
                                                <th class="text-sm text-center">Exchange Rate</th>
                                                <th class="text-sm text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `);
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td class="text-left">${value.name}</td>
                                                <td class="text-center">${value.invdate}</td>
                                                <td class="text-center">${value.idpo}</td>
                                                <td class="text-center">${value.sinvoice}</td>
                                                <td class="text-center">${value.currency}</td>
                                                <td class="text-right">${newDivider(value.total)}</td>
                                                <td class="text-right">${newDivider(value.crate)}</td>
                                                <td class="text-center flex flex-row justify-center">
                            <a href="/dashboard/principaldetail/${value.idpo}" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">
                                <span class="xl:block ml-5 mr-5">View Orders Detail</span>
                            </a>

                    </td>
                                            </tr>`;
                            }
                        $(".ordersPrincipalDetails").find('tbody').append(tableRow);
                    },
                });
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            const dataOrders = <?=$dataOngoingOrders?>;
            let tableRow = '';

            for (const value of dataOrders) {
                tableRow += `<tr id=row-dataOrders>
                                    <td class="p-2">
                                        <div class="flex items-center">
                                            <div class="text-slate-800">${value.name}</div>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">${value.count}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-right text-emerald-500">${newDivider(value.total)}</div>
                                    </td>
                                        </tr>`;
            }
            $(".ongoingOrders").find('tbody').append(tableRow);
    </script>
    @endsection
</x-app-layout>