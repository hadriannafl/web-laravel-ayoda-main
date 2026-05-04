<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-2">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    e-Faktur 🧾
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5"></div>
            <p class="flex flex-row ml-1">Tax Uploaded</p>
            <div class="rounded-full md:break-after-column h-5 w-5 ml-5" style="background-color: grey"></div>
            <p class="flex flex-row ml-1">Tax Not Uploaded</p>
        </div>

        <label class="flex flex-row text-xs">
            <p class="flex flex-row text-slate-800 mb-3 mt-2 text-sm" for="year">Year :</p>
            <select id="year" class="year flex flex-row ml-3 mb-3 text-xs" name="year">
                <option value="">All</option>
                <option value="2022" {{ date('Y') == '2022' ? 'selected' : '' }}>2022</option>
                <option value="2023" {{ date('Y') == '2023' ? 'selected' : '' }}>2023</option>
                <option value="2024" {{ date('Y') == '2024' ? 'selected' : '' }}>2024</option>
                <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                <option value="2027" {{ date('Y') == '2027' ? 'selected' : '' }}>2027</option>
            </select>
        </label>

        <div class="table-responsive mt-3">
            <table id="tax" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Delivery Date</th>
                        <th class="text-center">Inv#</th>
                        <th class="text-center">Tracking Code</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Delivery By</th>
                        <th class="text-center">Last Updated</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#tax').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search Code:"
                },
                ajax: {
                    url: "{{ route('tax-getdata') }}",
                    data:function(d){
                     d.year = $("#year").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
                    },
                    {
                        data: "delivery_date",
                        name: "delivery_date"
                    },
                    {
                        data: "inv_number",
                        name: "inv_number"
                    },
                    {
                        data: "code",
                        name: "code"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "delivery_by",
                        name: "delivery_by"
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
                    { className: 'text-center', targets: [0, 1, 2, 3, 6 ] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
            });
            $(".year").on('change', function (e) {
                e.preventDefault();
                $('#tax').DataTable().ajax.reload();
            })
            $('#tax').on("click", ".btn-edit", function () {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const inv_number = $(this).data('inv_number');
                const delivery_date = $(this).data("delivery_date");
                const company = $(this).data("company");
                const invoice_orders = $(this).data("invoice_orders");

                $.ajax({
                    type: "GET",
                    url: `/efaktur/getdata/${code}`,
                    success: function (response) {
                        const csrf_token = $('meta[name="csrf-token"]').attr('content');

                        $(".modal-content").html(`
                            <form method="post" class="form_do_update" enctype="multipart/form-data" action="/efaktur/upload/${code}">
                                <input type="hidden" name="_token" value="${csrf_token}" />
                                <div class="px-5 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 mb-3"></div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="sales_id">Tracking Code<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="id_report" name="id_report" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${code}" readonly required/>
                                            <input id="id_report1" name="id_report1" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${id}" readonly required hidden/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="customer">Customer<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="customer" name="customer" class="form-input w-full px-2 py-1 read-only:bg-slate-200" type="text" value="${company}" readonly required/>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="date1">Delivery Date<span
                                                    class="text-rose-500">*</span></label>
                                            <input id="date1" name="date1"
                                                class=" date1 form-input w-full px-2 py-1" type="datetime-local"
                                                required value="${delivery_date}" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1" for="taxFile">Upload Tax File
                                               <span class="text-rose-500">*</span></label>
                                            <input id="taxFile" name="taxFile" type="file"
                                                class="taxFile form-input w-full px-2 py-1" accept="application/pdf" required/>
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
                                                class="btn-sm btn-update bg-indigo-500 hover:bg-indigo-600 text-white">Upload Tax</button>
                                        </div>
                                    </div>
                            </form>
                        `);
                    },
                });
            });
            $('#tax').on("click", ".btn-delete",  function () {
                const code = $(this).data('code');
                const tax_file = $(this).data("tax_file");
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
                            url: `/efaktur/delete/${code}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Tax file has been deleted.',
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