<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appnormal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ยอดขายรายวัน') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div class="flex justify-between">
                                <a href="{{ route('dailysale.create') }}" class=""><x-primary-button>รายงานยอดขาย</x-primary-button></a>
                                <form method="GET" action="{{ route('dailysale.index') }}">
                                    <input type="date" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหารายการสั่งซื้อ" value="{{ request('search') }}">
                                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                                </form>
                            </div>
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('ประวัติการรายงานยอดขาย') }}
                            </h2>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table id="dailysaletable" width="100%" border="1" cellpadding="5" cellspacing="0">
                                <tbody><tr>
                                    <td width="20%" align="center" valign="middle"><strong>วันที่</strong></td>
                                    <td width="15%" align="center" valign="middle"><strong>รายได้ทั้งหมด</strong></td>
                                    <td width="15%" align="center" valign="middle"><strong>ยอดโอน</strong></td>
                                    <td width="15%" align="center" valign="middle"><strong>เงินสด</strong></td>
                                    <td width="15%" align="center" valign="middle"><strong>ผู้รายงาน</strong></td>
                                    <td width="12%" align="center" valign="middle"><strong>แก้ไข</strong></td>
                                    <td width="9%" align="center" valign="middle"><strong>ลบ</strong></td>
                                </tr>
                                
                                @foreach ($dailysales as $dailysale)
                                 <tr>
                                    <td width="15%" align="center" valign="middle">{{ $dailysale->sale_date ? \Carbon\Carbon::parse($dailysale->sale_date)->translatedFormat('d M Y') : '' }}</td>
                                    <td width="15%" align="center" valign="middle">{{ $dailysale->total_earning }}</td>
                                    <td width="15%" align="center" valign="middle">{{ $dailysale->Scan_to_pay }}</td>
                                    <td width="15%" align="center" valign="middle">{{ $dailysale->cash }}</td>
                                    <td width="15%" align="center" valign="middle">{{ $dailysale->reporter_name }}</td>
                                    <td width="12%" align="center" valign="middle">
                                        <a href="{{ route('dailysale.edit', $dailysale->id) }}">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                            </svg>แก้ไข
                                        </a> 
                                    </td>
                                    <td width="9%" align="center" valign="middle"> 
                                        <a href="#" class="delete-button" data-id="{{ $dailysale->id }}">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                            </svg>ลบ
                                        </a>
                                    </td>
                                </tr>                 
                              </tbody>
                              @endforeach
                            </table>
                            {!! $dailysales->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let table = new DataTable('#dailysaletable');
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
                    url: "{{ route('dailysale.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('dailysale.dailysales') }}";
                    },
                    error: function(xhr){
                        console.error('Error:', xhr);
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    }
                });
            }
        });
    </script>

</x-appnormal-layout>
