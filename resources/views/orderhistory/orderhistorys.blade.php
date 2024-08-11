<style>
    #quantity_products_received {
    width: 70%; /* หรือความกว้างที่คุณต้องการ */
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ประวัติการรับสินค้าเข้าคลัง') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end">
                <form method="GET" action="{{ route('orderhistory.index') }}" class="flex items-center">
                    <input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหา" value="{{ request('search') }}">
                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                </form>
            </div>
            <div class="flex justify-end">
                <small class="text-gray-500">**หากต้องการค้นหาวันที่รายงาน <br>**โปรดระบุวันที่ในรูปแบบ YYYY-MM-DD เช่น 2024-01-01</small>
            </div>   
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table id="producttable" width="100%" border="1" cellpadding="5" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>จำนวนสินค้าที่รับ</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ต้นทุน/หน่วย</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>เป็นเงินทั้งหมด</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>วันที่รับ</strong></td>
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
                                        <td width="10%" align="left" valign="middle">{{ $orderhistory->created_at ? $orderhistory->created_at->translatedFormat('d M Y') : '' }}</td>
                                        <td width="10%" align="center" valign="middle"> 
                                            <a href="#" class="delete-button" data-id="{{ $orderhistory->id }}">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                </svg>ลบ
                                            </a>
                                        </td>
                                    </tr>             
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $orderhistorys->links() !!}
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
        $('.delete-button').click(function(event){
            event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของปุ่ม

            // แสดงตัวยืนยันการลบ
            var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');
            
            // ถ้าผู้ใช้ยืนยันการลบ
            if (confirmDelete) {
                var productId = $(this).data('id');
                
                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: "{{ route('orderhistory.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('orderhistory.orderhistorys') }}";
                    },
                    error: function(xhr){
                        console.error('Error:', xhr);
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    }
                });
            }
        });
    </script>


</x-appadmin-layout>
