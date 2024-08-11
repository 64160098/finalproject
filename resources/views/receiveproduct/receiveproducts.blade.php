<?php
$totalQuantity = 0;
$totalCost = 0;

    foreach ($receiveproducts as $receiveproduct) {
    $totalQuantity += $receiveproduct->quantity_products_received;
    $totalCost += $receiveproduct->quantity_products_received * $receiveproduct->cost_unit;
}
?>

<style>
    #quantity_products_received {
    width: 70%; /* หรือความกว้างที่คุณต้องการ */
}
.alert {
    padding: 10px; /* ลด padding */
    margin-bottom: 10px; /* ลด margin */
    border: 1px solid transparent;
    border-radius: 4px;
    position: relative;
    width: 100%; /* ปรับความกว้าง */
    margin: 10px 0; /* จัดกลาง */
    font-size: 15px; /* ปรับขนาดตัวอักษร */
}
.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รับสินค้าเข้าคลัง') }}
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
                                <table id="producttable" width="100%" border="1" cellpadding="5" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td width="10%" align="left" valign="middle">
                                                <input type="checkbox" id="select-all-checkbox">
                                            </td>
                                            <td width="10%" align="left" valign="middle"><strong>รหัสสินค้า</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>จำนวนสินค้าที่รับ</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>ต้นทุน/หน่วย</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>เป็นเงินทั้งหมด</strong></td>
                                            <td width="10%" align="center" valign="middle"><strong>แก้ไข</strong></td>
                                            <td width="10%" align="center" valign="middle"><strong>ลบ</strong></td>
                                        </tr>
                                        
                                        @foreach ($receiveproducts as $receiveproduct)
                                        <tr>
                                            <form class="product-form" action="{{ route('orderhistory.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="code" value="{{ $receiveproduct->code }}">
                                                <input type="hidden" name="product_name" value="{{ $receiveproduct->product_name }}">
                                                <input type="hidden" name="quantity_products_received" value="{{ $receiveproduct->quantity_products_received }}">
                                                <input type="hidden" name="unit" value="{{ $receiveproduct->unit }}">
                                                <input type="hidden" name="cost_unit" value="{{ $receiveproduct->cost_unit }}">
                                                <input type="hidden" name="total" value="{{ $receiveproduct->total }}">

                                            <td width="10%" align="left" valign="middle">
                                                <input type="checkbox" name="selected_products[]" value="{{ $receiveproduct->id }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->code }}
                                                <input type="hidden" name="code" value="{{ $receiveproduct->code }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->product_name }}
                                                <input type="hidden" name="product_name" value="{{ $receiveproduct->product_name }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->quantity_products_received }}
                                                <input type="hidden" name="quantity_products_received" value="{{ $receiveproduct->quantity_products_received }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->unit }}
                                                <input type="hidden" name="unit" value="{{ $receiveproduct->unit }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->cost_unit }}
                                                <input type="hidden" name="cost_unit" value="{{ $receiveproduct->cost_unit }}">
                                            </td>
                                            <td width="10%" align="left" valign="middle">{{ $receiveproduct->total }}
                                                <input type="hidden" name="total" value="{{ $receiveproduct->total }}">
                                            </td>
                                            </form>  
                                            <td width="10%" align="center" valign="middle">
                                                <a href="{{ route('receiveproduct.edit', $receiveproduct->id) }}">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                    </svg>แก้ไข
                                                </a> 
                                            </td>
                                            <td width="10%" align="center" valign="middle"> 
                                                <a href="#" class="delete-button" data-id="{{ $receiveproduct->id }}">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                    </svg>ลบ
                                                </a>
                                            </td>
                                        </tr>   
                                        @endforeach
                                    </tbody>
                                </table>

                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="container mt-2">
                                <div class="space-y-6">
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="custom-table">
                                        <tbody>
                                        <tr>
                                          <td width="12%" align="left" valign="middle">จำนวนสินค้ารวม :</td>
                                          <td width="10%">{{ $totalQuantity }}</td>
                                        </tr>
                                    </div>
                                    <br>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <tr>
                                          <td width="10%" margin-top="50%" align="left" valign="middle">ราคาต้นทุนรวม :</td>
                                          <td width="50%">{{ $totalCost }}</td>
                                          <td id="total_price"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                        </div>
                        </div>
                        <div id="submit-btn">
                            <x-primary-button id="confirm-button"> ยืนยันการรับสินค้า </x-primary-button>
                            <x-primary-button id="cancel-button"> ยกเลิก </x-primary-button>
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
        $(document).ready(function(){
            $('#confirm-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์

                // ตรวจสอบว่ามีสินค้าที่ถูกเลือกหรือไม่
                if ($('input[name="selected_products[]"]:checked').length === 0) {
                    // ถ้าไม่มีสินค้าถูกเลือก ให้แสดงข้อความแจ้งเตือน
                    alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
                    return;
                }
        
                var formDataArray = []; // สร้างอาเรย์เพื่อเก็บข้อมูลจากแต่ละฟอร์ม
        
                // วนลูปผ่านฟอร์มแต่ละฟอร์มเพื่อรวมข้อมูลและเก็บไว้ใน formDataArray
                $('form.product-form').each(function(){
                    var formData = $(this).serialize(); // รวมข้อมูลจากฟอร์มที่ถูกส่งเข้ามา
                    formDataArray.push(formData); // เพิ่มข้อมูลเข้าไปในอาเรย์
                });
        
                // ส่งข้อมูลไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: "{{ route('orderhistory.store') }}", // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formDataArray.join('&'), // ข้อมูลที่จะส่ง
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        window.location.href = "{{ route('orderhistory.orderhistorys') }}";
                        alert('บันทึกข้อมูลการรับสินค้าเรียบร้อยแล้ว');
                        
                        // ลบข้อมูลหลังจากการบันทึกสำเร็จ
                        $.ajax({
                            url: "{{ route('receiveproduct.deleteAll') }}",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(deleteResponse) {
                                console.log(deleteResponse); // แสดงผลลัพธ์ในคอนโซล
                                alert('ข้อมูลถูกลบแล้ว'); // แสดง alert
                                location.reload(); // รีโหลดหน้าเพจใหม่
                            },
                            error: function(deleteError) {
                                console.error('Error:', deleteError);
                            }
                        });
                    },
                    error: function(error){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            // เมื่อคลิกที่ปุ่ม "เลือกทั้งหมด"
            $('#select-all-checkbox').click(function(){
                // เมื่อปุ่มถูกคลิก ตรวจสอบว่า checkbox ที่มี id เป็น "select-all-checkbox" ถูกเลือกหรือไม่
                var selectAllChecked = $('#select-all-checkbox').prop('checked');
                
                // หาก checkbox ถูกเลือก ให้เลือกทุก checkbox ที่มีชื่อเป็น "selected_products[]"
                if(selectAllChecked) {
                    $('input[name="selected_products[]"]').prop('checked', true);
                } else {
                    // ถ้า checkbox ไม่ถูกเลือก ให้ยกเลิกการเลือกทุก checkbox ที่มีชื่อเป็น "selected_products[]"
                    $('input[name="selected_products[]"]').prop('checked', false);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#cancel-button').click(function(event) {
                event.preventDefault();
                
                if (confirm('คุณต้องการยกเลิกรายการสินค้าทั้งหมดใช่หรือไม่?')) {
                    $.ajax({
                        url: "{{ route('receiveproduct.deleteAll') }}",
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response); // แสดงผลลัพธ์ในคอนโซล
                            alert(response.success); // แสดง alert จากการตอบสนอง JSON
                            window.location.reload(); // รีโหลดหน้าเพจใหม่
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });
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
                    url: "{{ route('receiveproduct.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('receiveproduct.receiveproducts') }}";
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
