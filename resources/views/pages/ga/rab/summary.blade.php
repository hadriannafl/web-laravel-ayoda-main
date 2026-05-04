<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    RAB Summary 💳
                </h1>
            </div>
        </div>

        <div class="flex flex-row mb-3">
            <div class="rounded-full bg-yellow-200 columns-1 h-5 w-5"></div>
            <p class="flex flex-row ml-1">Site Approved/HQ 1 Approved</p>
            <div class="rounded-full bg-sky-500 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Printed</p>
            <div class="rounded-full bg-green-700 columns-1 h-5 w-5 ml-5"></div>
            <p class="flex flex-row ml-1">Enforced</p>
        </div>

          <!-- label -->
          <div class="flex flex-row text-xs mb-3">
              <form class="items-center mb-3" action="{{route('rab-summary.post')}}" method="POST" id="get_summary">
                @csrf
                    <label class="flex flex-row text-xs">
                    <p class="flex flex-row text-sm text-slate-800 mb-3 mt-2" for="from">Periode (From):</p>
                    <input id="min" name="from" class="text-sm flex flex-row ml-3 mb-3" type="month" required/>
                    <p class="flex flex-row text-sm text-slate-800 mb-3 ml-5 mt-2" for="to">Periode (To):</p>
                    <input id="max" name="to" class="text-sm flex flex-row ml-3 mb-3" type="month" required/>
                    @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                        <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="company">Company :</p>
                        <select id="company" class="company flex flex-row mb-3 text-xs" style="width: 10rem" name="company" required>
                            <option value="" hidden selected>Select Company</option>
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
                        <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3 ml-5" for="department">Department :</p>
                        <select id="department" class="department flex flex-row mb-3 text-xs" style="width: 10rem" name="department">
                            <option value="" selected>All</option>
                            @foreach ($department as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <button id="btn-search" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-5 mb-3" type="button">
                            <span class="xs:block">Search</span>
                        </button>
                        <button id="print_summary" type="submit" aria-label="Search" class="btn text-white ml-5 mb-3" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;" hidden>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg><span class="xs:block ml-1">Print Summary</span>
                        </button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="summary" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Period</th>
                        <th class="text-center">RAB #</th>
                        <th class="text-center">RAB Type</th>
                        <th class="text-center">RAB Title</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Grand Total</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
            </table>
        </div>

    @section('js-page')
    <script>
         $(document).ready(function () {
            $('#summary').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 1, "desc" ]],
                language: {
                    search: "Search: "
                },
                ajax: {
                    url: "{{ route('rab-summary.getdata') }}",
                    data:function(d){
                        d.status = $("#status").val()
                        d.company = $("#company").val()
                        d.department = $("#department").val()
                    }
                },
                columns: [
                    {
                        data: "label",
                        name: "label"
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
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1] },
                    { className: 'text-right', targets: [6] }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });
            $("#btn-search").on("click", function () {
                var minDate = $('#min').val();
                var maxDate = $('#max').val();
                var company = $('#company').val();
                var department = $('#department').val();

                var table = $('#summary').DataTable();
                table.ajax.url('/ga/rab/summarygetdata?search=1&from=' + minDate + '&to=' + maxDate + '&company=' + company + '&department=' + department).load();
                $('#print_summary').attr('hidden', false);
            });
        });
    $('#get_summary').submit(function (e, params) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(formData, $(this).attr('action'));
            $.ajax({
                url      : $(this).attr('action'),
                type     : 'POST',
                dataType : 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                    success: function(_response){
                        if(_response.st == '1'){
                            var from = _response.from;
                            var to = _response.to;
                            var company = _response.company;
                            var department = _response.department;
                            if (department == null) {
                                var urlRedirect = '/ga/rab/summaryprint/'+ from + '/' + to + '/' + company;                                
                            } else {
                                var urlRedirect = '/ga/rab/summaryprint/'+ from + '/' + to + '/' + company + '/' + department;  
                            }

                            window.open(urlRedirect, '_blank');

                        } else if(_response.st == '0'){
                            alert('Terjadi kesalahan');
                        }
                    },
                    error: function(){
                        alert('Terjadi kesalahan');
                    }
                });
            })
    </script>
    @endsection
</x-app-layout>