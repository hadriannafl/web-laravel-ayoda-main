<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Create New PIC 📝</h1>
        </div>

    <form action="{{ route('picoffering.create') }}" method="post" enctype="multipart/form-data">
         @csrf
            <div class="flex flex-col md:flex-row">
                <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Company Name
                    :
                </label>
                <input id="company" name="company" placeholder="Please Select Company Name"
                    class="company form-input md:w-1/2 px-2 py-1 read-only:bg-slate-200 "
                    type="text" readonly required />
                <div x-data="{ modalOpen: false }">
                    <button type="button" class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white"
                        @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-current text-slate-200"
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path class="fill-current text-slate-200"
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                        <span></span>
                    </button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                        x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        aria-hidden="true" x-cloak></div>
                    <!-- Modal dialog -->
                    <div id="feedback-modal"
                        class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                        role="dialog" aria-modal="true" x-show="modalOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                        <div class="bg-white rounded shadow-lg overflow-auto w-3/4 max-h-full"
                            @click.outside="modalOpen = false"
                            @keydown.escape.window="modalOpen = false">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800">Search Company</div>
                                    <button type="button" class="text-slate-400 hover:text-slate-500"
                                        @click="modalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path
                                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Modal content -->
                            <div class="modal-content text-xs px-5 py-4">
                                <div class="table-responsive">
                                    <table id="proyek"
                                        class="table table-striped table-bordered text-xs"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Company ID</th>
                                                <th class="text-center">Company Name</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="space-y-3">
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="px-5 py-4 border-t border-slate-200">
                                <div class="flex flex-wrap justify-end space-x-2">
                                    <button type="button"
                                        class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                        @click="modalOpen = false">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div></div>
            <input id="idCompany" name="idCompany"
                class="idCompany form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200" type="text"
                readonly hidden required/>
                <div class="flex justify-between flex-col md:flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="name_pic">Name :
                    </label>
                    <input id="name_pic" name="name_pic"
                        class="name_pic form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" required />
                    <input id="idCompany" name="idCompany"
                        class="idCompany form-input w-full md:w-72 px-2 py-1 read-only:bg-slate-200" type="text"
                        readonly hidden required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="phone_number_1">Dept. / Position :
                    </label>
                    <input id="phone_number_1" name="phone_number_1"
                        class="phone_number_1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="text" required />
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="phone_number_2">Phone Number :
                    </label>
                    <input id="phone_number_2" name="phone_number_2"
                        class="phone_number_2 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="number" required />
                </div>
                <div class="flex justify-between flex-col md:flex-row mb-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                        for="email">Email :
                    </label>
                    <input id="email" name="email"
                        class="email form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        type="email" required />
                </div>

                <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit">
                    <span class="xs:block ml-5 mr-5">Create New PIC</span>
                </button> </center>
            <div class="space-y-3">
            </div>
        </div>
    </form>
    @section('js-page')
    <script>
        // data Companies
        $(document).ready(function () {
            $('#proyek').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                stateServe: true,
                order: [[1, 'asc']],
                language: {
                    search: "Search Customer Name: "
                },
                ajax: {
                    url: "{{ route('create.getcompany') }}"
                },
                columns: [
                    {
                        data: "company_id",
                        name: "company_id"
                    },
                    {
                        data: "company",
                        name: "company"
                    },
                    {
                        data: "status_name",
                        name: "status_name"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                columnDefs: [
                    { className: 'text-center', targets: [2, 3] },
                    {
                        target: 0,
                        visible: false,
                        searchable: false,
                    }
                ], lengthMenu: [[30, 50, 100, -1], [30, 50, 100, 'All']]
            });

            $('#proyek').on("click", ".btn-select", function () {
                const idCompany = $(this).data("id");
                const company = $(this).data("nama");
                const sales = $(this).data("sales");
                const pic = $(this).data("pic");

                $.ajax({
                    type: "GET",
                    url: `/tasks/proyek/proyek-all/selectcompany/${idCompany}`,
                    success: function (response) {
                        let picList = '';
                        for (const value of response.listCompanyPic) {
                            picList += `<option value="${value.id}" ${value.id == pic ? 'selected' : ''}>${value.name} (${value.phone_number_1} / ${value.phone_number_2} / ${value.email})</option>`;
                        }
                        // let salesList = '';
                        // for (const value of response.salesList) {
                        //     salesList += `<option value="${value.id}" ${value.id == sales ? 'selected' : ''}>${value.username} (${value.sales_id})</o ption>`;
                        // }
                        $(".idCompany").val(idCompany);
                        $(".company").val(company);
                        $(".sales").val(sales);
                        $(".pic").append(picList);

                        $(".btn-pic").attr("disabled", false);
                    }
                });
            });
        });

    </script>
    @endsection
</x-app-layout>