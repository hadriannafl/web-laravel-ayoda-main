<x-app-layout background="bg-white">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Update Delivery Orders 📦</h1>
        </div>
            <div class="px-5 py-4">
                <div class="space-y-3">
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="code">Order Code :
                        </label>
                        <input id="id" name="id" class=" id form-select w-full md:w-3/4 px-2 py-1"
                            value="{{ $viewDo->id }}"  hidden />
                        </label>
                        <input id="code" name="code"
                            class="code form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{ $viewDo->code }}" readonly  />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Delivery Order Number : </label>
                        <input id="number" name="number"
                            class="number form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{ $viewDo->do_number }}" readonly  />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="status">Status : </label>
                        <input id="status" name="status"
                            class="status form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{ $viewDo->name_status }}" readonly  />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="date">Delivery Date : </label>
                        <input id="date" name="date"
                            class="date form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{ $viewDo->delivery_date }}" readonly  />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="by">Delivery By : </label>
                        <input id="by" name="by"
                            class="by form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200" type="text"
                            value="{{ $viewDo->delivery_by }}" readonly  />
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <label class="block w-full md:w-1/4 text-sm font-medium mb-1" for="company">Delivery Address : </label>
                        <textarea id="notes" name="notes" class="notes form-input w-full md:w-3/4 px-2 py-1 read-only:bg-slate-200"
                            rows="3" readonly >{{ $viewDo->delivery_address}} </textarea>
                    </div>
                    <div class="table-responsive mt-4">
                        <label class="block text-sm font-medium mb-1" for="address">Delivery Product Items :</label>
                        <table class="table table-striped table-bordered detail-delivery-orders"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-sm text-center">Product Code</th>
                                    <th class="text-sm text-center">Product Name</th>
                                    <th class="text-sm text-center">Batch No</th>
                                    <th class="text-sm text-center">Qty</th>
                                    <th class="text-sm text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="detail-delivery-orders" id="detail-delivery-orders">
                                
                            </tbody>
                        </table>
                    </div>
                    <form method="post" class="form_do_update" enctype="multipart/form-data" action="{{ route('do-update.status', ['doNumber' => $viewDo->do_number]) }}">
                        @csrf
                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="file">AWB DO Upload:</label>
                                <input name="photo1" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output1-${code}')" required />
                                <img id="output1-${code}" style="max-width: 300px; max-height: 150px"/>
                            </div>
                            <div></div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="file">Signed DO Upload:</label>
                                <input name="photo2" class="form-input w-full md:w-3/4 px-2 py-1" type="file" accept="image/jpg" onchange="loadFileMultiple(event, 'output2-${code}')" required />
                                <img id="output2-${code}" style="max-width: 300px; max-height: 150px"/>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3 gap-3 mt-3">
                            <div></div>
                            <div></div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="file">Status Delivery Orders:</label>
                                <select name="doStatus" class="form-select w-full md:w-3/4 px-2 py-1" required>
                                    <option value="" hidden>Select Status</option>
                                    <option value="301">All Delivered - CONFIRMED</option>
                                    <option value="302">Partially Damage/Lost - DAMAGE/LOST</option>
                                    <option value="303">All Lost Delivery - DAMAGE/LOST</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3 gap-3 mt-5">
                                <div></div>
                                <button type="submit" name="status" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" />Save<button>
                                <div></div>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    @section('js-page')
    <script>
        const dataProducts = <?=$dataDeliveryOrders?>;
        let tableRow = '';
        let productIdx = 0;
        
        for (const value of dataProducts) {
            console.info(value)
            tableRow += "<tr id=\"row-" + productIdx + "\">\n" +
                "   <td class=\"text-center\">" + value.product_code + "<input type=\"hidden\" name = \"rows[" + productIdx + "][product_code]\" value =" + value.product_code + "></td>\n" +
                "   <td class=\"text-center\">" + value.product_name + "<input type=\"hidden\" name = \"rows[" + productIdx + "][product_name]\" value =" + value.product_name + "></td>\n" +
                "   <td class=\"text-center\">" + value.batch_no + "<input type=\"hidden\" name = \"rows[" + productIdx + "][batch_no]\" value =" + value.batch_no + "></td>\n" +
                "   <td class=\"text-center\">" + value.qty + "<input type=\"hidden\" name = \"rows[" + productIdx + "][qty]\" value =" + value.qty + "></td>\n" +
                "   <td class=\"text-center\">" + value.status_order + "<input type=\"hidden\" name = \"rows[" + productIdx + "][status_order]\" value =" + value.status_order + ">" + "<input type=\"hidden\" name = \"rows[" + productIdx + "][product_id]\" value =" + value.product_id + "></td>\n"
            "</tr>";
            productIdx++;

        }
        $("#detail-delivery-orders").append(tableRow);
    </script>
    @endsection
</x-app-layout>