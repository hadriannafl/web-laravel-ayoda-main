<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Asset Inventory Code - Edit 📓
                </h1>
            </div>
        </div>

        <!-- label -->
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-1 mr-3" for="category">Assets Department :</p>
                <select id="category" class="category flex flex-row mb-3 text-xs" style="width: 10rem" name="category">
                    <option value="" selected hidden>All</option>
                    @foreach ($dataCategory as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-1 mr-3 ml-5" for="sub_category">Assets Sub Department :</p>
                <select id="sub_category" class="sub_category flex flex-row mb-3 text-xs" style="width: 10rem" name="sub_category">
                    <option value="" selected hidden>All</option>
                    @foreach ($dataSubCategory as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="office-inventory" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Asset Code</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Sub Department</th>
                        <th class="text-center">Inventory Name</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Model #</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Part #</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            // $('#category').select2();
            // $('#sub_category').select2();
            $('#office-inventory').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search Inventory Name : "
                },
                ajax: {
                    url: "{{ route('office-inventory.getdata1') }}",
                    data:function(d){
                        d.category = $("#category").val()
                        d.sub_category = $("#sub_category").val()
                    }
                },
                columns: [
                    {
                        data: "idassets",
                        name: "idassets"
                    },
                    {
                        data: "category",
                        name: "category"
                    },
                    {
                        data: "sub_category",
                        name: "sub_category"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "brand",
                        name: "brand"
                    },
                    {
                        data: "type",
                        name: "type"
                    },
                    {
                        data: "model_number",
                        name: "model_number"
                    },
                    {
                        data: "color",
                        name: "color"
                    },
                    {
                        data: "unit",
                        name: "unit"
                    },
                    {
                        data: "sku",
                        name: "sku"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 7, 8] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $("#category").on('change', function (e) {
                $('#office-inventory').DataTable().ajax.reload();
            })

            $("#sub_category").on('change', function (e) {
                $('#office-inventory').DataTable().ajax.reload();
            })
        });
        document.getElementById('category').addEventListener('change', function () {
            var selectedDepartment = this.value;
            var subDepartmentSelect = document.getElementById('sub_category');

            // Mengaktifkan atau menonaktifkan form select Sub Department berdasarkan pilihan Department
            if (selectedDepartment !== '') {
                subDepartmentSelect.removeAttribute('disabled');
                // Menghapus opsi yang ada dalam select Sub Department
                while (subDepartmentSelect.options.length > 1) {
                    subDepartmentSelect.remove(1);
                }

                // Menambahkan opsi yang sesuai dengan Department yang dipilih
            @foreach ($dataSubCategory as $subcategory)
                var departmentName = "{{ $subcategory->p_id_dept }}";
                if (departmentName === selectedDepartment) {
                    var option = document.createElement('option');
                    var displayValue = "{{ $subcategory->id }}";
                    var displayName = "{{ $subcategory->name }}";
                    displayName = displayName.replace(/&amp;/g, '&'); // Mengganti &amp; kembali menjadi &
                    option.value = displayValue;
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