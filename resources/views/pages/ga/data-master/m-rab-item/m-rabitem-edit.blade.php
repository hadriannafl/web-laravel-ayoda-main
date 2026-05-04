<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master RAB Item - Edit 🗄️
                </h1>
            </div>
        </div>

        <!-- Table -->
        {{-- <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <div x-data="{ modalOpen: false }"> --}}
                    {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white text-xs mb-3" @click.prevent="modalOpen = true"
                        aria-controls="feedback-modal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>&nbsp; Create New RAB Item</button>
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
                                    <div class="font-semibold text-slate-800">Create New RAB Item</div>
                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route('master-rab.create')}}" method="post">
                                @csrf
                                <!-- Modal content -->
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="department">Department<span
                                                    class="text-rose-500">*</span></label>
                                            <select name="department" id="department" class="department form-input w-full px-2 py-1" required>
                                                <option value="" selected hidden>Select Department...</option>
                                                @foreach ($dataDepartment as $department)
                                                    <option value="{{$department->name}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="subDepartment">Sub Department<span
                                                    class="text-rose-500">*</span></label>
                                            <select id="subDepartment" name="subDepartment" type="text"
                                                    class="subDepartment form-input w-full px-2 py-1" required disabled>
                                                <option value="" selected hidden>Select Sub Department...</option>
                                                @foreach ($dataSubDepartment as $subdepartment)
                                                    @if ($subdepartment->p_id_dept === $department->id)
                                                        <option value="{{ $subdepartment->name }}">{{ $subdepartment->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="detail">Detail<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="detail" name="detail" type="text"
                                                class="detail form-input w-full px-2 py-1"
                                                required/>
                                        </div>
                                        <div> --}}
                                            {{-- <label class="block text-sm font-medium mb-1" for="unit">Unit<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="unit" name="unit" type="text"
                                                    class="unit form-input w-full px-2 py-1"
                                                    required/> --}}
                                            {{-- <select id="unit" name="unit" type="text" class="unit form-input w-full px-2 py-1" required>
                                                <option value="" hidden>Select Unit</option>
                                                <option value="Kg">Kg</option>
                                                <option value="Gr">Gr</option>
                                                <option value="Liter">Liter</option>
                                                <option value="Pcs">Pcs</option>
                                                <option value="Box">Box</option>
                                                <option value="Person">Person</option>
                                                <option value="Lump sum">Lump sum</option>
                                            </select> --}}
                                        {{-- </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="coa">Chart Of Account (COA)<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="coa" name="coa" class="coa form-input w-full px-2 py-1" required type="text"/> --}}
                                            {{-- <select id="coa" name="coa" class="coa form-input w-full px-2 py-1" required>
                                                <option value="" hidden selected>Select Coa</option>
                                                    @foreach ($dataCoa as $coa)
                                                        <option value="{{$coa->acc_code}}">{{$coa->acc_name}}</option>
                                                    @endforeach
                                            </select> --}}
                                        {{-- </div>
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
                    </div> --}}
                {{-- </div>     
            </label>
        </div> --}}
        <div class="table-responsive">
            <table id="master-rab" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Sub Department</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Chart Of Account (COA)</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#master-rab').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search RAB Item:"
                },
                ajax: {
                    url: "{{ route('master-rab.getdata') }}"
                },
                columns: [
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "department",
                        name: "department"
                    },
                    {
                        data: "sub_department",
                        name: "sub_department"
                    },
                    {
                        data: "detail",
                        name: "detail"
                    },
                    {
                        data: "coa",
                        name: "coa"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                    { className: 'flex justify-center', targets: [5] },
                ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });

            $('#master-rab').on("click", ".btn-modal", function () {
                const id = $(this).data('id');
                const department = $(this).data('department');
                const sub_department = $(this).data('sub_department');
                const coa = $(this).data('coa');
                const detail = $(this).data('detail');

                $.ajax({
                    type: "GET",
                    url: `/data-master/master-rab/getdata/${id}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/data-master/m-rab-item/update/${id}">
                                <input type="hidden" name="_token" value="${csrf_token}"/>
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="department1">Department<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="department1" name="department1" type="text"
                                                class="department1 form-input w-full px-2 py-1 bg-slate-100" value="${department}"
                                                required readonly/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="subDepartment1">Sub Department<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="subDepartment1" name="subDepartment1" type="text"
                                                class="subDepartment1 form-input w-full px-2 py-1 bg-slate-100" value="${sub_department}"
                                                required readonly/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="detail1">Detail<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="detail1" name="detail1" type="text"
                                                class="detail1 form-input w-full px-2 py-1" value="${detail}"
                                                required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="coa1">Chart Of Account (COA)<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="coa1" name="coa1" class="coa1 form-input w-full px-2 py-1" value="${coa}" required type="text"/>
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
                        // Gantikan opsi "Sub Department" dengan opsi yang sesuai dari $dataDepartmen
                        var subDepartmentSelect = $("#subDepartment1");
                        subDepartmentSelect.empty(); // Menghapus semua opsi sebelumnya

                        // Tambahkan opsi default
                        subDepartmentSelect.append(`<option value="${sub_department}" selected>${sub_department}</option>`);

                        // Tambahkan opsi berdasarkan nilai "department" dari variabel
                        @foreach ($dataDepartment as $dept)
                            if ("{{ $dept->name }}" === department) {
                                @foreach ($dataSubDepartment as $subdepartment)
                                    if ("{{ $subdepartment->p_id_dept }}" === "{{ $dept->id }}") {
                                        var option = $("<option></option>");
                                        var displayName = "{{ $subdepartment->name }}";
                                        displayName = displayName.replace(/&amp;/g, '&'); // Mengganti &amp; kembali menjadi &
                                        option.val(displayName);
                                        option.text(displayName);
                                        subDepartmentSelect.append(option);
                                    }
                                @endforeach
                            }
                        @endforeach
                    },
                });
            });

            $('#master-rab').on("click", ".btn-delete",  function () {
                const id = $(this).data("id");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to Delete RAB Item!",
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
                            url: `/data-master/m-rab-item/delete/${id}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'RAB Item has been Deleted.',
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
    <script>
        document.getElementById('department').addEventListener('change', function () {
            var selectedDepartment = this.value;
            var subDepartmentSelect = document.getElementById('subDepartment');

            // Mengaktifkan atau menonaktifkan form select Sub Department berdasarkan pilihan Department
            if (selectedDepartment !== '') {
                subDepartmentSelect.removeAttribute('disabled');
                // Menghapus opsi yang ada dalam select Sub Department
                while (subDepartmentSelect.options.length > 1) {
                    subDepartmentSelect.remove(1);
                }

                // Menambahkan opsi yang sesuai dengan Department yang dipilih
            @foreach ($dataSubDepartment as $subdepartment)
                var departmentName = "{{ $subdepartment->dept_name }}";
                if (departmentName === selectedDepartment) {
                    var option = document.createElement('option');
                    var displayName = "{{ $subdepartment->name }}";
                    displayName = displayName.replace(/&amp;/g, '&'); // Mengganti &amp; kembali menjadi &
                    option.value = displayName;
                    option.text = displayName;
                    subDepartmentSelect.appendChild(option);
                }
            @endforeach
            } else {
                // Menonaktifkan dan mengembalikan opsi yang asli jika Department tidak dipilih
                subDepartmentSelect.selectedIndex = 0;
                subDepartmentSelect.setAttribute('disabled', 'disabled');
            }
        });   
    </script>
    @endsection
</x-app-layout>