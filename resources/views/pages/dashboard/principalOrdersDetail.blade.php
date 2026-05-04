<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Principal Orders Detail 💳
                </h1>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table id="ordersPrincipalDetails1" class="table table-striped table-bordered text-xs ordersPrincipalDetails1" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-sm text-center">purchase order #</th>
                        <th class="text-sm text-center">Inventory ID</th>
                        <th class="text-sm text-center">Inventory Name</th>
                        <th class="text-sm text-center">Quantity</th>
                        <th class="text-sm text-center">Unit</th>
                        <th class="text-sm text-center">Price</th>
                        <th class="text-sm text-center">Total</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@section('js-page')
<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const dataPrincipalDetail = <?=$dataPrincipalDetail?>;
        let tableRow = '';
        let productIdx = 0;
        for (const value of dataPrincipalDetail) {
            tableRow += `<tr>
                        <td class="text-center">${value.idpurch} </td>
                        <td class="text-center">${value.idinventory} </td>
                        <td class="text-left">${value.productName} </td>
                        <td class="text-center">${value.qty}</td>
                        <td class="text-right">${value.unit}</td>
                        <td class="text-right">${value.currency} ${newDivider(value.price)}</td>
                        <td class="text-right">${value.currency} ${newDivider(value.grandTotal)}</td>
                    </tr>`
        }
        $(".ordersPrincipalDetails1").find('tbody').append(tableRow);
</script>
@endsection
</x-app-layout>