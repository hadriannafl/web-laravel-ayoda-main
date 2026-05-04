<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Purchase KPI 💳
                </h1>
            </div>
        </div>

        <form class="flex items-center mb-3" id="form-filter">
            <label class="block text-sm font-medium text-lg mb-1" for="form-search">Year :</label>
            <div class="relative ml-2 w-3/4 md:w-1/4">
                <input id="form-search" class="form-input w-full pl-9" type="number" placeholder="{{date('Y')}}" min="1999"
                    max="2050" autocomplete="off">
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z">
                        </path>
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z">
                        </path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table id="purchase-kpi" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Purchase KPI #</th>
                        <th class="text-center">purchase KPI Name</th>
                        <th class="text-center">Supplier Name</th>
                        <th class="text-center">Total Purchase</th>
                        <th class="text-center">Total Products</th>
                        <th class="text-center">Total Quantity Products</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#purchase-kpi').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 7, "desc" ]],
                language: {
                    search: "Search Purchase KPI # : "
                },
                ajax: {
                    url: "{{ route('purchase-kpi.getdata') }}",
                    data: function (d) {
                        d.year = $("#form-search").val()
                    }
                },
                columns: [
                    {
                        data: "periode",
                        name: "periode"
                    },
                    {
                        data: "id_kpi",
                        name: "id_kpi"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "supplier_name",
                        name: "supplier_name"
                    },
                    {
                        data: "purchase_total",
                        name: "purchase_total"
                    },
                    {
                        data: "product_total",
                        name: "product_total"
                    },
                    {
                        data: "product_qty_total",
                        name: "product_qty_total"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1] },
                    { className: 'text-right', targets: [4, 5, 6] },
                    { className: 'flex justify-center', targets: [7] },
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $("#form-filter").submit(function (e) {
                e.preventDefault();
                $('#purchase-kpi').DataTable().ajax.reload();
            });

            $('#purchase-kpi').on("click", ".btn-modal", function () {
                const idKpi = $(this).data('idkpi');
                const periode = $(this).data("periode");
                const idsupplier = $(this).data("idsupplier");
                const supplier = $(this).data("supplier");
                const currency = $(this).data("currency");
                const purchase = $(this).data("purchase");
                const product = $(this).data("product");
                const qty = $(this).data("qty");
                const name = $(this).data("name");

                $.ajax({
                    type: "GET",
                    url: `/purchasing/purchase-kpi/getdetail/${idKpi}`,
                    success: function (response) {
                        $(".modal-content").html(`
                        <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="id">Purchase KPI #</label>
                                        <input id="id" class="id form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${idKpi}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="name">Purchase KPI Name</label>
                                        <input id="name" class="name form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${name}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="supplier">Supplier Name</label>
                                        <input id="supplier" class="supplier form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${supplier}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="purchaseTotal">Total Purchase</label>
                                        <input id="purchaseTotal" class="purchaseTotal form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${currency} ${divider(purchase)}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="totalProducts">Total Products</label>
                                        <input id="totalProducts" class="totalProducts form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${divider(product)}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="totalQty">Total Quantity Products</label>
                                        <input id="totalQty" class="totalQty form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${divider(qty)}" disabled
                                            readonly />
                                    </div>
                                </div>
                                    <table class="table table-striped table-bordered mt-1 mb-2 tableProductAddBody" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Product Code</th>
                                                <th class="text-sm text-center">Product Name</th>
                                                <th class="text-sm text-center">Product Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                            </div>
                        `); 
                        let tableRow = '';
                            for (const value of response) {
                                tableRow += `<tr>
                                                <td class="text-center">${value.code}</td>
                                                <td>${value.name}</td>
                                                <td class="text-center">${value.qty}</td>
                                            </tr>`;
                            }
                        $(".tableProductAddBody").find('tbody').append(tableRow);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>