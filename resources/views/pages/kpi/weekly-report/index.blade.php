<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    BD - Weekly Report 🗄️
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

            @if (Auth::user()->role == '100' || Auth::user()->role == '200' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
                <div x-data="{ modalOpen: false }">
                    <button class="ml-10 btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0 mr-3" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>Create New Weekly Report</button>
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
                                    <div class="font-semibold text-slate-800">Create Weekly Report</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('weekly-report.create')}}" method="post" enctype="multipart/form-data">
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
                                            
                                            <label class="block text-sm font-medium mb-1" for="date">Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="date" name="date"
                                                class="date form-input w-full px-2 py-1" type="date"
                                                required value="{{date('Y-m-d')}}" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="notes">Notes<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="notes" name="notes"
                                                class="notes form-input w-full px-2 py-1" rows="3"
                                                required></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file1">Upload Attachment 1<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="file1" name="file1" type="file"
                                                class=" file1 form-input w-full px-2 py-1" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file2">Upload Attachment 2</label>
                                            <input id="file2" name="file2" type="file"
                                                class=" file2 form-input w-full px-2 py-1"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file3">Upload Attachment 3</label>
                                            <input id="file3" name="file3" type="file"
                                                class=" file3 form-input w-full px-2 py-1"/>
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
                </div>
            @endif
                
            </label>
        </div>
        
        @if (Auth::user()->role == '100' || Auth::user()->role == '201' || Auth::user()->role == '202' || Auth::user()->role == '203')
            <div class="table-responsive">
                <table id="weekly" class="table table-striped table-bordered text-xs" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Sales Representative</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">Attachment 1</th>
                            <th class="text-center">Attachment 2</th>
                            <th class="text-center">Attachment 3</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endif
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#weekly').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "searching": false,
                "order": [[ 1, "desc" ]],
                ajax: {
                    url: "{{ route('weekly-report.getdata') }}",
                    data:function(d){
                        d.year = $("#year").val()
                    }
                },
                columns: [
                    {
                        data: "add_by",
                        name: "add_by"
                    },
                    {
                        data: "date",
                        name: "date"
                    },
                    {
                        data: "notes",
                        name: "notes"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                    {
                        data: "action2",
                        name: "action2"
                    },
                    {
                        data: "action3",
                        name: "action3"
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
                    { className: 'text-center', targets: [1, 3, 4, 5, 6] },
                    { className: 'flex justify-center', targets: [7] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".year").on('change', function (e) {
                $('#weekly').DataTable().ajax.reload();
            })
            $('#weekly').on("click", ".btn-edit", function () {
                const id = $(this).data('id');
                const date = $(this).data('date');
                const notes = $(this).data('notes');
                const add_by = $(this).data('add_by');

                $.ajax({
                    type: "GET",
                    url: `/kpi/weekly-report/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/kpi/weekly-report/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
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
                                            
                                            <label class="block text-sm font-medium mb-1" for="date1">Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="date1" name="date1"
                                                class=" date1 form-input w-full px-2 py-1" type="date"
                                                required value="${date}" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="notes1">Notes<span
                                                    class="text-rose-500">*</span></label>
                                            <textarea id="notes1" name="notes1"
                                                class="notes1 form-input w-full px-2 py-1" rows="3"
                                                required>${notes}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file1_1">Upload Attachment 1<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="file1_1" name="file1_1" type="file"
                                                class="file1_1 form-input w-full px-2 py-1" required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file2_1">Upload Attachment 2</label>
                                            <input id="file2_1" name="file2_1" type="file"
                                                class="file2_1 form-input w-full px-2 py-1"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file3_1">Upload Attachment 3</label>
                                            <input id="file3_1" name="file3_1" type="file"
                                                class="file3_1 form-input w-full px-2 py-1"/>
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
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });
            $('#weekly').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete Weekly Report!",
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
                            url: `/kpi/weekly-report/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Report has been deleted.',
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