<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit M. Input Fixed Asset 📝</h1>
        </div>
        <div class="flex flex-row text-xs mb-3">
            @if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888')
            <label class="flex flex-row text-xs">
                <p class="flex flex-row text-slate-800 mb-3 text-sm mt-2" for="company123">Company :</p>
                <select id="company123" class="company123 flex flex-row ml-3 mb-3 text-xs" name="company123">
                    <option value="">All</option>
                    @foreach ( $dataChildCompany as $company)
                    <option value="{{$company->id_company}}">{{$company->name}}</option>
                    @endforeach
                </select>
            @else
                <input id="company123" name="company123"
                class="company123 form-select w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                value="{{$dataChildCompany->id_company}}" readonly hidden/>
            @endif
        </div>
        <div class="px-5 py-4">
            <div class="space-y-3">
                <div class="table-responsive">
                    <table id="office-inventory12" class="table table-striped table-bordered text-xs" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">M. Input #</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Warehouse Address</th>
                                <th class="text-center">Purchase Date</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Grand Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @section('js-page')
    <script>  
    $(document).ready(function() {
        $('#office-inventory12').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    stateServe: true,
                    "order": [[ 1, "asc" ]],
                    language: {
                        search: "Search FORM FA # : "
                    },
                    ajax: {
                        url: "{{ route('listformfa.getdata') }}",
                        data:function(d){                    
                            d.company123 = $("#company123").val()
                        }
                    },
                    columns: [
                    {
                        data: "form_date",
                        name: "form_date"
                    },
                    {
                        data: "no_form",
                        name: "no_form"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "w_address",
                        name: "w_address"
                    },
                    {
                        data: "purchdate",
                        name: "purchdate"
                    },
                    {
                        data: "qty",
                        name: "qty"
                    },
                    {
                        data: "gtotal",
                        name: "gtotal"
                    },
                    {
                        data: "action1",
                        name: "action1"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 4] },
                    { className: 'text-right', targets: [5, 6] },
                    ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
                });

                $('#status123').on('change', function (e) {
                    $('#office-inventory12').DataTable().ajax.reload();
                })
                $('#company123').on('change', function (e) {
                    $('#office-inventory12').DataTable().ajax.reload();
                })

                $('#office-inventory12').on("click", ".btn-generate",  function () {
                    const idassets = $(this).data('id');
                    $("input[name!='_token']").val("");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Want to release this Fixed Asset!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Release it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: `/ga/fixedasset/generate/${idassets}`,
                                success: function (response) {
                                    console.info("response: ", response)
                                    const { status, message } = response;
                                    if (status == 1) {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: `Fixed Assets has been Release.`,
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