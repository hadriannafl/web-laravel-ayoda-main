<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Clone Cost Center 📝</h1>
        </div>

    <div class="px-5 py-4">
        <div class="space-y-3">
            <form method="post" id="form_create" enctype="multipart/form-data" action="{{ route('cost-list.clone', ['idCC' => $dataCost->idrec]) }}">
                @csrf
                <div class="flex justify-between flex-col md:flex-row" hidden>
                    <label class="text-sm font-medium mb-1" for="idRab">idreqform #</label>
                    <input id="idRab" name="idRab" value="{{$dataCost->idreqform}}"
                        class="idRab form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                        required readonly/>
                </div>
                <div class="flex justify-between flex-col md:flex-row">
                    <label class="text-sm font-medium mb-1" for="departmentName">Cost Center Description<span
                        class="text-rose-500">*</span></label>
                    <input id="departmentName" name="departmentName" value="{{$dataCost->department}}"
                        class="departmentName form-input w-full md:w-3/4 px-2 py-1" minlength="10" type="text" maxlength="100" required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="formDate">Form Date<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1 ml-2">:</label>
                    <input id="formDate" name="formDate" value="{{date('Y-m-d')}}"
                        class="formDate selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>
                <div class="flex justify-between flex-col md:flex-row mt-3">
                    <label class="text-sm font-medium mb-1" for="periode">Due Date<span
                        class="text-rose-500">*</span></label>
                    <label class="text-sm font-medium mb-1">:</label>
                    <input id="due_date" name="due_date" value="{{date('Y-m-d')}}"
                        class="due_date selector form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" data-date-format="YYYY/MM/DD" type="date"
                        required/>
                </div>

                    <center><button class="btn bg-emerald-500 hover:bg-emerald-600 text-white mt-5" type="submit" id="create_offer">
                        <span class="xs:block ml-5 mr-5">Clone Cost Center</span>
                    </button> </center>
            </form>
        </div>
    </div>

</div>
@section('js-page')
<script>  
    $('#form_create').submit(function (e, params) {
        e.preventDefault();
        $("#create_offer").prop('disabled', true);
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
                if (_response.st == '1') {
                    urlRedirect = '/finance/costcenter-approval/list';
                    window.open(urlRedirect, '_self');
                }else if (_response.st == '2') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Cost Center cannot be in the past',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.close();
                            e.preventDefault();
                            $("#create_offer").prop('disabled', false);
                        }else {
                            Swal.close();
                            e.preventDefault();
                            $("#create_offer").prop('disabled', false);
                        }
                    });
                }
            },
                error: function(){
                alert('Terjadi kesalahan');
            }
        });
    })
    document.getElementById('form_create').addEventListener('submit', function(event) {
        e.preventDefault();
        $("#create_offer").prop('disabled', true);
    });
</script>
@endsection
</x-app-layout>