<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายงานการขายสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <p class="bread"><span><a href="{{ route('productsalereport.monthlyproductsales') }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">สรุปรายงานการขาย</a></span>
                            / <span>หน้าหลัก</span></p>
                        <form method="GET" action="{{ route('productsalereport.productsalehistorys') }}">
                            <x-text-input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหา" value="{{ request('search') }}" />
                            <x-primary-button type="submit">ค้นหา</x-primary-button>
                        </form>
                    </div>
                    <div class="container mt-2">
                        <div class="space-y-6">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>วันที่</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>รหัสผู้รายงาน</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อผู้รายงาน</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>รายได้รวม</strong></td>
                                        <td colspan="3" width="15%" align="center" valign="middle"><strong>Action</strong></td>
                                    </tr>
                            
                                    @foreach ($productsalehistorys as $productsalehistory)
                                    <tr>
                                        <td width="10%" align="left" valign="middle">{{ $productsalehistory->transaction_date }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $productsalehistory->employee_id  }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $productsalehistory->employee->employee_firstname  }} {{ $productsalehistory->employee->employee_lastname  }}</td>
                                        <td width="10%" align="left" valign="middle">{{ $productsalehistory->total_sales }} บาท</td>
                                        <td width="4%" align="center" valign="middle">
                                            <a href="{{ route('productsalereport.admin.detailproductsaleadmin', $productsalehistory->id) }}">
                                                <x-primary-button class="flex items-center space-x-2" style="margin-right: 10px; background-color: #1E90FF; color: white; text-shadow: 1px 1px 2px black;">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                                                    </svg> รายละเอียด
                                                </x-primary-button>  
                                            </a>
                                        </td> 
                                        <td width="1%" align="center" valign="middle">
                                            <a href="{{ route('productsalereport.adminedit', $productsalehistory->id) }}">
                                                <x-primary-button class="flex items-center space-x-2" style="margin-right: 10px; background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">
                                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                    </svg>แก้ไข
                                                </x-primary-button>  
                                            </a>
                                        </td>
                                        <td width="1%" align="center" valign="middle">
                                            <a href="#" class="delete-button" data-id="{{ $productsalehistory->id }}">
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
                            {!! $productsalehistorys->links() !!}
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
                    url: "{{ route('productsalereport.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('productsalereport.productsalehistorys') }}";
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
