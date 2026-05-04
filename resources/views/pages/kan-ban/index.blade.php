<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">{{ Auth::user()->username }}'s Tasks ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add board button -->
                <div x-data="{ modalOpen: false }">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>Add Board</button>
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
                                    <div class="font-semibold text-slate-800">Add Board</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('kan-ban.createboard') }}" method="post">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="name">Board Name<span class="text-rose-500">*</span></label>
                                            <input id="board_name" name="board_name" class="board_name form-input w-full px-2 py-1" type="text" autofocus required/>
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

            </div>

        </div>

        <!-- Filters -->
            <div class="mb-4 border-b border-slate-200">
                <ul class="text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
                    <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="text-indigo-500 whitespace-nowrap" href="#0">View All</a>
                    </li>
                    @foreach ( $kanbanBoard as $board )    
                    <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="whitespace-nowrap" href="#0">{{ $board->BoardName }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-x-4 gap-y-8">

            <!-- Tasks cards -->
            <!-- Column 1 -->
                <div class="col-span-full sm:col-span-6 xl:col-span-3">
                    <!-- Column header -->
                    <header>
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="grow font-semibold text-slate-800 truncate">To Do’s 🖋️</h2>
                            <div x-data="{ modalOpen: false }">
                                <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2" @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
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
                                                <div class="font-semibold text-slate-800">Add To Do's</div>
                                                <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path
                                                            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <form action="{{ route('kan-ban.create') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <!-- Modal content -->
                                            <div class="px-5 py-4">
                                                <div class="text-sm">
                                                    <div class="font-medium text-slate-800 mb-3"></div>
                                                </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="name">To Do's Name<span
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
                                                        <label class="block text-sm font-medium mb-1" for="name">Kanban Board</label>
                                                        <select id="kanbanBoard" name="kanbanBoard" class=" color form-select">
                                                            <option selected disabled hidden>Select Here</option>
                                                            @foreach ($kanbanBoard as $board)
                                                                <option value="{{ $board->id }}">{{ $board->BoardName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="date">Kanban Date<span
                                                                class="text-rose-500">*</span></label>
                                                        <input id="date" name="date"
                                                            class=" date form-input w-full px-2 py-1" type="date"
                                                            required />
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="due">Kanban Due Date<span
                                                                class="text-rose-500">*</span></label>
                                                        <input id="due" name="due" class="form-input w-full px-2 py-1"
                                                            type="date" required />
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="feedback">Description</label>
                                                        <textarea id="desc" name="desc" class="form-textarea w-full px-2 py-1" rows="4"
                                                            required></textarea>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="feedback">Kanban List</label>
                                                            <div class="field_wrapper">
                                                                <div class="flex flex-row">
                                                                    <input id="list" name="list[]" class="form-input w-full px-2 py-1" type="text" required/>
                                                                    <a href="javascript:void(0);" type="button" class="add_button hover:text-indigo-600 ml-2 mt-2">
                                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                                                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="file">Upload Image</label>
                                                        <input name="photo" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                                                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="px-5 py-4 border-t border-slate-200">
                                                <div class="flex flex-wrap justify-end space-x-2">
                                                    <button type="button"
                                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                        @click="modalOpen = false">Cancel</button>
                                                    <button type="submit" id="create_kanban"
                                                        class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Create</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ( $dataKanban as $kanban )
                            @if ($kanban->status == 'todo')
                                    <!-- Cards -->
                                <div class="grid gap-2 mt-2 w-auto h-auto">

                                    <!-- Card 1 -->
                                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                                        <!-- Body -->
                                        <div class="mb-3">
                                            <!-- Title -->
                                            <h2 class="font-semibold text-slate-800 mb-1">{{$kanban->ToDo}}</h2>
                                            <!-- Content -->
                                            <div>
                                                <div class="text-sm">{{$kanban->ToDoDescription}}</div>
                                                <!-- List -->
                                                
                                                    <ul class="mt-3">
                                                        {{-- <li class="flex items-center border-t border-slate-200 py-2">
                                                            <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                            </svg>
                                                            <div class="text-sm text-slate-400 line-through">Implement new designs</div>
                                                        </li>     --}}
                                                        @foreach ($dataList as $list )
                                                            @if ($kanban->id == $list->kanban_id)
                                                                <li class="flex items-center border-t border-slate-200 py-2 ">
                                                                    <svg class="w-3 h-3 shrink-0 fill-current text-slate-400 mr-2" viewBox="0 0 12 12">
                                                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                    </svg>
                                                                    <div class="text-sm">{{$list->ToDoList}}</div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @if($kanban->ToDoPhoto_name != null)
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/kanbanImg/{{$kanban->ToDoPhoto_name}}" width="259" height="142" />
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Footer -->
                                        <div class="flex items-center justify-between">
                                            <!-- Left side -->
                                            <div class="flex shrink-0 -space-x-3 -ml-px">
                                                @if ($kanban->ToDoType == "group")
                                                <li class="flex items-start">
                                                    <div class="grow">
                                                        <div class="text-sm font-semibold text-slate-800 mb-1">{{$kanban->invitations}}</div>
                                                    </div>
                                                </li>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div></div>
                                            <!-- Right side -->
                                            <div class="flex items-center">
                                                <!-- Date -->
                                                <div class="flex items-center text-amber-500 ml-3">
                                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                        <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                                    </svg>
                                                    <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDate))}}</div>
                                                    <div class="text-sm text-amber-600 ml-1 mr-1">-</div>
                                                    <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDue))}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between kanban-detail">
                                            <div></div>
                                        @if (Auth::user()->id == $kanban->created_by)
                                            <div class="flex items-center">
                                                <form action="{{ route('kan-ban.progress', ['kanbanId' => $kanban->id]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white mt-2 ml-3">
                                                    <dir class="hidden">{{$kanban->id}}</dir> In Progress
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </header>
                </div>

                <!-- Column 2 -->
                <div class="col-span-full sm:col-span-6 xl:col-span-3">

                    <!-- Column header -->
                    <header>
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="grow font-semibold text-slate-800 truncate">In Progress ➡️</h2>
                        </div>

                        <!-- Cards -->
                            @foreach ( $dataKanban as $kanban )
                                @if ($kanban->status == 'progress')
                                        <!-- Cards -->
                                    <div class="grid gap-2 mt-3 w-auto h-auto">

                                        <!-- Card 2 -->
                                        <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                                            <!-- Body -->
                                            <div class="mb-3">
                                                <!-- Title -->
                                                <h2 class="font-semibold text-slate-800 mb-1">{{$kanban->ToDo}}</h2>
                                                <!-- Content -->
                                                <div>
                                                    <div class="text-sm">{{$kanban->ToDoDescription}}</div>
                                                    <!-- List -->
                                                    
                                                        <ul class="mt-3">
                                                            {{-- <li class="flex items-center border-t border-slate-200 py-2">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                </svg>
                                                                <div class="text-sm text-slate-400 line-through">Implement new designs</div>
                                                            </li>     --}}
                                                            @foreach ($dataList as $list )
                                                                @if ($kanban->id == $list->kanban_id)
                                                                    @if ($list->status == '0')                                                                        
                                                                    <li class="flex items-center border-t border-slate-200 py-2">
                                                                        <svg class="w-3 h-3 shrink-0 fill-current text-slate-400 mr-2" viewBox="0 0 12 12">
                                                                            <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                        </svg>
                                                                        <div class="text-sm">{{$list->ToDoList}}</div>
                                                                    </li>
                                                                    @elseif ($list->status == '1')
                                                                    <li class="flex items-center border-t border-slate-200 py-2">
                                                                        <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                            <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                        </svg>
                                                                        <div class="text-sm text-slate-400 line-through">{{$list->ToDoList}}</div>
                                                                    </li>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                         @if($kanban->ToDoPhoto_name != null)
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/kanbanImg/{{$kanban->ToDoPhoto_name}}" width="259" height="142" />
                                                @endif
                                                </div>
                                            </div>
                                            <!-- Footer -->
                                            <div class="flex items-center justify-between">
                                                <!-- Left side -->
                                                <div class="flex shrink-0 -space-x-3 -ml-px">
                                                    @if ($kanban->ToDoType == "group")
                                                    <li class="flex items-start">
                                                        <div class="grow">
                                                            <div class="text-sm font-semibold text-slate-800 mb-1">{{$kanban->invitations}}</div>
                                                        </div>
                                                    </li>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div></div>
                                                <!-- Right side -->
                                                <div class="flex items-center">
                                                    <!-- Date -->
                                                    <div class="flex items-center text-amber-500 ml-3">
                                                        <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                            <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                                        </svg>
                                                        <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDate))}}</div>
                                                        <div class="text-sm text-amber-600 ml-1 mr-1">-</div>
                                                        <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDue))}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between kanban-detail">
                                                <div></div>

                                                <div class="flex items-center btn-action">
                                                    @if (Auth::user()->id == $kanban->created_by)         
                                                            <button class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white mt-2 ml-3">
                                                            <div class="hidden">{{$kanban->id}}</div> Delete
                                                            </button>
                                                            <a href="{{route('kan-ban.getupdate', ['kanbanId' => $kanban->id])}}" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white mt-2 ml-3">
                                                            <div class="hidden">{{ $kanban->id }}</div>Update
                                                            </a>
                                                            <button class="btn btn-sm btn-finish text-sm bg-emerald-500 hover:bg-emerald-600 text-white mt-2 ml-3">
                                                                <div class="hidden">{{$kanban->id}}</div>Finish
                                                            </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                    </header>
                </div>

                <!-- Column 3 -->
                <div class="col-span-full sm:col-span-6 xl:col-span-3">

                    <!-- Column header -->
                    <header>
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="grow font-semibold text-slate-800 truncate">Completed 🏁</h2>
                        </div>

                        <!-- Cards -->
                        @foreach ( $dataKanban as $kanban )
                                @if ($kanban->status == 'complete')
                                        <!-- Cards -->
                                    <div class="grid gap-2 mt-3 w-auto h-auto">

                                        <!-- Card 2 -->
                                        <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                                            <!-- Body -->
                                            <div class="mb-3">
                                                <!-- Title -->
                                                <h2 class="font-semibold text-slate-800 mb-1">{{$kanban->ToDo}}</h2>
                                                <!-- Content -->
                                                <div>
                                                    <div class="text-sm">{{$kanban->ToDoDescription}}</div>
                                                    <!-- List -->
                                                    
                                                        <ul class="mt-3">
                                                            {{-- <li class="flex items-center border-t border-slate-200 py-2">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                </svg>
                                                                <div class="text-sm text-slate-400 line-through">Implement new designs</div>
                                                            </li>     --}}
                                                            @foreach ($dataList as $list )
                                                                @if ($kanban->id == $list->kanban_id)
                                                                    <li class="flex items-center border-t text-slate-400 line-through py-2">
                                                                        <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                            <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                                                        </svg>
                                                                        <div class="text-sm">{{$list->ToDoList}}</div>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                @if($kanban->ToDoPhoto_name != null)
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/kanbanImg/{{$kanban->ToDoPhoto_name}}" width="259" height="142" />
                                                @endif
                                                </div>
                                            </div>
                                            <!-- Footer -->
                                            <div class="flex items-center justify-between">
                                                <!-- Left side -->
                                                <div class="flex shrink-0 -space-x-3 -ml-px">
                                                    @if ($kanban->ToDoType == "group")
                                                    <li class="flex items-start">
                                                        <div class="grow">
                                                            <div class="text-sm font-semibold text-slate-800 mb-1">{{$kanban->invitations}}</div>
                                                        </div>
                                                    </li>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div></div>
                                                <!-- Right side -->
                                                <div class="flex items-center">
                                                    <!-- Date -->
                                                    <div class="flex items-center text-amber-500 ml-3">
                                                        <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                            <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                                        </svg>
                                                        <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDate))}}</div>
                                                        <div class="text-sm text-amber-600 ml-1 mr-1">-</div>
                                                        <div class="text-sm text-amber-600">{{date('M d', strtotime($kanban->ToDoDue))}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between kanban-detail">
                                                <div></div>

                                                <div class="flex items-center btn-actions">
                                                    <button class="btn btn-sm btn-undo text-sm bg-indigo-500 hover:bg-indigo-600 text-white mt-2 ml-3">
                                                      <div class="hidden">{{$kanban->id}}</div>  Undo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                    </header>
                </div>

                <!-- Column 4 -->
                <div class="col-span-full sm:col-span-6 xl:col-span-3">

                    <!-- Column header -->
                    <header>
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="grow font-semibold text-slate-800 truncate">Notes 📒</h2>
                            <div x-data="{ modalOpen: false }">
                                <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2" @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
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
                                                <div class="font-semibold text-slate-800">Add Notes</div>
                                                <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path
                                                            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <form action="{{ route('kan-ban.notes') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <!-- Modal content -->
                                            <div class="px-5 py-4">
                                                <div class="text-sm">
                                                    <div class="font-medium text-slate-800 mb-3"></div>
                                                </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="noted">Notes Title<span
                                                                class="text-rose-500">*</span></label>
                                                        <input id="noted" name="noted" class="form-input w-full px-2 py-1" type="text" required />
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="notes">Notes</label>
                                                        <textarea id="note" name="note" class="form-textarea w-full px-2 py-1" rows="4"
                                                            required></textarea>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1" for="file">Upload Image</label>
                                                        <input name="photo_note" class="form-input w-full px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                                                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
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
                        </div>
                        @foreach ($dataNote as $note )
                            @if ($note->status == 'note') 
                                    <!-- Cards -->
                                <div class="grid gap-2 mt-3 w-auto h-auto">

                                    <!-- Card 2 -->
                                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                                        <!-- Body -->
                                        <div class="mb-3">
                                            <!-- Title -->
                                            <h2 class="font-semibold text-slate-800 mb-1">{{$note->name}}</h2>
                                            <!-- Content -->
                                            <div>
                                                <div class="text-sm">{{$note->notes}}</div>
                                                <!-- List -->
                                                @if($note->image_name != null)
                                                <img class="w-full mt-3" src="http://ayoda.integrated-os.cloud/kanbanNoteImg/{{$note->image_name}}" width="259" height="142"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between kanban-detail">
                                            <div></div>

                                            <div class="flex items-center btn-note">
                                                <button class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white mt-2 ml-3">
                                                <div class="hidden">{{$note->id}}</div>  Delete
                                                </button>
                                                <a href="{{route('note.getUpdate', ['noteId' => $note->id])}}" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white mt-2 ml-3">
                                                    <div class="hidden">{{ $note->id }}</div>Update
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </header>
                </div>



        </div>
</div>


        </div>

    </div>
    @section('js-page')
    <script>
        $(document).ready(function () {

            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="flex flex-row"><input id="list" name="list[]" class="form-input w-full px-2 py-1 mt-1" type="text" autofocus/><a href="javascript:void(0);" type="button" class="remove_button hover:text-indigo-600 ml-2 mt-2"> <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16"><path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/></svg></a></div>'; //New input field html 
            var x = 1; //Initial field counter is 1

                    //Once add button is clicked
                $(addButton).click(function(){
                    //Check maximum number of input fields
                    if(x < maxField){ 
                        x++; //Increment field counter
                        $(wrapper).append(fieldHTML); //Add field html
                    }
                });
                
                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button', function(e){
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });
            
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

            $('.btn-action').on("click", ".btn-delete",  function () {
                const kanbanId = $(this).children().html();
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to delete this progress!",
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
                            type: "POST",
                            url: `/kan-ban/kanbandelete/${kanbanId}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Kanban has been deleted.',
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

            $('.btn-action').on("click", ".btn-finish",  function () {
                const kanbanId = $(this).children().html();
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure to finish this kanban?',
                    text: "Make sure you already complete the list!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Finish it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/kan-ban/kanbanfinish/${kanbanId}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Kanban Successfully Complete",
                                        icon: 'success'
                                })
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

            $('.btn-actions').on("click", ".btn-undo",  function () {
                const kanbanId = $(this).children().html();
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure to undo this kanban?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, undo this kanban!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: `/kan-ban/kanbanundo/${kanbanId}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Kanban Successfully Undo",
                                        icon: 'success'
                                })
                                    window.location.reload(false);
                                }
                            },
                            error: function (data) {
                                console.info("error: ", data)
                            }
                        })

                    }
                })
            });

            $('.btn-note').on("click", ".btn-delete",  function () {
                const noteId = $(this).children().html();
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to delete note!",
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
                            type: "POST",
                            url: `/kan-ban/deletenotes/${noteId}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Notes has been deleted.',
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
            $('#date').on('change', function () {
                const sdate = $(this).val();
                const edate = document.getElementById('due').value;
                
                // alert(edate);

                if (edate < sdate && edate != '') {
                    alert('End date cannot be before start date!');
                    document.getElementById('create_kanban').disabled = true;
                } else {
                    document.getElementById('create_kanban').disabled = false;
                }
            });
        
            $('#due').on('change', function () {
                const edate = $(this).val();
                const sdate = document.getElementById('date').value;
                    
                if (edate < sdate && sdate != '') {
                    alert('End date cannot be before Start date!');
                    document.getElementById('create_kanban').disabled = true;
                } else {
                    document.getElementById('create_kanban').disabled = false;
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
