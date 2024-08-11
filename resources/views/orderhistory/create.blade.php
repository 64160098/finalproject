<style>
    #quantity_products_received {
    width: 70%; /* หรือความกว้างที่คุณต้องการ */
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ประวัติการสั่งซื้อสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div>
                                <a href="{{ route('receiveproduct.create') }}" class=""><x-primary-button>เลือกข้อมูลสินค้า</x-primary-button></a>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table id="producttable" width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-condensed  table-hover p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>จำนวนสินค้าที่รับ</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ต้นทุน/หน่วย</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>เป็นเงินทั้งหมด</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>แก้ไข</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>ลบ</strong></td>
                                    </tr>
                                    @foreach ($orderhistorys as $orderhistory)
                                    <tr>
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->code }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->product_name }}</td> 
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->quantity_products_received }}</td>                              
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->unit }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->cost_unit }}</td> 
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->total }}</td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="{{ route('orderhistory.edit', $orderhistory->id) }}">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a> 
                                        </td>
                                        <td width="10%" align="center" valign="middle"> 
                                            <form action="{{ route('orderhistory.destroy', $orderhistory->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>             
                                    @endforeach
                                </tbody>
                            </table>
                            </form>
                        </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let table = new DataTable('#producttable');
    </script>

    <script>
    function resetPage() {
        // ล้างค่าจำนวนสินค้ารวมและราคาต้นทุนรวม
        document.getElementById('totalQuantity').innerText = '0';
        document.getElementById('totalCost').innerText = '0';

        // ล้างข้อมูลในตาราง
        var table = document.getElementById('producttable');
        var rowCount = table.rows.length;
        for (var i = rowCount - 1; i > 0; i--) {
            table.deleteRow(i);
        }

        // ส่งคำขอรีเซ็ตหน้าเว็บ
        document.getElementById('cancelForm').submit();
    }
    </script>

</x-appadmin-layout>
