<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    RAB LPJ List 💳
                </h1>
            </div>
        </div>

        <!-- label -->
        <div class="flex flex-row text-xs">
            <label class="flex flex-row text-xs">
                <a href="{{ route('rabLpjCreate.form') }}" class="btn bg-purple-500 hover:bg-purple-600 text-white text-xs mb-3">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>&nbsp; New RAB LPJ</a> 
            </label>
        </div>

        <!-- label -->
        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-sm text-slate-800 mb-3 mt-2" for="from">Periode (From):</p>
                <input id="min" name="from" class="text-sm flex flex-row ml-3 mb-3" type="month"/>
                <p class="flex flex-row text-sm text-slate-800 mb-3 ml-5 mt-2" for="to">Periode (To):</p>
                <input id="max" name="to" class="text-sm flex flex-row ml-3 mb-3" type="month"/>            
                @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company">
                        <option value="" selected>All</option>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @else
                    <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" hidden>
                        @foreach ($dataChildCompany as $company)
                            <option value="{{ $company->id_company }}" {{ Auth::user()->company_id == $company->id_company ? ' selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                        <option value="" selected>All</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @else
                    <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department" hidden>Department :</p>
                    <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department" hidden>
                        <option value="" selected>All</option>
                    </select>
                    @endif
                    <button id="btn-search" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-5 mb-3" type="button">
                        <span class="xs:block">Search</span>
                    </button>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="approval" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Form Date</th>
                        <th class="text-center">Period</th>
                        <th class="text-center">RAB #</th>
                        <th class="text-center">RAB Type</th>
                        <th class="text-center">RAB Title</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Grand Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    @section('js-page')
    <script>
        // Get today's date
        const today = new Date();

        // Function to get the last day of the month
        function getLastDayOfMonth(year, month) {
            return new Date(year, month + 1, 0).getDate();
        }

        // Function to format date to YYYY-MM
        function formatMonth(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            return `${year}-${month}`;
        }

        // Calculate date 3 months ago
        const minDate = new Date(today);
        minDate.setMonth(minDate.getMonth() - 3);

        // Calculate date of the last day of this month
        const maxDate = new Date(today);
        maxDate.setDate(getLastDayOfMonth(maxDate.getFullYear(), maxDate.getMonth()));

        // Set the initial values for the input fields
        document.getElementById('min').value = formatMonth(minDate);
        document.getElementById('max').value = formatMonth(maxDate);

        const btnSearch = document.getElementById('btn-search');

        // Function to validate dates and toggle button state
        function validateDates() {
            const minInputDate = new Date(document.getElementById('min').value);
            const maxInputDate = new Date(document.getElementById('max').value);
            const newMaxAllowedDate = new Date(minInputDate);
            newMaxAllowedDate.setMonth(newMaxAllowedDate.getMonth() + 3);
            newMaxAllowedDate.setDate(getLastDayOfMonth(newMaxAllowedDate.getFullYear(), newMaxAllowedDate.getMonth()));

            if (maxInputDate > newMaxAllowedDate || minInputDate > maxInputDate) {
                alert(`The "TO" date must be within 3 months of the "FROM" date, and cannot be earlier than the "FROM" date.`);
                btnSearch.disabled = true;
            } else {
                btnSearch.disabled = false;
            }
        }

        // Add event listeners to the input fields
        document.getElementById('min').addEventListener('change', function () {
            validateDates();
        });

        document.getElementById('max').addEventListener('change', function () {
            validateDates();
        });

        // Initial validation
        validateDates();
         $(document).ready(function () {
            $('#approval').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search RAB # : "
                },
                ajax: {
                    url: "{{ route('rabLpjList.getData') }}",
                    data:function(d){
                        d.company = $("#company").val()
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "form_date",
                        name: "form_date"
                    },
                    {
                        data: "date_rab",
                        name: "date_rab"
                    },
                    {
                        data: "id_rab",
                        name: "id_rab"
                    },
                    {
                        data: "rab_type",
                        name: "rab_type"
                    },
                    {
                        data: "name_rab",
                        name: "name_rab"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "deptName",
                        name: "deptName"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "approvalstat",
                        name: "approvalstat"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 9, 10] },
                    { className: 'text-right', targets: [] }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            // $("#btn-search").on("click", function () {
            //     var minDate = $('#min').val();
            //     var maxDate = $('#max').val();
            //     var company = $('#company').val();
            //     var department = $('#department').val();
            //     var status = $('#status').val();

            //     var table = $('#approval').DataTable();
            //     table.ajax.url('/ga/rab-approval/list/getdata?search=1&from=' + minDate + '&to=' + maxDate + '&company=' + company + '&department=' + department + '&status=' + status).load();
            // });
            // $('#approval').on("click", ".btn-cancel",  function () {
            //     const id = $(this).data("id");
            //     $("input[name!='_token']").val("");
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "Want to Cancel RAB Request!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, Cancel Request!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 headers: {
            //                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 type: "POST",
            //                 url: `/ga/rab-approval/cancel/${id}`,
            //                 success: function (response) {
            //                     console.info("response: ", response)
            //                     const { status, message } = response;
            //                     if (status == 1) {
            //                         Swal.fire({
            //                             icon : 'success',
            //                             title: 'Success!',
            //                             text: `RAB Request has been Canceled.`,
            //                             confirmButtonColor: '#3085d6',
            //                             confirmButtonText: 'OK'
            //                         });
            //                         window.location.reload(true);
            //                     }else if (status == 2) {
            //                         Swal.fire({
            //                             icon : 'error',
            //                             title: 'Cannot cancel Cost Center!',
            //                             text: `there are Active PV.`,
            //                             confirmButtonColor: '#3085d6',
            //                             confirmButtonText: 'OK'
            //                         });
            //                     }
            //                 },
            //                 error: function (data) {
            //                     console.info("error: ", data)
            //                 }
            //             })

            //         }
            //     })
            // });
        });
    </script>
    @endsection
</x-app-layout>