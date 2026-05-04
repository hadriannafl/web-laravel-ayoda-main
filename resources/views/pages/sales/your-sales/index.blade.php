<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Your Sales 📈
                </h1>
            </div>
        </div>

        <!-- Table -->
        <form class="flex items-center mb-3" id="form-filter">
            <label class="block text-sm font-medium text-lg mb-1" for="form-search">Year :</label>
            <div class="relative ml-2 w-3/4 md:w-1/4">
                <input id="form-search" class="form-input w-full pl-9" type="number" placeholder="YYYY" min="1999"
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
        <!-- Graphic Section -->
        <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-sm rounded-sm border border-slate-200 mb-5">
            <div id="your-sales-chart-legend" class="px-5 py-3">
                <ul class="flex flex-wrap"></ul>
            </div>
            <div class="grow">
                <canvas id="your-sales-chart" width="595" height="248"></canvas>
            </div>
        </div>
        <div class="table-responsive">
            <table id="yoursales" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-sm text-center">Year</th>
                        <th class="text-sm text-center">Month</th>
                        <th class="text-sm text-center">Nett Sales Total</th>
                        <th class="text-sm text-center">Invoice Count</th>
                        <th class="text-sm text-center">Customer</th>
                        <th class="text-sm text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#yoursales').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                bFilter: false,
                lengthChange: false,
                paging: false,
                sort: false,
                ajax: {
                    url: "{{ route('yoursales.getdata') }}",
                    data: function (d) {
                        d.year = $("#form-search").val()
                    }
                },
                columns: [
                    {
                        data: "year",
                        name: "year"
                    },
                    {
                        data: "month",
                        name: "month"
                    },
                    {
                        data: "net_sales_total",
                        name: "net_sales_total"
                    },
                    {
                        data: "invoice_count",
                        name: "invoice_count"
                    },
                    {
                        data: "customer_count",
                        name: "customer_count"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4, 5] },
                    { className: 'text-right', targets: [2] },
                ],
                lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $("#form-filter").submit(function (e) {
                e.preventDefault();
                $('#yoursales').DataTable().ajax.reload();
            });

            $('#yoursales').on("click", ".btn-modal", function () {
                const year = $(this).data("year");
                const monthNumber = $(this).data("month-number");
                const month = $(this).data("month");
                const netSalestotal = $(this).data("net-total");
                const customerCount = $(this).data("customer-count");
                const invoiceCount = $(this).data("invoice-count");

                $.ajax({
                    type: "GET",
                    url: `/sales/your-sales/getdetail/${year}/${monthNumber}`,
                    success: function (response) {
                        $(".modal-content").html(`
                            <div class="px-5">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 mb-3"></div>
                                </div>
                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="name">Year</label>
                                        <input id="year" class="form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${year}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1"
                                            for="name">Month</label>
                                        <input id="month" class="form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${month}" disabled readonly/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="name">Nett Sales
                                            Total</label>
                                        <input id="netSalestotal" class="form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${netSalestotal}" disabled
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="name">Invoice
                                            Count</label>
                                        <input id="invoiceCount" class="form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${invoiceCount}" disabled readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="name">Customer
                                            Count</label>
                                        <input id="customerCount" class="form-input w-full px-2 py-1 bg-slate-100"
                                            type="text" value="${customerCount}" disabled readonly />
                                    </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-striped table-bordered detail-your-sales"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-sm text-center">Invoice Date</th>
                                                <th class="text-sm text-center">Invoice Number</th>
                                                <th class="text-sm text-center">Customer Name</th>
                                                <th class="text-sm text-center">Salesman</th>
                                                <th class="text-sm text-center">Invoice Total</th>
                                                <th class="text-sm text-center">Return Sales Flag</th>
                                                <th class="text-sm text-center">View Invoice PDF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `);

                        let tableRow = '';
                        for (const value of response) {
                            tableRow += `<tr>
                                            <td class="text-center">${formatDate(value.delivery_date )}</td>
                                            <td class="text-center">${value.inv_number}</td>
                                            <td class="text-left">${value.name}</td>
                                            <td class="text-left">${value.salesname == null ? "" : value.salesname}</td>
                                            <th class="text-right font-medium">${value.dpp == null ? "" : formatCurrency(value.dpp)}</th>
                                            <th></th>
                                            <td>
                                                <a href="/sales/sales-invoice/file/${value.id}" target="_blank" class="btn btn-xs bg-indigo-500 hover:bg-indigo-600 text-white">
                                                    View</a>
                                            </td>
                                        </tr>`;
                        }

                        $(".detail-your-sales").find('tbody').append(tableRow);
                    },
                });
            });
        });
    </script>
    @endsection
</x-app-layout>