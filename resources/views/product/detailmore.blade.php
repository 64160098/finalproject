<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละเอียด') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('product.products') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>รายละเอียด</span></p>
                            </div>                                                           
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display warehouse details -->
                            <h3 class="text-xl mb-4"><strong>รายละเอียด</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>เลขที่ใบรายละเอียด:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->id  }}</span>
                                </div>
                            </div> 
                            <hr class="my-4 border-gray-300 dark:border-gray-700">                                                 
                            <h3 class="text-l mb-4"><strong>ข้อมูลสินค้า</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>รหัสสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->product_id  }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->product->product_name }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ขนาด:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->product->product_width }}×{{ $eoqrop->product->product_length }}×{{ $eoqrop->product->product_height }} เซนติเมตร</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ปริมาตรสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->product->product_volume }} ลูกบาศก์เซนติเมตร</span>
                                </div>
                            </div>  
                            <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                            <h3 class="text-l mb-4"><strong>ข้อมูลคลังสินค้า</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>รหัสคลังสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse_id }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อคลังสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse->name }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>ที่อยู่:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse->address }}</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ขนาด:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse->warehouse_width }}×{{ $eoqrop->warehouse->warehouse_length }}×{{ $eoqrop->warehouse->warehouse_height }} เมตร</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>พื้นที่ทั้งหมด:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse->warehouse_total_area }} ตารางเมตร</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>พื้นที่จัดเก็บที่ใช้ได้:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->warehouse->warehouse_available_area }} ตารางเมตร</span>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                            <h3 class="text-l mb-4"><strong>ข้อมูลพื้นที่จัดเก็บสินค้า</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>รหัสพื้นที่จัดเก็บสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->zone->id }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อพื้นที่จัดเก็บสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->zone->name }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ขนาด:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->zone->zone_width }}×{{ $eoqrop->zone->zone_length }}×{{ $eoqrop->zone->zone_height }} เมตร</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ปริมาตรพื้นที่จัดเก็บสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->zone->zone_volume }} ลูกบาศก์เมตร</span>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-l mb-4"><strong>วิเคราะห์การสั่งซื้อและจุดสั่งซ้ำ</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>Economic Order Quantity(EOQ):</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->eoq }}</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>Reorder Point(ROP):</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->rop }}</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>ความจุของพื้นที่จัดเก็บ:</strong> 
                                    <span style="margin-left: 5px;">{{ $eoqrop->storage_capacity }}</span>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- แก้ไขปุ่มแก้ไข -->
                            @if ($eoqrop)
                                <a href="{{ route('eoqrop.edit', ['id' => $product->id]) }}">
                                    <x-primary-button class="mt-6 flex items-center space-x-2" style="background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">                                                    
                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                        </svg>แก้ไข                                                                            
                                    </x-primary-button>
                                </a>
                            @else
                                <span>ไม่พบข้อมูล</span>
                            @endif 

                            <!-- แก้ไขปุ่มดาวน์โหลด -->
                            @if ($eoqrop)
                                    <a href="{{ route('product.eoqropdetail', $eoqrop->id) }}">
                                        <x-primary-button class="mt-6 flex items-center space-x-2">   
                                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                                            </svg>                                    
                                            <span>ดาวน์โหลด</span>
                                        </x-primary-button>
                                    </a>
                            @else
                                <p>ไม่พบข้อมูล</p>
                            @endif 

                            <!-- แก้ไขปุ่มลบ -->
                            @if ($eoqrop)
                                    <a href="#" class="delete-button-eoq" data-id="{{ $eoqrop->id }}">
                                        <x-primary-button class="mt-6 flex items-center space-x-2" style="background-color: #DC3545; color: white; text-shadow: 1px 1px 2px black;">   
                                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                            </svg>                                    
                                            <span>ลบ</span>
                                        </x-primary-button>
                                    </a>
                            @else
                                <span>ไม่พบข้อมูล</span>
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
        $(document).on('click', '.delete-button-eoq', function(event){
            event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของปุ่ม
    
            // แสดงตัวยืนยันการลบ
            var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');
            
            // ถ้าผู้ใช้ยืนยันการลบ
            if (confirmDelete) {
                var eoqropId = $(this).data('id');
                
                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: "{{ route('product.destroyeoq', ':id') }}".replace(':id', eoqropId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('product.products') }}";
                    },
                    error: function(xhr){
                        // ตรวจสอบและแสดงข้อความข้อผิดพลาดจากเซิร์ฟเวอร์
                        var errorMsg = 'เกิดข้อผิดพลาดในการลบข้อมูล';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            errorMsg = xhr.responseText;
                        }
                        console.error('Error:', xhr);
                        alert(errorMsg);
                    }
                });
            }
        });
    </script>
    

</x-appadmin-layout>