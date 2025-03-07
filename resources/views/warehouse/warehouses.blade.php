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
                            @if ($warehouse)
                                <h3 class="text-xl"><strong>Action</strong></h3>
                                    <!-- ถ้ามี warehouse จะแสดงปุ่มแก้ไขและลบ -->
                                    <div class="flex space-x-4">
                                        <!-- ปุ่มแก้ไข -->
                                        <a href="{{ route('warehouse.edit', $warehouse->id) }}">
                                            <x-primary-button class="flex items-center space-x-2" style="margin-right: 10px; background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">  
                                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                </svg>แก้ไข
                                            </x-primary-button>                                            
                                        </a>

                            
                                        <!-- ปุ่มลบ -->
                                        <a href="#" class="delete-button-warehouse" data-id="{{ $warehouse->id }}">
                                            <x-primary-button class="flex items-center space-x-2" style="background-color: #DC3545; color: white; text-shadow: 1px 1px 2px black;">  
                                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                </svg>ลบ
                                            </x-primary-button>
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center p-4 bg-yellow-100 border border-yellow-300 text-yellow-600 rounded-lg">
                                        <p>ยังไม่มีข้อมูลคลังสินค้า กรุณาเพิ่มข้อมูลคลังสินค้า</p>
                                        <a href="{{ route('warehouse.create') }}">
                                            <x-primary-button class="mt-4">เพิ่มข้อมูลคลังสินค้า</x-primary-button>
                                        </a>
                                    </div>
                            @endif
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display warehouse details only if $warehouse exists -->
                            @if ($warehouse)
                                <h3 class="text-xl mb-4"><strong>รายละเอียด</strong></h3>
                                <div class="flex flex-wrap mb-4">
                                    <div class="flex items-center" style="margin-right: 20px;">
                                        <strong>รหัสคลังสินค้า:</strong> 
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->id ?? 'ไม่มีข้อมูล' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center" style="margin-right: 20px;">
                                        <strong>ชื่อ:</strong> 
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->name ?? 'ไม่มีข้อมูล' }}
                                        </span>
                                    </div>
                                </div>                                                   
                                <div class="flex flex-wrap mb-4">
                                    <div class="flex items-center">
                                        <strong>ที่อยู่:</strong> 
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->address ?? 'ไม่มีข้อมูล' }}
                                        </span>
                                    </div>
                                </div>                                                   

                                <div class="flex flex-wrap mb-4 space-x-4">
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>พื้นที่ทั้งหมด:</strong> 
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_total_area ?? 'ไม่มีข้อมูล' }} ตารางเมตร
                                        </span>                                   
                                    </p>
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>พื้นที่จัดเก็บที่ใช้ได้:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_available_area ?? 'ไม่มีข้อมูล' }} ตารางเมตร
                                        </span>  
                                    </p>
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>พื้นที่จัดเก็บที่ใช้แล้ว:</strong>
                                        <span style="margin-left: 5px; color: {{ $totalUsedArea > 0 ? 'red' : 'green' }};">
                                            {{ $totalUsedArea > 0 ? $totalUsedArea : '0' }} ตารางเมตร
                                        </span>
                                    </p>
                                    <p class="flex items-center">
                                        <strong>พื้นที่จัดเก็บที่เหลือ:</strong>
                                        <span style="margin-left: 5px; color: {{ $availableArea > 0 ? 'green' : 'red' }};">
                                            {{ $availableArea > 0 ? $availableArea : 'ไม่มีข้อมูล' }} ตารางเมตร
                                        </span>
                                    </p>
                                </div>
                                <div class="flex flex-wrap mb-4 space-x-4">
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>ความกว้าง:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_width ?? 'ไม่มีข้อมูล' }} เมตร
                                        </span>  
                                    </p>
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>ความยาว:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_length ?? 'ไม่มีข้อมูล' }} เมตร
                                        </span>  
                                    </p>
                                    <p class="flex items-center">
                                        <strong>ความสูง:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_height ?? 'ไม่มีข้อมูล' }} เมตร
                                        </span>  
                                    </p>
                                </div>
                                <div class="flex flex-wrap mb-4 space-x-4">
                                    <p class="flex items-center" style="margin-right: 20px;">
                                        <strong>ประเภทพื้นที่:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->warehouse_area_type ?? 'ไม่มีข้อมูล' }}
                                        </span>
                                    </p>
                                    <p class="flex items-center">
                                        <strong>สถานะ:</strong>
                                        <span style="margin-left: 5px;">
                                            {{ optional($warehouse)->status ?? 'ไม่มีข้อมูล' }}
                                        </span>
                                    </p>
                                </div>

                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            @if ($warehouse)
                            <h3 class="text-xl mb-4"><strong>พื้นที่จัดเก็บสินค้า</strong></h3>
                            <div class="flex justify-between">
                                <a href="{{ route('warehouse.createzone', ['id' => $warehouse->id]) }}" class="">
                                    <x-primary-button style="background-color: #28A745; color: white; text-shadow: 1px 1px 2px black;">
                                        เพิ่มข้อมูล
                                    </x-primary-button>
                                </a>
                                <form method="GET" action="{{ route('warehouse.warehouses') }}">
                                    <x-text-input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหา" value="{{ request('search') }}" />
                                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                                </form>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสโซน</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อโซน</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสคลังสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสสินค้า</strong></td>
                                        <td width="15%" align="left" valign="middle"><strong>ขนาด</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ปริมาตรพื้นที่</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>สถานะ</strong></td>
                                        <td colspan="2" width="10%" align="center" valign="middle"><strong>Action</strong></td>
                                    </tr>
                            
                                    @foreach ($zones as $zone)
                                    <tr>
                                        <td width="10%" align="left" valign="middle">{{ $zone->id }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $zone->name }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $zone->warehouse_id }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $zone->product_id}}</td>
                                        <td width="15%" align="left" valign="middle">{{ $zone->zone_width }}×{{ $zone->zone_length }}×{{ $zone->zone_height }} ม.</td>
                                        <td width="10%" align="left" valign="middle">{{ $zone->zone_volume }} ลบ.ม.</td>
                                        <td width="10%" align="left" valign="middle">{{ $zone->zone_status }}</td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="{{ route('warehouse.editzone', ['id' => $zone->id]) }}">
                                                <x-primary-button class="flex items-center space-x-2" style="background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">
                                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                    </svg>แก้ไข
                                                </x-primary-button>  
                                            </a>
                                        </td>
                                        <td width="10%" align="center" valign="middle">
                                            <a href="#" class="delete-button-zone" data-id="{{ $zone->id }}">
                                                <x-primary-button class="flex items-center space-x-2" style="background-color: #DC3545; color: white; text-shadow: 1px 1px 2px black;">
                                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                    </svg>ลบ
                                                </x-primary-button> 
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                            {!! $zones->links() !!}                        
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $('.delete-button-warehouse').click(function(event){
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

    <script>
        @if ($warehouse)
            $('.delete-button-zone').click(function(event){
                event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของปุ่ม

                // แสดงตัวยืนยันการลบ
                var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');
                
                // ถ้าผู้ใช้ยืนยันการลบ
                if (confirmDelete) {
                    var zoneId = $(this).data('id');
                    
                    // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                    $.ajax({
                        url: "{{ route('warehouse.zone.destroy', ['warehouse' => $warehouse->id, 'zone' => ':id']) }}".replace(':id', zoneId),
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
        @else
            console.error('Warehouse data is not available.');
        @endif
    </script>


    @if($availableArea < 0)
    <script>
        window.onload = function() {
            alert('พื้นที่ที่ใช้งานทั้งหมดเกินกว่าพื้นที่ที่มีในคลังสินค้า กรุณาตรวจสอบข้อมูลอีกครั้ง');
        }
    </script>
    @endif

</x-appadmin-layout>