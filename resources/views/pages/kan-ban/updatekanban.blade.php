<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Progress Detail 📝</h1>
        </div>
        <form action="{{ route('kan-ban.update', ['kanbanId' => $kanbanData->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-5 py-4">
                <div class="space-y-3">
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="name">Kanban Name :</label>
                        <input id="name" name="name" class=" name form-input w-full md:w-3/4 px-2 py-1"
                            value="{{$kanbanData->ToDo}}"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Type : </label>
                        <input id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$kanbanData->ToDoType}}" readonly disabled />
                    </div>
                    @if ($kanbanData->ToDoType == "group")
                        <div class="flex justify-between flex-col md:flex-row">
                            <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Invite List: </label>
                            <input id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{$kanbanData->invitations}}" readonly disabled />
                        </div>
                    @endif
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="board">Kanban Board : </label>
                        <select id="board" name="board" class="board form-input w-full md:w-3/4 px-2 py-1" type="text">
                            <option name="" id="">Select Here</option>
                            @foreach ($kanbanBoard as $board )
                            <option value="{{$board->id}}" {{ $kanbanData->KanBanBoard_ID == $board->id ? ' selected' : '' }}>{{$board->BoardName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Kanban Date : </label>
                        <input id="date" name="date" class="date w-full md:w-3/4 px-2 py-1" type="date"
                            value="{{$kanbanData->ToDoDate}}" />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="due">Kanban Due Date : </label>
                        <input id="due" name="due" class="due w-full md:w-3/4 px-2 py-1" type="date"
                            value="{{$kanbanData->ToDoDue}}" />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Description : </label>
                        <textarea id="desc" name="desc" class="desc form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" rows="3"
                            value="{{$kanbanData->ToDoDescription}}" readonly/>{{$kanbanData->ToDoDescription}}</textarea>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="file">Upload Image :
                        </label>
                        <input name="photo" class="photo form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpeg" onchange="loadFileMultiple(event, 'output1')"/>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row ml-72 mt-3">
                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
                    </div>  
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for=""></label>
                        <input id="company" name="file"
                            class="file form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200 mb-3" type="text"
                            readonly disabled value="{{ $kanbanData->ToDoPhoto_name}}" />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="desc">Kanban List : </label>
                    </div>
                        @foreach ($dataList as $list )
                            @if ($kanbanData->id == $list->kanban_id)
                                @if ($list->status == '0')    
                                        <li class="flex items-center border-t border-slate-200 py-2">
                                            <svg class="w-3 h-3 shrink-0 fill-current text-slate-400 mr-2" viewBox="0 0 12 12">
                                            <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                            </svg>
                                            <div class="text-sm" name="list">{{$list->ToDoList}}</div>
                                            <input type="text" name="id[]" value="{{$list->id}}" hidden/>
                                            <input type="checkbox" id="check" name="check[{{$list->id}}]" value="1" class="form-input ml-2"/>
                                        </li>
                                    @elseif ($list->status == '1')
                                        <li class="flex items-center border-t border-slate-200 py-2">
                                            <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                            </svg>
                                            <div class="text-sm text-slate-400 line-through">{{$list->ToDoList}}</div>
                                            <input type="checkbox" id="uncheck" name="uncheck[{{$list->id}}]" value="0" class="form-input ml-2" selected="selected"/>
                                        </li>
                                @endif
                            @endif
                        @endforeach
            </div>
            <!-- Modal footer -->
            <div class="px-5 py-4 border-t border-slate-200">
            @if ($kanbanData->created_by == Auth::user()->id)                                                                            
            <div class="flex flex-wrap justify-end space-x-2">
                <button class="btn-sm text- bg-indigo-500 hover:bg-indigo-600 text-white" type="submit" id="update_kanban">Update</button>
            </div>
            @endif
            </div>
                </div>
            </div>
        </form>
    </div>

    @section('js-page')
    <script>
         $('#date').on('change', function () {
                const sdate = $(this).val();
                const edate = document.getElementById('due').value;
                
                // alert(edate);

                if (edate < sdate && edate != '') {
                    alert('End date cannot be before start date!');
                    document.getElementById('update_kanban').disabled = true;
                } else {
                    document.getElementById('update_kanban').disabled = false;
                }
            });
        
            $('#due').on('change', function () {
                const edate = $(this).val();
                const sdate = document.getElementById('date').value;
                    
                if (edate < sdate && sdate != '') {
                    alert('End date cannot be before Start date!');
                    document.getElementById('update_kanban').disabled = true;
                } else {
                    document.getElementById('update_kanban').disabled = false;
                }
            });
    </script>
    @endsection
</x-app-layout>