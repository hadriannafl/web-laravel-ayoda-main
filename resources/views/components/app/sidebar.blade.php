<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 px-2 py-3 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="flex flex-row gap-3 items-center" href="{{ route('dashboard') }}">
                <img src="/images/Logo.png" alt="" class='w-10 h-10'>
                <p class="text-white text-center">{{ $CRM_ISS->nilai }}</p>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['dashboard'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['dashboard'])){{ 'hover:text-slate-200' }}@endif"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif"
                                        d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif"
                                        d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-200' }}@else{{ 'text-slate-400' }}@endif"
                                        d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <!-- Incident Report -->
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['incident-report'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['incident-report']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['incident-report'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-7 w-7 icon icon-tabler icon-tabler-clipboard-text" viewBox="0 0 24 24" stroke-width="2" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path class="fill-current @if(in_array(Request::segment(1), ['incident-report'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['incident-report'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M9 12h6" />
                                        <path d="M9 16h6" />
                                      </svg>
                                    <span
                                        class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Incident Report</span>
                                </div>
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), [''])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('incident-report/single*')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('incident.report') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Incident Report</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('incident.form')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('incident.form') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Incident Report - Create</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '300' || Auth::user()->role == '301' || Auth::user()->role == '302' || Auth::user()->role == '500' || Auth::user()->role == '501'
                                || Auth::user()->role == '502' || Auth::user()->role == '600' || Auth::user()->role == '601' || Auth::user()->role == '602' || Auth::user()->role == '1000' || Auth::user()->role == '1001' || Auth::user()->role == '1002')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('incident-report/list*')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('incident.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Incident Report - List</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li> --}}
                    {{-- <li class="mb-1 last:mb-0">
                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('analytics')){{ '!text-indigo-500' }}@endif" href="{{ route('analytics') }}">
                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Analytics</span>
                        </a>
                    </li>
                    <li class="mb-1 last:mb-0">
                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('fintech')){{ '!text-indigo-500' }}@endif" href="{{ route('fintech') }}">
                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fintech</span>
                        </a>
                    </li> --}}
                    <!-- Admin -->
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['admin'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['admin']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['admin'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['admin'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            cx="16" cy="8" r="8" />
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['admin'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            cx="8" cy="16" r="8" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Admin</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['Admin'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('credit-cards')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('credit-cards') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Company
                                            List</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transactions')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transactions') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Company
                                            PIC</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transaction-details')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transaction-details') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Task
                                            Action</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transaction-details')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transaction-details') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">User
                                            List</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transaction-details')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transaction-details') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product
                                            List</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    <!-- Tasks -->
                    {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203' || Auth::user()->role == '1100' || Auth::user()->role == '1101' || Auth::user()->role == '1102' || Auth::user()->role == '1103')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['tasks'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['tasks']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['tasks'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['tasks'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M8 1v2H3v19h18V3h-5V1h7v23H1V1z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['tasks'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M1 1h22v23H1z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['tasks'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M15 10.586L16.414 12 11 17.414 7.586 14 9 12.586l2 2zM5 0h14v4H5z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Marketing CRM</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['tasks'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['tasks'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('productoffered-all*')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('productoffered-all') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product Offering - ALL</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/offering/productoffering*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('productoffering') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product Offering</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/proyek/proyek-all*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('proyek-all') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Project Proposal - ALL</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('proyek-single*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('proyek-single') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Project Proposal</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203' || Auth::user()->role == '1100' || Auth::user()->role == '1101' || Auth::user()->role == '1102' || Auth::user()->role == '1103')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/document-request*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('document.request') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Document Request</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203' || Auth::user()->role == '1100' || Auth::user()->role == '1101' || Auth::user()->role == '1102' || Auth::user()->role == '1103')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/sample-request*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('sample.request') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sample Request</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203' || Auth::user()->role == '1100' || Auth::user()->role == '1101' || Auth::user()->role == '1102' || Auth::user()->role == '1103')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/delivery-reff*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('delivery-reff') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sample Delivery Reff</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/offering/productoffering*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('productoffering') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sales Order Confirmation</span>
                                    </a>
                                </li>
                                @endif
                                <!--@if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')-->
                                <!--<li class="mb-1 last:mb-0">-->
                                <!--    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('visiting.indexall')){{ '!text-indigo-500' }}@endif"-->
                                <!--        href="{{ route('visiting.indexall') }}">-->
                                <!--        <span-->
                                <!--            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Visiting Report - ALL</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <!--@endif-->
                                <!--@if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')-->
                                <!--<li class="mb-1 last:mb-0">-->
                                <!--    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('tasks/visiting-report/visiting-single*')){{ '!text-indigo-500' }}@endif"-->
                                <!--        href="{{ route('visiting.index') }}">-->
                                <!--        <span-->
                                <!--            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Visiting Report</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <!--@endif-->
                            </ul>
                        </div>
                    </li>
                    @endif --}}
                    
                    @if (Auth::user()->kanban == '1')
                    {{-- kanban --}}
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['kan-ban'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['kan-ban'])){{ 'hover:text-slate-200' }}@endif"
                            href="{{ route('kan-ban') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['kan-ban'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                        d="M8 1v2H3v19h18V3h-5V1h7v23H1V1z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['kan-ban'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                        d="M1 1h22v23H1z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['kan-ban'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                        d="M15 10.586L16.414 12 11 17.414 7.586 14 9 12.586l2 2zM5 0h14v4H5z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Kanban</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    
                    <!-- purchasing -->
                    @if (Auth::user()->ga == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['purchasing'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['purchasing']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['purchasing'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-7 w-7 icon icon-tabler icon-tabler-credit-card" viewBox="0 0 24 24" stroke-width="1" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path class="fill-current @if(in_array(Request::segment(1), ['purchasing'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['purchasing'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M3 10l18 0" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['purchasing'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M7 15l.01 0" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['purchasing'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M11 15l2 0" />
                                      </svg>
                                    <span
                                        class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchasing</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['purchasing'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->ga_11 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['purchasing'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('purchase-list-only', 'purchase-list.view', 'purchase-list.updatepage', 'purchase-list.clonepage', 'purchase-list', 'purchase-requestga', 'purchase-updateprice', 'purchase-list.priceupdate', 'purchase-list.updatepage1', 'purchase-printsubmit', 'purchase-list.signature', 'purchase-list.submitpage', 'purchase-submitquotation', 'purchase-list.quotationpage', 'purchase-list.submitapproval', 'purchase-approvalga', 'purchase-approve1', 'purchase-approvalga2', 'purchase-approve2', 'purchase-approvalga3', 'purchase-approve3') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['purchasing'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchase Request</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['purchasing'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['purchasing'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_11 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-list-only', 'purchase-list.view', 'purchase-list.updatepage', 'purchase-list.clonepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-list-only') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_11 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-list', 'purchase-requestga')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_12 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-updateprice', 'purchase-list.priceupdate', 'purchase-list.updatepage1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-updateprice') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Update PR</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_12 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-printsubmit', 'purchase-list.signature', 'purchase-list.submitpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-printsubmit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print/Submit PR</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_13 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-submitquotation', 'purchase-list.quotationpage', 'purchase-list.submitapproval')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-submitquotation') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Quotation Submit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_14 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-approvalga', 'purchase-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-approvalga') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 1</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_15 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-approvalga2', 'purchase-approve2')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-approvalga2') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_16 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-approvalga3', 'purchase-approve3')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('purchase-approvalga3') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 3</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['purchasing'])){{ 'bg-slate-900' }}@endif"
                                x-data="{ open: {{ Route::is('po-presystem.list', 'po-presystem.form', 'po-presystem.only', 'po-presystem.view', 'po-presystem.form', 'po-presystem.edit', 'po-presystem.updatepage') ? 1 : 0 }} }">
                                <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['purchasing'])){{ 'hover:text-slate-200' }}@endif"
                                    href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                    <div class="flex justify-between">
                                        <div class="text-left">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">PO Pre System</span>
                                        </div>
                                        <!-- Icon -->
                                        <div
                                            class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['purchasing'])){{ 'rotate-180' }}@endif"
                                                :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                    <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['purchasing'])){{ 'hidden' }}@endif"
                                        :class="open ? '!block' : 'hidden'">
                                        @if (Auth::user()->ga_11 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('po-presystem.only', 'po-presystem.view')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('po-presystem.only') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_11 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('po-presystem.list', 'po-presystem.form')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('po-presystem.list') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_12 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('po-presystem.edit', 'po-presystem.updatepage')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('po-presystem.edit') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                                {{-- <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-kpi')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('purchase-kpi') }}">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Goods/Order Receipt</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-kpi')){{ '!text-indigo-500' }}@endif"
                                    href="{{ route('purchase-kpi') }}">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchase KPI</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-inventory')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('purchase-order') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchase Order</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-request')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('purchase-request') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchase Request</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-approval')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('purchase-approval') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Purchase Request Approval</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('purchase-request')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('purchase-request') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">RAB</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- Inventory & COA -->
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['inventory'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['inventory']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['inventory'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['inventory'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['inventory'])){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                        & COA</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), [''])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('invaging')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('invaging') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            Aging</span>
                                    </a>
                                </li>
                                @if (Auth::user()->role == '100'|| Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '800' || Auth::user()->role == '801' || Auth::user()->role == '802' || Auth::user()->role == '803' || Auth::user()->role == '900' || Auth::user()->role == '901' || Auth::user()->role == '902' || Auth::user()->role == '903')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cogs')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('cogs') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            COGS</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('doi')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('doi') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            DOI</span>
                                    </a>
                                </li>
                                @endif
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('expiredgoods')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('expiredgoods') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            Expired Good</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('invlist')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('invlist') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            Stock</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('turnover')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('turnover') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            Turn Over</span>
                                    </a>
                                </li> --}}
                    
                                {{-- <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('tasks-kanban')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('tasks-kanban') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            List</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('tasks-list')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('tasks-list') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory
                                            COA List</span>
                                    </a>
                                </li> --}}
                            {{-- </ul>
                        </div>
                    </li> --}}

                    <!-- Logistic -->
                    {{-- @if (Auth::user()->role == '100'|| Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '300' || Auth::user()->role == '301' || Auth::user()->role == '302' || Auth::user()->role == '303' || Auth::user()->role == '500' || Auth::user()->role == '501' || Auth::user()->role == '502' || Auth::user()->role == '503' || Auth::user()->role == '800' || Auth::user()->role == '801' || Auth::user()->role == '802' || Auth::user()->role == '803' || Auth::user()->role == '900' || Auth::user()->role == '901' || Auth::user()->role == '902' || Auth::user()->role == '903')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['logistic'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['logistic']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['logistic'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['logistic'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M16 13v4H8v-4H0l3-9h18l3 9h-8Z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['logistic'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="m23.72 12 .229.686A.984.984 0 0 1 24 13v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-8c0-.107.017-.213.051-.314L.28 12H8v4h8v-4H23.72ZM13 0v7h3l-4 5-4-5h3V0h2Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Logistic</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['logistic'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('delivery-orders')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('delivery-orders') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Delivery Order</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('do-update*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('do-update') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delivery Order - Update</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('damage-lost*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('damage-lost') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delivery Order - Damage/Lost</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif --}}
                    <!-- sales -->
                    {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['sales'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['sales']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['sales'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['sales'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif"
                                            d="M4.418 19.612A9.092 9.092 0 0 1 2.59 17.03L.475 19.14c-.848.85-.536 2.395.743 3.673a4.413 4.413 0 0 0 1.677 1.082c.253.086.519.131.787.135.45.011.886-.16 1.208-.474L7 21.44a8.962 8.962 0 0 1-2.582-1.828Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['sales'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M10.034 13.997a11.011 11.011 0 0 1-2.551-3.862L4.595 13.02a2.513 2.513 0 0 0-.4 2.645 6.668 6.668 0 0 0 1.64 2.532 5.525 5.525 0 0 0 3.643 1.824 2.1 2.1 0 0 0 1.534-.587l2.883-2.882a11.156 11.156 0 0 1-3.861-2.556Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['sales'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M21.554 2.471A8.958 8.958 0 0 0 18.167.276a3.105 3.105 0 0 0-3.295.467L9.715 5.888c-1.41 1.408-.665 4.275 1.733 6.668a8.958 8.958 0 0 0 3.387 2.196c.459.157.94.24 1.425.246a2.559 2.559 0 0 0 1.87-.715l5.156-5.146c1.415-1.406.666-4.273-1.732-6.666Zm.318 5.257c-.148.147-.594.2-1.256-.018A7.037 7.037 0 0 1 18.016 6c-1.73-1.728-2.104-3.475-1.73-3.845a.671.671 0 0 1 .465-.129c.27.008.536.057.79.146a7.07 7.07 0 0 1 2.6 1.711c1.73 1.73 2.105 3.472 1.73 3.846Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sales</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['job'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['sales'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200')    
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('salesglobal')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('salesglobal') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Corporate Sales</span>
                                    </a>
                                </li>     
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201')    
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('teamsales')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('teamsales') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Team Sales</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')                                    
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('yoursales')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('yoursales') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Your Sales</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')                                    
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('invoice')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('invoice') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sales Invoice</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif --}}
                    <!-- Finance -->
                    {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '800' || Auth::user()->role == '801' || Auth::user()->role == '802' || Auth::user()->role == '803')  
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['finance', 'efaktur']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif"
                                            d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Finance</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['finance', 'efaktur'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['finance'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('ar-days-finance')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('ar-days-finance') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">AR
                                            Days - All Customer</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('balancesheet-finance')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('balancesheet-finance') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fin
                                            - Balance Sheet</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('upload-tax')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('upload-tax') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fin
                                            - E-Faktur</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('pnls-finance')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('pnls-finance') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fin
                                            - Profit & Lost</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('credit-cards')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('credit-cards') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Order
                                            Tax List</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transaction-details')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transaction-details') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">transaction
                                            Details</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('transactions')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('transactions') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">transaction</span>
                                    </a>
                                </li> --}}
                        {{-- </div>
                    </li>
                    @endif --}}

                    <!-- GA -->
                    @if (Auth::user()->ga == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['ga']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg  xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-7 w-7 icon icon-tabler icon-tabler-tools" viewBox="0 0 24 24" stroke-width="1" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>
                                        <path class="fill-current @if(in_array(Request::segment(1), ['ga'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4" />
                                        <path d="M14.5 5.5l4 4" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['ga'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M12 8l-5 -5l-4 4l5 5" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['ga'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M7 8l-1.5 1.5" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['ga'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M16 12l5 5l-4 4l-5 -5" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['ga'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M16 17l-1.5 1.5" />
                                      </svg>
                                        <span
                                            class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">GA</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->ga == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('office-catalogue*', 'office-inventoryonly', 'office-inventory', 'inventory-code', 'office-inventory.view', 'office-inventory.edit', 'office-inventory.updatepage', 'office-inventory.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Asset Code</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_8 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('office-catalogue*')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('office-catalogue') }}">
                                                    <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Catalogue</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_4 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('office-inventoryonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('office-inventoryonly') }}">
                                                    <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_5 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('office-inventory', 'inventory-code', 'office-inventory.view')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('office-inventory') }}">
                                                    <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_6 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('office-inventory.edit', 'office-inventory.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('office-inventory.edit') }}">
                                                    <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_7 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('office-inventory.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('office-inventory.deletepage') }}">
                                                    <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->ga == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('listformfa.listonly', 'listformfa.viewpageform', 'listformfa.list', 'fixedasset', 'fixedasset.editgenerate', 'fixedasset.updatepage', 'fixedasset.generateFA', 'fixedasset.generatepage', 'fixedasset.list') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fixed Asset</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_9 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('listformfa.listonly', 'listformfa.viewpageform')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('listformfa.listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List (M. Input)</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_10 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('listformfa.list', 'fixedasset')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('listformfa.list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New (M. Input)</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_10 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('fixedasset.editgenerate', 'fixedasset.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('fixedasset.editgenerate') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit (M. Input)</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_10 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('fixedasset.generateFA', 'fixedasset.generatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('fixedasset.generateFA') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Generate SNFA #</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_9 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('fixedasset.list')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('fixedasset.list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">SNFA Detail</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->ga == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('assigned-asset.listonly', 'assigned-asset.view', 'assigned-asset.updatepage', 'assigned-asset.submitpage', 'assigned-asset.list', 'assigned-asset', 'assigned-approvalga', 'assigned-approve1') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">FA Assigned</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('assigned-asset.listonly', 'assigned-asset.view', 'assigned-asset.updatepage', 'assigned-asset.submitpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('assigned-asset.listonly') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('assigned-asset.list', 'assigned-asset')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('assigned-asset.list') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Assigned/Return</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('assigned-approvalga', 'assigned-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('assigned-approvalga') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (1)
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                x-data="{ open: {{ Route::is('rabLpjList') ? 1 : 0 }} }">
                                <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                    href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                    <div class="flex justify-between">
                                        <div class="text-left">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">RAB LPJ</span>
                                        </div>
                                        <!-- Icon -->
                                        <div
                                            class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                    <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                        :class="open ? '!block' : 'hidden'">
                                        @if (1)
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabLpjList')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rabLpjList') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_18 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabLpjCreate')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rabLpjCreate') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_17 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-printsubmit', 'rab-list.submitpage', 'rab-list.signature')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rab-printsubmit') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print/Submit RAB</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_19 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-approvalga', 'rab-approve1')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rab-approvalga') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 1</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_20 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-approvalga2', 'rab-approve2')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rab-approvalga2') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_21 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-summary')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rab-summary') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Summary</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if (Auth::user()->ga_28 == '1')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-listenforced')){{ '!text-indigo-500' }}@endif"
                                                href="{{ route('rab-listenforced') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print Enforced</span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                                @endif
                                @if (Auth::user()->ga_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('rab-listonly', 'rab-list.view', 'rab-list.updatepage', 'rab-list.clonepage', 'rab-list', 'rabga', 'rab-printsubmit', 'rab-list.submitpage', 'rab-list.signature', 'rab-approvalga', 'rab-approve1', 'rab-approvalga2', 'rab-approve2', 'rab-approvalga3', 'rab-approve3', 'rab-summary', 'rab-listenforced') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">RAB</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-listonly', 'rab-list.view', 'rab-list.updatepage', 'rab-list.clonepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-list', 'rabga')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-printsubmit', 'rab-list.submitpage', 'rab-list.signature')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-printsubmit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print/Submit RAB</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-approvalga', 'rab-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-approvalga') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 1</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_20 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-approvalga2', 'rab-approve2')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-approvalga2') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                                </a>
                                            </li>
                                            @endif
                                            {{-- @if (Auth::user()->ga_21 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-approvalga3', 'rab-approve3')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-approvalga3') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 3</span>
                                                </a>
                                            </li>
                                            @endif --}}
                                            @if (Auth::user()->ga_21 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-summary')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-summary') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Summary</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_28 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rab-listenforced')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rab-listenforced') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print Enforced</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->ga_22 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['ga'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('reimburse-listonly', 'reimburse-list', 'reimburse-list.view', 'reimburse-list.signature', 'reimburse-list.submitpage', 'reimburse-list.updatepage', 'reimburse-request', 'reimburse-approval', 'reimburse-approve1', 'reimburse-approval2', 'reimburse-approve2', 'reimburse-list.printvoucher', 'reimburse-list.submitpaymentprove', 'reimburse-list.submitpayment', 'reimburse-list.editpaymentprove') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reimbursement</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_22 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-listonly', 'reimburse-list.view', 'reimburse-list.signature', 'reimburse-list.submitpage', 'reimburse-list.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_23 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-list', 'reimburse-request')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_25 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-approval', 'reimburse-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-approval') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 1</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_25 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-approval2', 'reimburse-approve2')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-approval2') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_26 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-list.printvoucher')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-list.printvoucher') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print Form</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if (Auth::user()->ga == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['inventory'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['inventory']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['inventory'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['inventory'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['inventory'])){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                    </svg>
                                        <span
                                            class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inventory</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['inventory'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['inventory'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->ga == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['inventory-stock'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('inbound-inventory.listonly', 'inbound-inventory.list', 'inbound-inventory.form', 'inbound-inventoryedit', 'inbound-inventory.updatepage', 'inbound-inventorydeletepage', 'inbound-printconfirm', 'inbound-inventory.confirmpage', 'inbound-inventory.signature') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inbound Inventory</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['ga'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['ga'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('inbound-inventory.listonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('inbound-inventory.listonly') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('inbound-inventory.list', 'inbound-inventory.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('inbound-inventory.list') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('inbound-inventoryedit', 'inbound-inventory.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('inbound-inventoryedit') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('inbound-inventorydeletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('inbound-inventorydeletepage') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('inbound-printconfirm', 'inbound-inventory.confirmpage', 'inbound-inventory.signature')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('inbound-printconfirm') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print/Confirmation</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->ga == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['outbound-order'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('outbound', 'outbound-inventory', 'outbound-inventoryonly', 'outbound-inventoryedit', 'outbound-inventorydeletepage','outbound-printsubmit', 'outbound-inventory.signature', 'outbound-inventory.updatepage', 'outbound-inventory.submitpage', 'outbound-inventory.view', 'outbound-approvalga', 'outbound-approve1', 'outbound-printlist') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['outbound-inventory'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Outbound Inventory</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['outbound-inventory'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['outbound-inventory'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->ga_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-inventoryonly', 'outbound-inventory.view')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-inventoryonly') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-inventory', 'outbound')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-inventory') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-inventoryedit', 'outbound-inventory.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-inventoryedit') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-inventorydeletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-inventorydeletepage') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-printsubmit', 'outbound-inventory.submitpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-printsubmit') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Submit Approval</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-approvalga', 'outbound-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-approvalga') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outbound-printlist', 'outbound-inventory.signature')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outbound-printlist') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print</span>
                                                </a>
                                            </li>
                                            @endif
                                            {{-- @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('assigned-approvalga', 'assigned-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('assigned-approvalga') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->ga_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('assigned-approvalga', 'assigned-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('assigned-approvalga') }}">
                                                        <span
                                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 3</span>
                                                </a>
                                            </li>
                                            @endif --}}
                                        </ul>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if (Auth::user()->ga == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['finance'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['finance']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['finance'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['finance'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['finance'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif" d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['finance'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                        <span
                                            class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Finance</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['finance'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['finance'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['finance'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('cost-listonly', 'cost-list', 'cost-list.view', 'cost-list.signature', 'cost-list.submitpage', 'cost-list.updatepage', 'costcenter-request', 'costcenter-approval', 'costcenter-approval-approve1', 'cost-list.printvoucher', 'cost-list.submitpaymentproof', 'cost-list.submitpayment', 'cost-list.editpaymentproof') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['finance'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cost Center</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['finance'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['finance'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cost-listonly', 'cost-list.view', 'cost-list.signature', 'cost-list.submitpage', 'cost-list.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cost-listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cost-list', 'costcenter-request')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cost-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            {{-- <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('costcenter-approval', 'costcenter-approval-approve1')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('costcenter-approval') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval</span>
                                                </a>
                                            </li> --}}
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cost-list.printvoucher')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cost-list.printvoucher') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Print Form</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['finance'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('payment-listonly', 'payment-list', 'payment-list.form', 'payment-list.confirmpaymentlist', 'payment-list.confirmpaymentpage', 'payment-list.cancelpaymentlist', 'payment-list.payupdate', 'payment-list.updatepage', 'form.payment') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['finance'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Payment</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['finance'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['finance'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-listonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list', 'payment-list.form', 'form.payment')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            {{-- <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.payupdate', 'payment-list.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.payupdate') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li> --}}
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.confirmpaymentlist', 'payment-list.confirmpaymentpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.confirmpaymentlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Confirm Payment</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.cancelpaymentlist')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.cancelpaymentlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cancel Payment</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['finance'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('payment-listonly', 'payment-list', 'payment-list.form', 'payment-list.confirmpaymentlist', 'payment-list.confirmpaymentpage', 'payment-list.cancelpaymentlist', 'payment-list.payupdate', 'payment-list.updatepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['finance'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Overbooking</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['finance'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['finance'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-listonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-listonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list', 'payment-list.updatepage', 'payment-list.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.payupdate', 'payment-list.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.payupdate') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.confirmpaymentlist', 'payment-list.confirmpaymentpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.confirmpaymentlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Confirm Payment</span>
                                                </a>
                                            </li>
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('payment-list.cancelpaymentlist')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('payment-list.cancelpaymentlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cancel Payment</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- HR -->
                    @if (Auth::user()->hr == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['hr'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['hr']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['hr'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['hr'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                                cx="18.5" cy="5.5" r="4.5" />
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['hr'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                                cx="5.5" cy="5.5" r="4.5" />
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['hr'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                                cx="18.5" cy="18.5" r="4.5" />
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['hr'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                                cx="5.5" cy="18.5" r="4.5" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">HR</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['hr'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['hr'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->hr_1 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['hr'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('attendancelist', 'attendancelist-all') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['hr'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Attendance</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['hr'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['hr'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->hr_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('attendancelist')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('attendancelist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('attendancelist-all')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('attendancelist-all') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List ALL</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->hr_3 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['hr'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('employeeonly', 'employee', 'employee.form', 'employee.edit', 'employee.deletepage', 'employee.updatepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['hr'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Employee</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['hr'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['hr'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->hr_3 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('employeeonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('employeeonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_4 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('employee', 'employee.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('employee') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_5 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('employee.edit', 'employee.updatepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('employee.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_6 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('employee.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('employee.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->hr_7 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['hr'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('leaverequest-all*', 'leaverequests*', 'leaveallow', 'leaveapproval', 'leaveapproval2') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['hr'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Leave Request</span>
                                            </div> 
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['hr'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['hr'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->hr_7 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('leaverequest-all*')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('leaverequest-all') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List ALL</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_8 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('leaverequests*')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('leaverequests') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_9 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('leaveallow')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('leaveallow') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Leave
                                                        Allowance</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_10 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('leaveapproval')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('leaveapproval') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 1
                                                        </span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hr_11 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('leaveapproval2')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('leaveapproval2') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval 2</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                <!-- <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('shop-2')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('shop-2') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Shop
                                            2</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('product')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('product') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Single
                                            Product</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cart')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('cart') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cart</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cart-2')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('cart-2') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cart
                                            2</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cart-3')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('cart-3') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cart
                                            3</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('pay')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('pay') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pay</span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </li>
                    @endif
                    <!-- Master Data -->
                    @if (Auth::user()->master_data == '1')                        
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['data-master']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['ga'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['data-master'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M13 6.068a6.035 6.035 0 0 1 4.932 4.933H24c-.486-5.846-5.154-10.515-11-11v6.067Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['data-master'])){{ 'text-indigo-500' }}@else{{ 'text-slate-700' }}@endif"
                                            d="M18.007 13c-.474 2.833-2.919 5-5.864 5a5.888 5.888 0 0 1-3.694-1.304L4 20.731C6.131 22.752 8.992 24 12.143 24c6.232 0 11.35-4.851 11.857-11h-5.993Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['data-master'])){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M6.939 15.007A5.861 5.861 0 0 1 6 11.829c0-2.937 2.167-5.376 5-5.85V0C4.85.507 0 5.614 0 11.83c0 2.695.922 5.174 2.456 7.17l4.483-3.993Z" />
                                    </svg>
                                        <span
                                            class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Master Data</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->md_1 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('bank', 'bank.form', 'bank.edit', 'bank.deletepage', 'banklist') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Bank</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('bank')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('bank') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('banklist', 'bank.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('banklist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_3 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('bank.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('bank.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_4 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('bank.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('bank.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_1 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('rabbank', 'rabbanklist', 'rabbank.form', 'rabbank.edit', 'rabbank.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">RAB Benef Bank</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabbank')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabbank') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabbanklist', 'rabbank.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabbanklist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_3 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabbank.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabbank.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_4 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabbank.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabbank.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_5 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('m-brand', 'm-brandlist', 'm-model', 'm-brand.form', 'm-brand.edit', 'm-model.edit', 'm-brand.deletepage', 'm-model.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Brand</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_5 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-brand', 'm-model')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-brand') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_6 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-brandlist', 'm-brand.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-brandlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_7 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-brand.edit', 'm-model.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-brand.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_8 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-brand.deletepage', 'm-model.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-brand.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_13 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('child-company', 'child-companylist', 'child-company.form', 'child-company.edit', 'child-company.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Child Company</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_13 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('child-company')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('child-company') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_14 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('child-companylist', 'child-company.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('child-companylist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_15 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('child-company.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('child-company.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_16 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('child-company.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('child-company.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_1 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('cidbanklist', 'cidbank', 'cidbank.form', 'cidbank.edit', 'cidbank.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">CID Bank</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cidbank')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cidbank') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cidbanklist', 'cidbank.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cidbanklist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_3 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cidbank.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cidbank.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_4 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('cidbank.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('cidbank.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('costcenter-typelist', 'costcenter-type', 'costcenter-type.form', 'costcenter-type.edit', 'costcenter-type.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cost Center Type</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('costcenter-type')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('costcenter-type') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('costcenter-typelist', 'costcenter-type.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('costcenter-typelist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('costcenter-type.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('costcenter-type.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_20 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('costcenter-type.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('costcenter-type.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('m-departmentlist', 'm-department', 'm-subdepartment', 'm-department.form', 'm-department.edit', 'm-subdepartment.edit', 'm-department.deletepage', 'm-subdepartment.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Department</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-department', 'm-subdepartment')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-department') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-departmentlist', 'm-department.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-departmentlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-department.edit', 'm-subdepartment.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-department.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_20 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-department.deletepage', 'm-subdepartment.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-department.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['m-approval'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('outboundapprovalto', 'outboundapprovaltoonly', 'outboundapprovalto.deletepage', 'outboundapprovalto.editpage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['m-approval'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Outbound Approval To</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['m-approval'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['m-approval'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outboundapprovaltoonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outboundapprovaltoonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outboundapprovalto')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outboundapprovalto') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outboundapprovalto.editpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outboundapprovalto.editpage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('outboundapprovalto.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('outboundapprovalto.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['m-approval'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('prapproval1to', 'prapproval1toonly', 'prapproval1to.deletepage', 'prapproval1to.editpage', 'prapproval2to', 'prapproval2toonly', 'prapproval2to.deletepage', 'prapproval2to.editpage', 'prapproval3to', 'prapproval3toonly', 'prapproval3to.deletepage', 'prapproval3to.editpage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['m-approval'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">PR Approval To</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['m-approval'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['m-approval'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('prapproval1toonly', 'prapproval2toonly', 'prapproval3toonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('prapproval1toonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('prapproval1to', 'prapproval2to', 'prapproval3to')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('prapproval1to') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('prapproval1to.editpage', 'prapproval2to.editpage', 'prapproval3to.editpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('prapproval1to.editpage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('prapproval1to.deletepage', 'prapproval2to.deletepage', 'prapproval3to.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('prapproval1to.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['m-approval'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('rabapproval1to', 'rabapproval1toonly', 'rabapproval1to.deletepage', 'rabapproval1to.editpage', 'rabapproval2to', 'rabapproval2toonly', 'rabapproval2to.deletepage', 'rabapproval2to.editpage', 'rabapproval3to', 'rabapproval3toonly', 'rabapproval3to.deletepage', 'rabapproval3to.editpage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['m-approval'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">RAB Approval To</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['m-approval'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['m-approval'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabapproval1toonly', 'rabapproval2toonly', 'rabapproval3toonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabapproval1toonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabapproval1to', 'rabapproval2to', 'rabapproval3to')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabapproval1to') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabapproval1to.editpage', 'rabapproval2to.editpage', 'rabapproval3to.editpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabapproval1to.editpage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('rabapproval1to.deletepage', 'rabapproval2to.deletepage', 'rabapproval3to.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('rabapproval1to.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['m_approval'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('reimburseapprovalto', 'reimburseapprovaltoonly', 'reimburseapprovalto.deletepage', 'reimburseapprovalto.editpage', 'reimburseapproval2to', 'reimburseapproval2toonly', 'reimburseapproval2to.deletepage', 'reimburseapproval2to.editpage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['m_approval'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reimburse Apprv To</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['m_approval'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['m_approval'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburseapprovaltoonly', 'reimburseapproval2toonly')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburseapprovaltoonly') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburseapprovalto', 'reimburseapproval2to')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburseapprovalto') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburseapprovalto.editpage', 'reimburseapproval2to.editpage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburseapprovalto.editpage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburseapprovalto.deletepage', 'reimburseapproval2to.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburseapprovalto.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_17 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('reimburse-typelist', 'reimburse-type', 'reimburse-type.form', 'reimburse-type.edit', 'reimburse-type.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reimbursement Type</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_17 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-type')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-type') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_18 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-typelist', 'reimburse-type.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-typelist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif  
                                            @if (Auth::user()->md_19 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-type.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-type.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_20 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('reimburse-type.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('reimburse-type.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_25 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('m-site-warehouselist', 'm-site-warehouse', 'm-site-warehouse.form', 'm-site-warehouse.edit', 'm-site-warehouse.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Site Warehouse</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_25 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-site-warehouse')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-site-warehouse') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_26 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-site-warehouselist', 'm-site-warehouse.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-site-warehouselist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_27 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-site-warehouse.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-site-warehouse.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_28 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-site-warehouse.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-site-warehouse.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_25 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('vat', 'vat.form', 'wht', 'wht.form') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tax</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_25 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('vat', 'vat.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('vat') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">VAT</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_27 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('wht', 'wht.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('wht') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">WHT</span>
                                                </a>
                                            </li>
                                            @endif
                                            {{-- @if (Auth::user()->md_26 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('ppn', 'ppn.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('ppn') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">PPN</span>
                                                </a>
                                            </li>
                                            @endif --}}
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_1 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('vehiclelist', 'vehicle', 'vehicle.form', 'vehicle.edit', 'vehicle.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vehicle</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_1 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('vehicle')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('vehicle') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_2 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('vehiclelist', 'vehicle.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('vehiclelist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_3 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('vehicle.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('vehicle.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_4 == '1')                                    
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('vehicle.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('vehicle.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->md_29 == '1')
                                <li class="mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['data-master'])){{ 'bg-slate-900' }}@endif"
                                    x-data="{ open: {{ Route::is('m-vendor', 'm-vendorlist', 'm-vendor.form', 'm-vendor.edit', 'm-vendor.deletepage') ? 1 : 0 }} }">
                                    <a class="text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['data-master'])){{ 'hover:text-slate-200' }}@endif"
                                        href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                        <div class="flex justify-between">
                                            <div class="text-left">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vendor</span>
                                            </div>
                                            <!-- Icon -->
                                            <div
                                                class="flex shrink-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                <svg class="mt-1 w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['data-master'])){{ 'rotate-180' }}@endif"
                                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                        <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['data-master'])){{ 'hidden' }}@endif"
                                            :class="open ? '!block' : 'hidden'">
                                            @if (Auth::user()->md_29 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-vendorlist')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-vendorlist') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_30 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-vendor', 'm-vendor.form')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-vendor') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">New</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_31 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-vendor.edit')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-vendor.edit') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Edit</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->md_32 == '1')
                                            <li class="mb-1 last:mb-0">
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('m-vendor.deletepage')){{ '!text-indigo-500' }}@endif"
                                                    href="{{ route('m-vendor.deletepage') }}">
                                                    <span
                                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Delete</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    <!-- KPI -->
                    {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['kpi'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['kpi']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['kpi'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['kpi'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['kpi'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['kpi'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['kpi'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">KPI</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['kpi'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['kpi'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('kpi/budget*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('budget') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">BD - Annual Budgeting</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('kpi/weekly-report*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('weekly-report') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">BD - Weekly Report</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('kpi/report-list*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('report-list') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">BD - Weekly Report List</span>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Request::is('kpi/kpi-view*')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('kpi-view') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">BD - KPI View</span>
                                    </a>
                                </li>
                                @endif
                        </div>
                    </li>
                    @endif --}}
                    <!-- Job Board -->
                    <!-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['job'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['job']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['job'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['job'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif"
                                            d="M4.418 19.612A9.092 9.092 0 0 1 2.59 17.03L.475 19.14c-.848.85-.536 2.395.743 3.673a4.413 4.413 0 0 0 1.677 1.082c.253.086.519.131.787.135.45.011.886-.16 1.208-.474L7 21.44a8.962 8.962 0 0 1-2.582-1.828Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['job'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M10.034 13.997a11.011 11.011 0 0 1-2.551-3.862L4.595 13.02a2.513 2.513 0 0 0-.4 2.645 6.668 6.668 0 0 0 1.64 2.532 5.525 5.525 0 0 0 3.643 1.824 2.1 2.1 0 0 0 1.534-.587l2.883-2.882a11.156 11.156 0 0 1-3.861-2.556Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['job'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M21.554 2.471A8.958 8.958 0 0 0 18.167.276a3.105 3.105 0 0 0-3.295.467L9.715 5.888c-1.41 1.408-.665 4.275 1.733 6.668a8.958 8.958 0 0 0 3.387 2.196c.459.157.94.24 1.425.246a2.559 2.559 0 0 0 1.87-.715l5.156-5.146c1.415-1.406.666-4.273-1.732-6.666Zm.318 5.257c-.148.147-.594.2-1.256-.018A7.037 7.037 0 0 1 18.016 6c-1.73-1.728-2.104-3.475-1.73-3.845a.671.671 0 0 1 .465-.129c.27.008.536.057.79.146a7.07 7.07 0 0 1 2.6 1.711c1.73 1.73 2.105 3.472 1.73 3.846Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Job
                                        Board</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['job'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['job'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('job-listing')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('job-listing') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Listing</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('job-post')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('job-post') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Job
                                            Post</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('company-profile')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('company-profile') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Company
                                            Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    <!-- Messages -->
                    <!-- <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['messages'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['messages'])){{ 'hover:text-slate-200' }}@endif"
                            href="{{ route('messages') }}">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['messages'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M14.5 7c4.695 0 8.5 3.184 8.5 7.111 0 1.597-.638 3.067-1.7 4.253V23l-4.108-2.148a10 10 0 01-2.692.37c-4.695 0-8.5-3.184-8.5-7.11C6 10.183 9.805 7 14.5 7z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['messages'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M11 1C5.477 1 1 4.582 1 9c0 1.797.75 3.45 2 4.785V19l4.833-2.416C8.829 16.85 9.892 17 11 17c5.523 0 10-3.582 10-8s-4.477-8-10-8z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Messages</span>
                                </div>
                                <div class="flex flex-shrink-0 ml-2">
                                    <span
                                        class="inline-flex items-center justify-center h-5 text-xs font-medium text-white bg-indigo-500 px-2 rounded">4</span>
                                </div>
                            </div>
                        </a>
                    </li> -->
                    <!-- Calendar -->
                    @if (Auth::user()->calendar == '1')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['calendar'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['calendar'])){{ 'hover:text-slate-200' }}@endif"
                            href="{{ route('calendar') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['calendar'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                        d="M1 3h22v20H1z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['calendar'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                        d="M21 3h2v4H1V3h2V1h4v2h10V1h4v2Z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Calendar</span>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if (Auth::user()->company_calendar == '1')
                        <!-- Company Calendar -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['company'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['company.calendar'])){{ 'hover:text-slate-200' }}@endif"
                                href="{{ route('company.calendar') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['company'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M1 3h22v20H1z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['company'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M21 3h2v4H1V3h2V1h4v2h10V1h4v2Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Corporate Calendar</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    
            <!-- Campaigns -->
                    {{-- <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['campaigns'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['campaigns'])){{ 'hover:text-slate-200' }}@endif"
                            href="{{ route('campaigns') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['campaigns'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                        d="M20 7a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 0120 7zM4 23a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 014 23z" />
                                    <path
                                        class="fill-current @if(in_array(Request::segment(1), ['campaigns'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                        d="M17 23a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 010-2 4 4 0 004-4 1 1 0 012 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1zM7 13a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 110-2 4 4 0 004-4 1 1 0 112 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Campaigns</span>
                            </div>
                        </a>
                    </li> --}}
                    {{-- @if (Auth::user()->role == '500') --}}
                    <!-- Management Report -->
                    {{-- @if (Auth::user()->role == '100' || Auth::user()->role == '101' || Auth::user()->role == '102')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['management-report'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['management-report']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['management-report'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['management-report'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M13 6.068a6.035 6.035 0 0 1 4.932 4.933H24c-.486-5.846-5.154-10.515-11-11v6.067Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['management-report'])){{ 'text-indigo-500' }}@else{{ 'text-slate-700' }}@endif"
                                            d="M18.007 13c-.474 2.833-2.919 5-5.864 5a5.888 5.888 0 0 1-3.694-1.304L4 20.731C6.131 22.752 8.992 24 12.143 24c6.232 0 11.35-4.851 11.857-11h-5.993Z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['management-report'])){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M6.939 15.007A5.861 5.861 0 0 1 6 11.829c0-2.937 2.167-5.376 5-5.85V0C4.85.507 0 5.614 0 11.83c0 2.695.922 5.174 2.456 7.17l4.483-3.993Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Management
                                        Report</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['management-report'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['management-report'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('ar-days')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('ar-days') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">AR
                                            Days - All Customer</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('pnls')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('pnls') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fin
                                            - Profit & Lost</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('balancesheet')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('balancesheet') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fin
                                            - Balance Sheet</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif --}}

                    {{-- @if (Auth::user()->google == '1') --}}
                         {{-- Google --}}
                        {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['google'])){{ 'bg-slate-900' }}@endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['google']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white transition duration-150"
                                :class="open && 'hover:text-slate-200'" href="#0"
                                @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['google'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                                cx="16" cy="8" r="8" />
                                            <circle
                                                class="fill-current @if(in_array(Request::segment(1), ['google'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                                cx="8" cy="16" r="8" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Google</span>
                                    </div>
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                            :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            @if (Auth::user()->google_calendar == '1')
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['google'])){{ 'hidden' }}@endif"
                                    :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('google-calendar')){{ '!text-indigo-500' }}@endif"
                                            href="{{ route('google-calendar') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Google Calendars</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </li>
                    @endif --}}

                    @if ((Auth::user()->role == '100') || (Auth::user()->role == '101') || (Auth::user()->role == '102'))
                        <!-- Setup Menu -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['setupmenu'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['menu-setting'])){{ 'hover:text-slate-200' }}@endif"
                                href="{{ route('menu-setting') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['setupmenu'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['setupmenu'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">OS Menu List Settings</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if ((Auth::user()->role == '100') || (Auth::user()->role == '101') || (Auth::user()->role == '102'))
                        <!-- Setup Menu -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['user-manager'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['user-manager'])){{ 'hover:text-slate-200' }}@endif"
                                href="{{ route('user-manager') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['user-manager'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['user-manager'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['user-manager'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['user-manager'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">User Manager</span>
                                </div>
                            </a>
                        </li>
                    @endif
                   

                    {{-- @endif --}}
                    <!-- Settings -->
                    <!-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['settings'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['settings']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['settings'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path
                                            class="fill-current @if(in_array(Request::segment(1), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Settings</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['settings'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['settings'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('account')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('account') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My
                                            Account</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('notifications')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('notifications') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My
                                            Notifications</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('apps')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('apps') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Connected
                                            Apps</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('plans')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('plans') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Plans</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('billing')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('billing') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Billing
                                            & Invoices</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('feedback')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('feedback') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Give
                                            Feedback</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    <!-- Utility -->
                    <!-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['utility'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['utility']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['utility'])){{ 'hover:text-slate-200' }}@endif"
                            href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['utility'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            cx="18.5" cy="5.5" r="4.5" />
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['utility'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            cx="5.5" cy="5.5" r="4.5" />
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['utility'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            cx="18.5" cy="18.5" r="4.5" />
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['utility'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            cx="5.5" cy="18.5" r="4.5" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Utility</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['utility'])){{ 'rotate-180' }}@endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['utility'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('changelog')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('changelog') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Changelog</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('roadmap')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('roadmap') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Roadmap</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('faqs')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('faqs') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">FAQs</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('empty-state')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('empty-state') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Empty
                                            State</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('404')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('404') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">404</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('knowledge-base')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('knowledge-base') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Knowledge
                                            Base</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                </ul>
            </div>
            <!-- More group -->
            <!-- <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                </h3>
                <ul class="mt-3">
                    Authentication
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                        <a class="block text-slate-200 hover:text-white transition duration-150"
                            :class="open && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600" d="M8.07 16H10V8H8.07a8 8 0 110 8z" />
                                        <path class="fill-current text-slate-400" d="M15 12L8 6v5H0v2h8v5z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Authentication</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="{ 'hidden': !open }" x-cloak>
                                <li class="mb-1 last:mb-0">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                            href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sign
                                                In</span>
                                        </a>
                                    </form>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                            href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sign
                                                Up</span>
                                        </a>
                                    </form>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                            href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reset
                                                Password</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Onboarding -->
                    <!-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                        <a class="block text-slate-200 hover:text-white transition duration-150"
                            :class="open && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600"
                                            d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                        <path class="fill-current text-slate-400"
                                            d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Onboarding</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['onboarding'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        href="{{ route('onboarding-01') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Step
                                            1</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        href="{{ route('onboarding-02') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Step
                                            2</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        href="{{ route('onboarding-03') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Step
                                            3</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        href="{{ route('onboarding-04') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Step
                                            4</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    {{-- @if ((Auth::user()->role == '100')||(Auth::user()->role == '101'))      
                    <!-- Components -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['component'])){{ 'bg-slate-900' }}@endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['component']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white transition duration-150"
                            :class="open && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['component'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"
                                            cx="16" cy="8" r="8" />
                                        <circle
                                            class="fill-current @if(in_array(Request::segment(1), ['component'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif"
                                            cx="8" cy="16" r="8" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Components</span>
                                </div>
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['component'])){{ 'hidden' }}@endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('button-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('button-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Button</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('form-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('form-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Input
                                            Form</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('dropdown-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('dropdown-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dropdown</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('alert-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('alert-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Alert
                                            & Banner</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('modal-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('modal-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Modal</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('pagination-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('pagination-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pagination</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('tabs-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('tabs-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tabs</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('breadcrumb-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('breadcrumb-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Breadcrumb</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('badge-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('badge-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Badge</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('avatar-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('avatar-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Avatar</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('tooltip-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('tooltip-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tooltip</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('accordion-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('accordion-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Accordion</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('icons-page')){{ '!text-indigo-500' }}@endif"
                                        href="{{ route('icons-page') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Icons</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif --}}
                <!-- </ul> -->
            <!-- </div> -->
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>