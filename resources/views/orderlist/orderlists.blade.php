<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายการสินค้าที่ต้องสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">                                                   
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                <thead>
                                    <tr>
                                        <td width="5%" align="left" valign="middle"><strong>รหัสสินค้า</strong></td>
                                        <td width="15%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>คลังสินค้า</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>จำนวนคงเหลือในคลัง</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>จุดสั่งซื้อใหม่ (ROP)</strong></td>
                                        <td width="10%" align="left" valign="middle"><strong>สถานะ</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orderlists as $orderlist)
                                    <tr>
                                        <td width="5%" align="left" valign="middle">{{ $orderlist->product_id }}</td>
                                        <td width="15%" align="left" valign="middle">{{ $orderlist->product_name }}</td> 
                                        <td width="10%" align="left" valign="middle">{{ $orderlist->warehouse_name }}</td> 
                                        <td width="10%" align="left" valign="middle">{{ $orderlist->amount }}</td>                              
                                        <td width="10%" align="left" valign="middle">{{ $orderlist->rop }}</td>
                                        <td width="10%" align="left" valign="middle">                       
                                            @if($orderlist->amount <= $orderlist->rop)
                                                <span class="badge bg-warning text-dark" style="color: red;">จำเป็นต้องสั่งซื้อเพิ่มเติม</span>
                                            @else
                                                <span class="badge bg-success" style="color: green;">เพียงพอ</span>
                                            @endif
                                        </td> 
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" align="center" style="height: 200px; font-size: 18px; font-weight: bold;">ไม่มีสินค้าที่ต้องสั่งซื้อใหม่</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>                                                                              
                            {!! $orderlists->links() !!}
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
        $('.delete-button').click(function(event){
            event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของปุ่ม

            // แสดงตัวยืนยันการลบ
            var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');
            
            // ถ้าผู้ใช้ยืนยันการลบ
            if (confirmDelete) {
                var productId = $(this).data('id');
                
                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: "{{ route('orderlist.destroy', ':id') }}".replace(':id', productId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('orderlist.orderlists') }}";
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
