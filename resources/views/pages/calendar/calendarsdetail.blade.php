<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Calendar Detail ✨</h1>
            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            @foreach ($dataCalendars as $calendar )
            <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                <div class="flex flex-col h-full">
                    <!-- Card top -->
                    <div class="grow p-3">
                        <div class="flex justify-between items-start">
                            <!-- Image + name -->
                            <header>                
                                <div class="flex mb-2">
                                    <div class="mt-1 pr-1">
                                        <a class="inline-flex text-slate-800 hover:text-slate-900">
                                            <h2 class="text-xl leading-snug justify-center font-semibold">{{$calendar->calendar_name}}</h2>
                                        </a>
                                        <div class="flex items-center">{{$calendar->color_tag}}</div>
                                        
                                        <ul class="space-y-3 my-1">
                                            <!-- Comment -->
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">Type</div>
                                                    <div class="">{{$calendar->calendar_type}}</div>
                                                </div>
                                            </li>
                                            @if ($calendar->calendar_type == "group")
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">Invite List</div>
                                                    <div class="">{{$calendar->invitations}}</div>
                                                </div>
                                            </li>
                                            @endif
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">Start Time</div>
                                                    <div class="">{{date('m/d/Y h:i A', strtotime($calendar->start_time))}}</div>
                                                </div>
                                            </li>
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">End Time</div>
                                                    <div class="">{{date('m/d/Y h:i A', strtotime($calendar->end_time))}}</div>
                                                </div>
                                            </li>
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">Notes</div>
                                                    <div class="">{{$calendar->notes}}</div>
                                                </div>
                                            </li>
                                            <li class="flex items-start">
                                                <div class="grow">
                                                    <div class="text-sm font-semibold text-slate-800 mb-1">Add By</div>
                                                    <div class="">{{$calendar->username}}</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </header>           
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
