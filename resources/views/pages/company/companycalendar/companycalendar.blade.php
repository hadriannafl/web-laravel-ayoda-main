<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="calendar" x-init="initCalendar">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-4">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"><span class="coba"
                        x-text="`${monthNames[month]} ${year}`"></span> ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Previous month button -->
                <button
                    class="btn px-2.5 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600 disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
                    :disabled="month === 0 ? true : false" @click="month--; getDays()">
                    <span class="sr-only">Previous month</span><wbr />
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 16 16">
                        <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z" />
                    </svg>
                </button>

                <!-- Next month button -->
                <button
                    class="btn px-2.5 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600 disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
                    :disabled="month === 11 ? true : false" @click="month++; getDays()">
                    <span class="sr-only">Next month</span><wbr />
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 16 16">
                        <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                    </svg>
                </button>
                @if ((Auth::user()->role == '101') || (Auth::user()->role == '100') )
                <div class="flex">
                    <label class="text-slate-800 mb-3 ml-3 text-sm" for="users_schedule">Select Users Schedule : </label>
                    <select class="users_schedule ml-3 mb-3 text-xs" id="users_schedule" name="users_schedule">
                        <option value=""></option>
                        @foreach ($dataUsers as $dataUser)
                            <option value="{{ $dataUser->id }}" {{ $dataUser->id == app('request')->input('users_schedule') ? 'selected' : '' }}>{{ $dataUser->username }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <hr class="w-px h-full bg-slate-200 mx-1" />

                <!-- Create event button -->
                <!-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Create Event</span>
                </button> -->
                {{-- @if (Auth::user()->role != '101')                    
                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>Create Schedule</button>
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
                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Create Schedule</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
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
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Activity Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="name" name="name" class="form-input w-full px-2 py-1" type="text" required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Type</label>
                                            <select id="type" name="type" class="type form-select">
                                                <option selected disabled hidden>Select Here</option>
                                                <option value="personal">Personal</option>
                                                <option value="group">Group</option>
                                            </select>
                                        </div>
                                        <div id="div-invitation" class="hidden">
                                            <label class="block text-sm font-medium mb-1" for="invite">Invite</label>
                                            <select disabled id="select-invitation" class="form-select" name="users[]"
                                                multiple="multiple" style="width: 400px">
                                                @foreach ($dataUsers as $dataUser)
                                                <option value="{{ $dataUser->id }}">{{ $dataUser->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <input id="invite_id" name="invite_id"
                                                class="invite_id form-input w-full pl-11" type="text" / hidden>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Calendar
                                                Tag</label>
                                            <select id="calendarTag" name="calenderTag" class=" color form-select">
                                                <option selected disabled hidden>Select Here</option>
                                                @foreach ($calendarTags as $calendarTag)
                                                <option value="{{ $calendarTag->id }}">{{ $calendarTag->color_tag }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Start Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="start_date" name="start_date"
                                                class=" start_date form-input w-full px-2 py-1" type="datetime-local"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">End Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="end_date" name="end_date" class="form-input w-full px-2 py-1"
                                                type="datetime-local" required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="feedback">Notes</label>
                                            <textarea id="notes" name="notes" class="form-textarea w-full px-2 py-1" rows="4"
                                                required></textarea>
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
                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif --}}

            </div>

        </div>
       <!-- Filters and view buttons -->
       <div class="sm:flex sm:justify-between sm:items-center mb-4">

           <!-- Filters  -->
           <div class="mb-4 sm:mb-0 mr-2">
               <ul class="flex flex-wrap items-center ml-1">
                    <li class="m-1 getTag">
                        <div x-data="{ modalOpen: false }">
                                @foreach ($calendarTags as $calendarTag)
                                    <button class="btn-tag btn-sm bg-white border-slate-200 hover:border-slate-300 text-slate-500" @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                        <div class="w-1 h-3.5 {!! $calendarTag->value_color !!} shrink-0"><div hidden>{{ $calendarTag->id }}</div></div>
                                        <span class="ml-1.5">{{ $calendarTag->color_tag }}</span>
                                    </button>
                                @endforeach
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
                                <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                    @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800">Calendar Tag</div>
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
                                        <div class="px-5 py-4">
                                            <div class="text-sm">
                                                <div class="font-medium text-slate-800 mb-3"></div>
                                            </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="name">Color</label>
                                                        <input id="color1" name="color1" class="color1 color form-input w-full"/>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="name">Name Tag Color<span class="text-rose-500">*</span></label>
                                                        <input id="color_tag1" name="color_tag1" class="color_tag1 form-input w-full px-2 py-1 disabled:bg-slate-100" type="text" disabled/>
                                                    </div>
                                                </div>
                                        <form method="delete" class="tagdeleted">
                                         @csrf
                                                <!-- Modal footer -->
                                                <div class="px-5 py-4 border-t border-slate-200 btn-mo">
                                                    
                                                </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </li>
                   @if ((Auth::user()->role == '101') || (Auth::user()->role == '100') )                       
                   <li class="m-1">
                       <div x-data="{ modalOpen: false }">
                           <button class="btn-sm bg-white border-slate-200 hover:border-slate-300 text-indigo-500"
                               @click.prevent="modalOpen = true" aria-controls="feedback-modal">+Add New</button>
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
                               <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                   @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                   <!-- Modal header -->
                                   <div class="px-5 py-3 border-b border-slate-200">
                                       <div class="flex justify-between items-center">
                                           <div class="font-semibold text-slate-800">Add New Tag Color</div>
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
                                   <form action="{{ route('calendar.createtag') }}" method="post">
                                       @csrf
                                       <!-- Modal content -->
                                       <div class="px-5 py-4">
                                           <div class="text-sm">
                                               <div class="font-medium text-slate-800 mb-3"></div>
                                           </div>
                                           <div class="space-y-3">
                                               <div>
                                                   <label class="block text-sm font-medium mb-1" for="name">Choose
                                                       Color</label>
                                                   <select id="color" name="color" class=" color form-select" required>
                                                       <option selected disabled hidden>Select Here</option>
                                                       @foreach ($colors as $color)
                                                       <option value="{{ $color->id }}">{{ $color->name_color }}
                                                       </option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                               <div>
                                                   <label class="block text-sm font-medium mb-1" for="name">Name Tag
                                                       Color<span class="text-rose-500">*</span></label>
                                                   <input id="color_tag" name="color_tag"
                                                       class="color_tag form-input w-full px-2 py-1" type="text"
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
                                               <button type="submit"
                                                   class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Submit</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </li>
                   @endif
               </ul>
           </div>
       </div>

        <!-- Calendar table -->
        <div class="bg-white rounded-sm shadow overflow-hidden" x-cloak>

            <!-- Days of the week -->
            <div class="grid grid-cols-7 gap-px border-b border-slate-200">
                <template x-for="(day, index) in dayNames" :key="index">
                    <div class="px-1 py-3">
                        <div class="text-slate-500 text-sm font-medium text-center lg:hidden"
                            x-text="day.substring(0,3)"></div>
                        <div class="text-slate-500 text-sm font-medium text-center hidden lg:block" x-text="day"></div>
                    </div>
                </template>
            </div>

            <!-- Day cells -->
            <div class="grid grid-cols-7 gap-px bg-slate-200 day-cells">
                <!-- Diagonal stripes pattern -->
                <svg class="sr-only">
                    <defs>
                        <pattern id="stripes" patternUnits="userSpaceOnUse" width="5" height="5"
                            patternTransform="rotate(135)">
                            <line class="stroke-current text-slate-200 opacity-50" x1="0" y="0" x2="0" y2="5"
                                stroke-width="2" />
                        </pattern>
                    </defs>
                </svg>
                <!-- Empty cells (previous month) -->
                <template x-for="blankday in startingBlankDays">
                    <div class="bg-slate-50 h-20 sm:h-28 lg:h-36">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <rect width="100%" height="100%" fill="url(#stripes)" />
                        </svg>
                    </div>
                </template>
                <!-- Days of the current month -->
                <template x-for="(day, dayIndex) in daysInMonth" :key="dayIndex">
                    <div class="relative bg-white h-20 sm:h-28 lg:h-36 overflow-hidden">
                        <div class="h-full flex flex-col justify-between">
                            <!-- Events -->
                            <div class="grow flex flex-col relative p-0.5 sm:p-1.5 overflow-hidden" > 
                                <div x-data="{ modalOpen: false }">
                                    <template x-for="event in getEvents(day)">
                                        <button target="#event" id="event" class="btn-event relative w-full text-left mb-1" @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                            <div class="px-2 py-0.5 rounded overflow-hidden" :class="{
                                                    'text-white bg-sky-500': event.eventColor === 'bg-sky-500',
                                                    'text-white bg-indigo-500': event.eventColor === 'bg-indigo-500',
                                                    'text-white bg-emerald-500': event.eventColor === 'bg-emerald-500',
                                                    'text-white bg-rose-500': event.eventColor === 'bg-rose-500',
                                                    'text-white bg-blue-600': event.eventColor === 'bg-blue-600',
                                                    'text-white bg-red-600': event.eventColor === 'bg-red-600',
                                                    'text-white bg-purple-600': event.eventColor === 'bg-purple-600',
                                                    'text-white bg-amber-600': event.eventColor === 'bg-amber-600',
                                                    'text-white bg-cyan-600': event.eventColor === 'bg-cyan-600',
                                                    'text-white bg-pink-600': event.eventColor === 'bg-pink-600',
                                                    'text-white bg-fuchsia-600': event.eventColor === 'bg-fuchsia-600'
                                                }">
                                                {{-- Calendar ID --}}
                                                <div class="idrec hidden" x-text="event.idrec"></div>
                                                <div class="add_by hidden" x-text="event.add_by"></div>
                                                <!-- Event name -->
                                                <div class="text-xs font-semibold truncate" x-text="event.eventName"></div>
                                                <!-- Event time -->
                                                <div class="text-xs uppercase truncate hidden sm:block">
                                                    <!-- Start date -->
                                                    <template x-if="event.eventStart">
                                                        <span
                                                            x-text="event.eventStart.toLocaleTimeString([], {hour12: true, hour: 'numeric', minute:'numeric'})"></span>
                                                    </template>
                                                    <!-- End date -->
                                                    <template x-if="event.eventEnd">
                                                        <span>
                                                            - <span
                                                                x-text="event.eventEnd.toLocaleTimeString([], {hour12: true, hour: 'numeric', minute:'numeric'})"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- Modal backdrop -->
                                            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                                            x-cloak></div>
                                    </template>
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
                                                @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                                <!-- Modal header -->
                                                <div class="px-5 py-3 border-b border-slate-200">
                                                    <div class="flex justify-between items-center">
                                                        <div class="font-semibold text-slate-800">View Schedule</div>
                                                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                            <div class="sr-only">Close</div>
                                                            <svg class="w-4 h-4 fill-current">
                                                                <path
                                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <form method="post" class="form_calendar_update">
                                                    @csrf
                                                    <!-- Modal content -->
                                                    <div class="px-5 py-4">
                                                        <div class="text-sm">
                                                            <div class="font-medium text-slate-800 mb-3"></div>
                                                        </div>
                                                        <div class="space-y-3">
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="name">Activity Name<span
                                                                        class="text-rose-500">*</span></label>
                                                                <input id="id" name="id" class="id form-input w-full px-2 py-1" type="text" hidden/>
                                                                <input id="name1" name="name1" class="name1 form-input w-full px-2 py-1" type="text" required />
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="type1">Type</label>
                                                                <select id="type1" name="type1" class="type1 form-select" disabled>
                                                                    <option selected disabled hidden>Select Here</option>
                                                                    <option value="personal">Personal</option>
                                                                    <option value="group">Group</option>
                                                                </select>
                                                            </div>
                                                            <div class="hidden div-invitation1">
                                                                <label class="block text-sm font-medium mb-1" for="invite">Invite</label>
                                                                <div class="invitation"></div>
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="name">Calendar
                                                                    Tag</label>
                                                                <select id="calendar_tag1" name="calender_tag1" class="calendar_tag1 color form-select">
                                                                    <option selected disabled hidden>Select Here</option>
                                                                    @foreach ($calendarTags as $calendarTag)
                                                                    <option value="{{ $calendarTag->id }}" {{ $calendarTag->id ? ' selected' : '' }}>{{ $calendarTag->color_tag }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="name">Start Date<span
                                                                        class="text-rose-500">*</span></label>
                                                                <input id="start_time1" name="start_time1"
                                                                    class=" start_time1 form-input w-full px-2 py-1" type="datetime-local"
                                                                    required />
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="name">End Date<span
                                                                        class="text-rose-500">*</span></label>
                                                                <input id="end_time1" name="end_time1" class="end_time1 form-input w-full px-2 py-1"
                                                                    type="datetime-local" required />
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="feedback">Notes</label>
                                                                <textarea id="notes1" name="notes1" class="notes1 form-textarea w-full px-2 py-1" rows="4"
                                                                    required></textarea>
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium mb-1" for="add_by">Add By<span
                                                                    class="text-rose-500">*</span></label>
                                                                <input id="add_by" name="add_by"
                                                                class=" add_by1 form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" readonly
                                                                disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (Auth::user()->role != '101')    
                                                    <!-- Modal footer -->
                                                    <div class="px-5 py-4 border-t border-slate-200 btn-action">
                                                        
                                                    </div>
                                                    @endif
                                                </form>
                                            </div>
                                            <!--<span class="oke" x-text="event.eventStart.toISOString().split('T')[0]"></span>-->
                                        </div>
                                    </div>
                                <div class="absolute bottom-0 left-0 right-0 h-4 bg-gradient-to-t from-white to-transparent pointer-events-none"
                                    aria-hidden="true"></div>
                            </div>
                            <!-- Cell footer -->
                            <div class="flex justify-between items-center p-0.5 sm:p-1.5">
                                <!-- More button (if more than 2 events) -->
                                <template x-if="getEvents(day).length > 2">
                                    <div class="ok">
                                        {{-- <span class="offering-date" x-text="dayIndex"></span> --}}
                                        <span class="hidden offering-date" x-text="`${year}-${monthNames.indexOf(monthNames[month]) + 1}-${day}`"></span>
                                        <a
                                            target="_blank"
                                            class="pointer offering-detail text-xs text-slate-500 font-medium whitespace-nowrap text-center sm:py-0.5 px-0.5 sm:px-2 border border-slate-200 rounded"
                                            onclick="test(this)">
                                            <span class="pointer md:hidden">+</span><span x-text="getEvents(day).length - 2"></span>
                                            <span class="pointer hidden md:inline">more</span>
                                        </a>
                                        <script>
                                            function test(ths) {
                                                let url = new URL(window.location.href);
                                                let urlRedirect;
                                                let offeringDate = $(ths).parent().children('.offering-date').text();
                                                if (url.search) {
                                                    urlRedirect = url.pathname + '/calendardetail' + url.search + '&start_time=' + offeringDate;
                                                } else {
                                                        urlRedirect = url.pathname + '/calendardetail?start_time=' + offeringDate;
                                                }
                                                console.log(urlRedirect);
                                                window.open(urlRedirect, '_blank') = urlRedirect;
                                            }
                                            $(document).ready(function () {
                                                
                                                // let url = new URL(window.location.href);
                                                // let urlRedirect;
                                                // const offeringDate = $('.offering-date').text();
                                                // if (url.search) {
                                                    //     urlRedirect = url.pathname + '/offeringdetail' + url.search + '&start_time=' + offeringDate;
                                                    // } else {
                                                        //     urlRedirect = url.pathname + '/offeringdetail?start_time=' + offeringDate;
                                                        // }
                                                // $('.offering-detail'). on('click', function(){
                                                //             // 
                                                //             console.log(`${day}`);
                                                //     console.log($('.offering-date')); 
                                                // });
                                                // $('.offering-detail').attr('href', urlRedirect);
                                            })
                                        </script>
                                    </div>
                                </template>
                                <!-- Day number -->
                                <button
                                    class="inline-flex ml-auto w-6 h-6 items-center justify-center text-xs sm:text-sm font-medium text-center rounded-full hover:bg-indigo-100"
                                    :class="{'text-indigo-500': isToday(day) }" x-text="day"></button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Empty cells (next month) -->
                <template x-for="blankday in endingBlankDays">
                    <div class="bg-slate-50 h-20 sm:h-28 lg:h-36">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <rect width="100%" height="100%" fill="url(#stripes)" />
                        </svg>
                    </div>
                </template>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            var dataCalendar = [];
            var items = {};
            @foreach ($dataCalendars as $item)
                items = {
                    add_by:"{{$item->add_by}}",
                    idrec: "{{ $item->idrec }}",
                    eventName: "{{ $item->calendar_name }}",
                    eventStart: new Date("{{ $item->start_time }}"),
                    eventEnd: new Date("{{ $item->end_time }}"),
                    eventColor: "{!! $item->value_color !!}"
                };
                dataCalendar.push(items);
            @endforeach

            
            Alpine.data('calendar', () => ({
                month: null,
                year: null,
                daysInMonth: [],
                startingBlankDays: [],
                endingBlankDays: [],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                events: dataCalendar,

                initCalendar() {
                    const today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.getDays();
                },

                isToday(date) {
                    const today = new Date();
                    const day = new Date(this.year, this.month, date);
                    return today.toDateString() === day.toDateString() ? true : false;
                },

                getEvents(date) {
                    return this.events.filter(e => new Date(e.eventStart.getFullYear(), e.eventStart.getMonth(), e.eventStart.getDate() ).getTime() <= new Date(this.year, this.month, date).getTime() && new Date(e.eventEnd.getFullYear(), e.eventEnd.getMonth(), e.eventEnd.getDate() ).getTime() >= new Date(this.year, this.month, date).getTime());
                },
                
                getDays() {
                    const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // starting empty cells (previous month)
                    const startingDayOfWeek = new Date(this.year, this.month).getDay();
                    let startingBlankDaysArray = [];
                    for (let i = 1; i <= startingDayOfWeek; i++) {
                        startingBlankDaysArray.push(i);
                    }


                    // ending empty cells (next month)
                    const endingDayOfWeek = new Date(this.year, this.month + 1, 0).getDay();
                    let endingBlankDaysArray = [];
                    for (let i = 1; i < 7 - endingDayOfWeek; i++) {
                        endingBlankDaysArray.push(i);
                    }

                    // current month cells
                    let daysArray = [];
                    for (let i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.startingBlankDays = startingBlankDaysArray;
                    this.endingBlankDays = endingBlankDaysArray;
                    this.daysInMonth = daysArray;
                }
            }));

        });
    </script>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#type').on('change', function () {
                const type = $(this).val();

                if (type == "personal") {
                    $('#div-invitation').addClass('hidden');
                    $('#select-invitation').attr('disabled');
                } else {
                    $('#div-invitation').removeClass('hidden');
                    $('#select-invitation').removeAttr('disabled');
                }
            })
            $('#select-invitation').select2();

            $('#users_schedule').select2();

            $('.day-cells').on("click", ".btn-event", function () {
                const calendarId = $(this).children().children().html();

                $(".form_calendar_update").attr('action', `/calendar/calendarupdate/${calendarId}`);
                $("input[name!='_token']").val("");
                $("select").val("");
                
                $.ajax({
                    type: "GET",
                    url: `/calendar/getupdate/${calendarId}`,
                    success: function (response) {
                        $(".name1").val(response.dataCalendars.calendar_name);
                        $(".notes1").val(response.dataCalendars.notes);
                        $(".type1").val(response.dataCalendars.calendar_type);
                        $(".calendar_tag1").val(response.dataCalendars.id_calendar_color);
                        $(".start_time1").val(response.dataCalendars.start_time);
                        $(".end_time1").val(response.dataCalendars.end_time);
                        $(".add_by1").val(response.dataCalendars.username);

                        if (response.dataCalendars.calendar_type == "personal") {
                            $('.div-invitation1').addClass('hidden');
                            $('.select_invitation1').attr('disabled');
                        } else {
                            $('.div-invitation1').removeClass('hidden');
                            $('.select_invitation1').removeAttr('disabled');
                        }

                        let dataUsers = [];
                        $.each(response.userLists, function (index, value) {
                            dataUsers.push(value.username);
                        });
                        
                        $('.invitation').html(dataUsers.join(", "));
                        const add_by = response.dataCalendars.add_by;
                        const auth_user = {{ Auth::user()->id  }};
                        
                        if (add_by == auth_user) {
                            const btn_delete = `<div class="flex flex-wrap justify-end space-x-2">
                                <button type="button" data-id_calendar="${response.dataCalendars.idrec}"
                                    class="btn-sm bg-red-400 border-slate-200 hover:border-slate-300 text-white btn-delete">
                                    Delete
                                </button>
                                <button type="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                            </div>`;
                            $('.btn-action').html(btn_delete);
                        } else{ 
                            $('.btn-action').empty();
                        }

                    }
                });
            });

            $('.btn-action').on("click", ".btn-delete",  function () {
                const id_calendar = $(this).data("id_calendar");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                            url: `/calendar/calendardelete/${id_calendar}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your schedule has been deleted.',
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

            $('#users_schedule').on("change", function () {
                const user_schedule_id = $(this).val();
                let url = new URL(window.location.href);

                if (user_schedule_id) {
                    url.searchParams.set('users_schedule', user_schedule_id);
                    window.location.href = url.href;
                } else {
                    window.location.href = url.pathname;
                }
            });

            $('.getTag').on("click", ".btn-tag", function () {
                const tagId = $(this).children().children().html();

                $(".tagdeleted").attr('action', `/company/companycalendar/tagdelete/${tagId}`);
                $("input[name!='_token']").val("");
                
                $.ajax({
                    type: "GET",
                    url: `/company/companycalendar/tagget/${tagId}`,
                    success: function (response) {
                        $(".id1").val(response.dataTag.id);
                        $(".color1").val(response.dataTag.name_color);
                        $(".color_tag1").val(response.dataTag.color_tag);

                        const auth_user = {{ Auth::user()->status }};
                        
                        if (auth_user == 1) {
                            const btn_delete = `<div class="flex flex-wrap justify-end space-x-2">
                                <button type="button" data-id_tag="${response.dataTag.id}"
                                    class="btn-sm bg-red-600 border-slate-200 hover:border-slate-300 text-white btn-delete">
                                    Delete
                                </button>
                            </div>`;
                            $('.btn-mo').html(btn_delete);
                        } else{ 
                            $('.btn-mo').empty();
                        }
                    }
                });
            });

            $('.btn-mo').on("click", ".btn-delete",  function () {
                const tagId = $(this).data("id_tag");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                            url: `/company/companycalendar/tagdelete/${tagId}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Calendar tag has been deleted.',
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