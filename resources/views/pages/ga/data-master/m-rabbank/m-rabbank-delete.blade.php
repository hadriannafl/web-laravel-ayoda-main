<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Master RAB Beneficiary Bank 🗄️
                </h1>
            </div>
        </div>

        <div class="flex flex-row text-xs mb-3">
            <label class="flex flex-row text-xs">
        @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2 mr-3" for="company">Company :</p>
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
            </label>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="cidsBank" class="table table-striped table-bordered text-xs" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Company</th>
                        <th class="text-center">Beneficiary Bank</th>
                        <th class="text-center">Beneficiary Account</th>
                        <th class="text-center">Beneficiary Account Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @section('js-page')
    <script>
        $(document).ready(function () {
            $('#cidsBank').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                "order": [[ 0, "asc" ]],
                language: {
                    search: "Search:"
                },
                ajax: {
                    url: "{{ route('rabbank.getdata') }}",
                    data:function(d){
                        d.company = $("#company").val()
                    }
                },
                columns: [
                    {
                        data: "companyName",
                        name: "companyName"
                    },
                    {
                        data: "beneficiary_bank",
                        name: "beneficiary_bank"
                    },
                    {
                        data: "beneficiary_acc",
                        name: "beneficiary_acc"
                    },
                    {
                        data: "beneficiary_name",
                        name: "beneficiary_name"
                    },
                    {
                        data: "desc",
                        name: "desc"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    }
                ],
                columnDefs: [
                    { className: 'text-center', targets: [1, 2] },
                    ], lengthMenu: [[10, 30, 50, -1], [10, 30, 50, 'All']]
            });
            $(".company").on('change', function (e) {
                e.preventDefault();
                $('#cidsBank').DataTable().ajax.reload();
            })

            $('#cidsBank').on("click", ".btn-delete",  function () {
                const id_cidb = $(this).data("id_cidb");
                const cidbank = $(this).data("cidbank");
                $("input[name!='_token']").val("");
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Want to Delete ${cidbank}!`,
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
                            url: `/data-master/m-rabbank/delete/${id_cidb}`,
                            success: function (response) {
                                console.info("response: ", response)
                                const { status, message } = response;
                                if (status == 1) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: `${cidbank} has been Deleted.`,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
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