<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Asset Inventory Code 📓
                </h1>
            </div>
        </div>

        <!-- label -->
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-1 mr-3" for="category">Assets Department :</p>
                <select id="category" class="category flex flex-row mb-3 text-xs" style="width: 10rem" name="category">
                    <option value="" selected>All</option>
                    @foreach ($dataCategory as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-1 mr-3 ml-5" for="sub_category">Assets Sub Department :</p>
                <select id="sub_category" class="sub_category flex flex-row mb-3 text-xs" style="width: 10rem" name="sub_category">
                    <option value="" selected>All</option>
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
                    url: "{{ route('office-inventory.getdata') }}",
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

            $('#office-inventory').on("click", ".btn-modal", function () {
                const idassets = $(this).data('idassets');
                const sku = $(this).data('sku');
                const model = $(this).data('model');
                const vendor = $(this).data('vendor');
                const name = $(this).data('name');
                const brand = $(this).data('brand');
                const type = $(this).data('type');
                const color = $(this).data('color');
                const coa = $(this).data('coa');

                $.ajax({
                    type: "GET",
                    url: `/ga/office-inventory/getdata/${idassets}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="type_update" enctype="multipart/form-data" action="/ga/office-inventory/upload/${idassets}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="inventoryCode">Inventory Asset Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="inventoryCode" name="inventoryCode" type="text" value = "${idassets}"
                                                class="inventoryCode form-input w-full px-2 py-1 read-only:bg-slate-200" readonly/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="sku">Part # / SKU<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="sku" name="sku" type="text" value = "${sku}"
                                                class="sku form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="model">Model Number<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="model" name="model" type="text" value = "${model}"
                                                class="model form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="vendor">Vendor Preference<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="vendor" name="vendor" type="text" value = "${vendor}"
                                                class="vendor form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="inventoryName">Inventory Name<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="inventoryName" name="inventoryName" type="text" value = "${name}"
                                                class="inventoryName form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="brand">Brand<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="brand" name="brand" type="text" value = "${brand}"
                                                class="brand form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="type">Type<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="type" name="type" type="text" value = "${type}"
                                                class="type form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="color">Color<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="color" name="color" type="text" value = "${color}"
                                                class="color form-input w-full px-2 py-1 read-only:bg-slate-200"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="file">Upload Asset PDF<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="file" name="file" type="file" accept="application/pdf"
                                                class="file form-input w-full px-2 py-1"/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="image">Upload Asset Image<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="image" name="image" type="file" accept="image/jpeg"
                                                class="image form-input w-full px-2 py-1" onchange="loadFileMultiple(event, 'output1')"/>
                                        </div>
                                        <img id="output1" style="max-width: 300px; max-height: 150px"/>
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
        // // Use Select2 for the #category and #sub_category elements
        // $('#category').select2();
        // $('#sub_category').select2();
    </script>
    @endsection
</x-app-layout>