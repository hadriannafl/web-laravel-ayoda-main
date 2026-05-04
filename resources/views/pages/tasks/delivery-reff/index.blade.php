<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Sample Delivery Reff ✨
                        </h1>
            </div>
        </div>
        <div class="table-responsive">
            <table id="request" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Reff Number</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Sample Delivery Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#request').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "desc" ]],
                language: {
                    search: "Search Delivery Reff #:"
                },
                ajax: {
                    url: "{{ route('delivery-reff.getdata') }}",
                },
                columns: [
                    {
                        data: "sample_delivery_reff",
                        name: "sample_delivery_reff"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "sample_delivery_date",
                        name: "sample_delivery_date"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4] },
                ],  lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]
                
            }); 

        });
    </script>
    @endsection
</x-app-layout>
