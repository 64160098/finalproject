<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละอียดการใช้งาน Reorder Point (ROP)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread">
                                    <span>
                                        <a href="{{ route('product.createeoq') }}"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                ย้อนกลับ
                                        </a>
                                    </span> /
                                        <a href="{{ route('product.detail') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                            Economic Order Quantity (EOQ)
                                        </a>
                                    <span> /
                                        Reorder Point (ROP)
                                    </span>
                                </p> 
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display EOQ details -->
                            <h3 class="text-xl mb-4 mt-6"><strong>สมการ Reorder Point (ROP)</strong></h3>
                            <p>สมการของ ROP คือ:</p>

                                <!-- Display ROP equation -->
                                <p>$$ROP = D \times L$$</p>

                            <p>โดยที่:</p>
                            <br>
                            <p><strong>ROP</strong> คือจุดที่ต้องสั่งซื้อสินค้าใหม่</p>
                            <br>
                            <p><strong>𝐷</strong> คืออัตราการใช้งานต่อวัน (Daily Usage Rate)</p>
                            <br>
                            <p><strong>𝐿</strong> คือระยะเวลาในการสั่งซื้อและได้รับสินค้าสำเร็จ (Lead Time in Days)</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า D (Daily Usage Rate)</strong></h3>
                            <p>อัตราการใช้งานต่อวัน คือ จำนวนหน่วยสินค้าที่ใช้ในแต่ละวัน ซึ่งสามารถคำนวณได้จากข้อมูลยอดขายหรือการใช้งานจริง เช่น:</p>

                            <p>$$D = \frac{Total\ Annual\ Usage}{365}$$</p>

                            <p><span style="color: red;">**</span><strong>Total Annual Usage</strong> คือ จำนวนสินค้าที่ขายได้ทั้งหมดในปี (ไม่ใช่ยอดเงิน) เช่น หากขายได้ 12,000 หน่วยในปี 
                                <strong> Total Annual Usage </strong> คือ 12,000 หน่วย</p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ:</strong></p><br><p>หากยอดขายประจำปีของสินค้าคือ 12,000 หน่วย:</p>

                            <p>$$D = \frac{12{,}000}{365} \approx 32.88$$</p>
                            <br>
                            <p>ดังนั้น: อัตราการใช้งานต่อวันคือประมาณ 33 หน่วย</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า L (Lead Time)</strong></h3>
                            <p>ระยะเวลาในการสั่งซื้อและได้รับสินค้าสำเร็จ คือ จำนวนวันที่ใช้ในการรับสินค้าหลังจากทำการสั่งซื้อ ซึ่งอาจได้รับข้อมูลนี้จากซัพพลายเออร์ หรือประสบการณ์การสั่งซื้อในอดีต</p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ:</strong></p><br><p>หาก Lead Time คือ 10 วัน (ข้อมูลจากซัพพลายเออร์หรือประสบการณ์ที่ผ่านมา):</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>ตัวอย่างการคำนวณ ROP</strong></h3>
                            <p>$$ROP = D \times L$$</p>
                            <p>ใช้ข้อมูลจากข้างต้น:</p><br><p>Daily Usage Rate (𝐷) = 33 หน่วย</p><br><p>Lead Time (𝐿) = 10 วัน</p>
                            <p>$$ROP = 33 \times 10$$</p>

                            <p>$$ROP = 330$$</p>

                            <p>ดังนั้น: คุณควรสั่งซื้อสินค้าใหม่เมื่อสต็อกสินค้าถึง 330 หน่วย</p>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#submit-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
    
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
    
                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#id_error').hide().text('');
                $('#product_name_error').hide().text('');
    
                $.ajax({
                    url: '{{ route('product.store') }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('product.products') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.id) {
                                $('#id_error').show().text(errors.id[0]);
                            }
                            if (errors.product_name) {
                                $('#product_name_error').show().text(errors.product_name[0]);
                            }
                        } else {
                            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                        }
                    }
                });
            });
        });
    </script>   

</x-appadmin-layout>
