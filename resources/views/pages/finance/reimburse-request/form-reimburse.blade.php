<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Form Reimburse Request 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" enctype="multipart/form-data" action="{{ route('reimburse-request.create') }}" id="form_create">
                @csrf
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Date Request :<span
                        class="text-rose-500">*</span></label>
                    <input id="date" name="date"
                    class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                    Value="{{date('Y-m-d')}}" required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="id">Applicant : <span
                        class="text-rose-500">*</span></label>
                    <input id="name" name="name"
                        class="name form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->username}}" readonly/>
                    <input id="id" name="id"
                        class="id form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        value="{{Auth::user()->employee_id}}" readonly hidden/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="bank">Bank Account : <span
                        class="text-rose-500">*</span></label>
                    <input id="bank" name="bank" 
                        class="bank form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="number">Bank Account Number  : <span
                        class="text-rose-500">*</span></label>
                    <input id="number" name="number"
                        class="number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="number" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="account">Under the Name of : <span
                        class="text-rose-500">*</span></label>
                    <input id="account" name="account"
                        class="account form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="description">Reimburse Note : <span
                        class="text-rose-500">*</span></label>
                    <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                        rows="3" required></textarea>
                </div>
                <div class="flex flex-row md:flex-row mb-3 mt-3">
                    <label class="block text-sm font-medium mb-1" for="task_id">Add Reimburse Detail : <span
                    class="text-rose-500">*</span>
                    </label>
                    <div x-data="{ modalOpen: false }">
                        <button class="ml-2 btn bg-indigo-500 hover:bg-indigo-600 text-white" type="button"
                            @click.prevent="modalOpen = true" aria-controls="feedback-modal">
                            <svg class="w-4 h-4 fill-current  text-slate-200" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
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
                            @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Add Detail</div>
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
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="type">Reimburse Type :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <select id="type" name="type" class="type form-input w-full md:w-3/4 px-2 py-1">
                                                <option value="" selected hidden>Select Type</option>
                                            @foreach ( $dataType as $type)
                                                <option value="{{$type->reimburse_type}}">{{$type->reimburse_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="reimburse">Reimburse Concern :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="reimburse" name="reimburse"
                                        class="reimburse form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                        type="text"/>
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="price">Price (IDR) :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="price" name="price"
                                            class="price form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                                            type="number" />
                                    </div>
                                    <div class="flex justify-between flex-col md:flex-row mb-3">
                                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1"
                                            for="image">Upload File PDF :<span
                                            class="text-rose-500">*</span>
                                        </label>
                                        <input id="file" name="file" type="file" accept="application/pdf"
                                            class="file form-input w-full md:w-3/4 px-2 py-1"/>
                                    </div>
                                    <p id="uploaded" hidden>Uploaded</p>
                                    <div class="space-y-3">
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="px-5 py-4 border-t border-slate-200">
                                        <div class="flex flex-wrap justify-end space-x-2">
                                            <button type="button"
                                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                @click="modalOpen = false">Close</button>
                                            <button type="button"
                                                class="btn btn-sm btn-addProduct bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click="modalOpen = false" id="addProduct">Add Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row md:flex-row">
                    <table class="tableProductAddBody table table-striped table-bordered mt-3"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-sm text-center">Reimburse Type</th>
                                <th class="text-sm text-center">Reimburse Concern</th>
                                <th class="text-sm text-center">Price (IDR)</th>
                                <th class="text-sm text-center">File Upload</th>
                                <th class="text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tableProductAddBody" id="tableProductAddBody">

                        </tbody>
                    </table>
                </div>
                <div class="flex flex-row mb-3 mt-3">
                    <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="totalAmount">Grand Total (IDR) :<span
                        class="text-rose-500">*</span>
                    </label>
                    <input type="text" class="bg-white border-white md:w-1/4 px-2 py-1" disabled/>
                    <label class="md:w-1/6 text-sm font-medium mb-1 ml-5 text-white" for="discount2idr">Discount 1 (IDR):
                    </label>
                    <input id="grandtotal" name="grandtotal" class="grandtotal form-input md:w-1/3 px-2 py-1 read-only:bg-slate-200 text-right ml-6" type="text" readonly required/>
                    <input id="grandtotal1" name="grandtotal1" class="grandtotal1 form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text" readonly hidden required/>
                </div>
                    <center><button class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Create Reimburse Request</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>   
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    // data product
    var subtotal = 0;
    var formData = new FormData();
    $(document).ready(function () {
        $("#addProduct").click(function () {
            var productIdx = makeid(3);
            console.log(productIdx)
            var type = $('#type').val();
            var reimburse = $('#reimburse').val();
            var price = $('#price').val();
            var file = $('#file')[0].files[0]; // Ambil file yang dipilih
            var file1 = file ? file.name : ''; // Gunakan nama file atau kosongkan jika tidak ada file yang dipilih
            var total = price;
            subtotal += parseFloat(total)

            var tr = "<tr id=\"row-" + productIdx + "\">\n" +
                "  <td class=\"text-center\">" + type + "<input type=\"hidden\" name = \"types" + productIdx + "\"value =" + type + "><input type=\"hidden\" name = \"ids[]\" value =" + productIdx + " class=\"hidden\"/></td>\n" +
                "  <td class=\"text-left\">" + reimburse + "<textarea name = \"reimburses" + productIdx + "\"hidden>" + reimburse + "</textarea></td>\n" +
                "  <td class=\"text-right\">" + `${divider(price)}` + "<input type=\"hidden\" name = \"prices" + productIdx + "\" value =" + price + "></td>\n" +
                "  <td class=\"text-center\">" + file1 + "</td>\n" +
                "   <td class=\"text-center\">" + "<button type=\"button\" onclick=\"deleteDataProduct(`" + productIdx + "`,`" + total + "`)\" class=\"remove_button btn border-slate-200 hover:border-slate-300\" > <svg class=\"w-4 h-4 fill-current text-rose-500 shrink-0\" viewBox=\"0 0 16 16\"> <path d=\"M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z\" /> </svg> </button>" + "</td>"
            "</tr>";

            if (type === '' || reimburse === '' || total === '' || file === '') {
                alert('Data Detail Reimbursement Must Fill');
                return false;
            }

            $("#tableProductAddBody").append(tr);

            formData.append('file'+productIdx, file);



            $('#type').val('');
            $('#reimburse').val('');
            $('#price').val('');
            $('#file').val('');
            $('#grandtotal').val(`${divider(subtotal)}`);
            $('#grandtotal1').val(subtotal);

            // productIdx++;
        });

        $('#form_create').submit(function(event) {
            event.preventDefault(); // Menghentikan aksi default form (pengiriman dan reload halaman)

            var formData2 = new FormData($(this)[0]);
            //Gabungkan data dari formData2 ke formData1
            formData2.forEach((value, key) => {
                formData.append(key, value);
            })

            // Kirim data ke server menggunakan AJAX POST
            $.ajax({
                url: '{{ route("reimburse-request.create") }}',
                method: 'POST',
                data: formData, // Menggunakan objek FormData sebagai data
                processData: false, // Set false agar FormData tidak diubah secara otomatis
                contentType: false, // Set false agar jQuery mengatur tipe konten dengan benar
            success: function(response) {
                if(response.indctr == '1'){
                    location.href = "{{route('reimburse-list')}}";
                }else{
                    alert('Failed '+response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Failed '+error);
            }
            });
        });
    });
    function deleteDataProduct(row, total) {
        subtotal -= total;
        $('#row-'+row).remove();
        formData.delete('file'+row);
        $('#grandtotal').val(`${divider(subtotal)}`);
        $('#grandtotal1').val(subtotal);
    }
</script>
@endsection
</x-app-layout>