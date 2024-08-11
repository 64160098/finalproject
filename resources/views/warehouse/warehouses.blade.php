<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ข้อมูลพื้นที่คลังสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div class="flex justify-between">
                                <a href="{{ route('warehouse.create') }}" class=""><x-primary-button>เพิ่มข้อมูล</x-primary-button></a>
                                <form method="GET" action="{{ route('warehouse.index') }}">
                                    <input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหา" value="{{ request('search') }}">
                                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                                </form>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสคลังสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อคลังสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>พื้นที่ทั้งหมด</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ประเภทพื้นที่</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>สถานะ</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>รายละเอียด</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>แก้ไข</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>ลบ</strong></td>
                                    </tr>
                            
                                    @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td width="10%" align="left" valign="middle">{{ $warehouse->id }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $warehouse->name }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $warehouse->warehouse_total_area }} ตร.ม.</td>
                                        <td width="10%" align="left" valign="middle">{{ $warehouse->warehouse_area_type }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $warehouse->status }}</td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="{{ route('warehouse.zone', $warehouse->id) }}">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                                                  </svg>รายละเอียด                                                  
                                            </a>
                                        </td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="{{ route('warehouse.edit', $warehouse->id) }}">
                                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                </svg>แก้ไข
                                            </a>
                                        </td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="#" class="delete-button" data-id="{{ $warehouse->id }}">
                                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                </svg>ลบ
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                            
                            {!! $warehouses->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
                    url: "{{ route('warehouse.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('warehouse.warehouses') }}";
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