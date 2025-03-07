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
                                <p>$$ROP = D \times L + SS$$</p>

                            <p>โดยที่:</p>
                            <br>
                            <p><strong>ROP</strong> คือจุดที่ต้องสั่งซื้อสินค้าใหม่</p>
                            <br>
                            <p><strong>𝐷</strong> คืออัตราการใช้งานต่อวัน (Daily Usage Rate)</p>
                            <br>
                            <p><strong>𝐿</strong> คือระยะเวลาในการสั่งซื้อและได้รับสินค้าสำเร็จ (Lead Time in Days)</p>
                            <br>
                            <p><strong>S</strong> คือปริมาณสินค้าสำรอง (Safety Stock)</p>
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
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า SS (Safety Stock)</strong></h3>
                            <p>ปริมาณสินค้าสำรอง คือ ปริมาณสินค้าที่เก็บสำรองไว้ในสต็อกเพิ่มเติมจากความต้องการปกติ เพื่อรองรับความไม่แน่นอนต่าง ๆ ที่อาจเกิดขึ้น เช่น ความผันผวนของอุปสงค์ ระยะเวลารอคอยสินค้าที่นานกว่าปกติ หรือปัญหาอื่น ๆ ที่อาจทำให้สินค้าหมดก่อนที่จะได้รับการจัดส่งครั้งใหม่</p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ:</strong></p><br><p>สมการ Safety Stock คือ:</p>
                            <br>
                            <p>$$SS = Z \times \sigma_d \times \sqrt{L}$$</p>
                            <br>
                            <p>โดยที่:</p>
                            <br>
                            <p><strong>SS</strong> คือสินค้าสำรอง</p>
                            <br>
                            <p><strong>Z</strong> คือค่า Z-score ซึ่งขึ้นอยู่กับระดับความต้องการบริการ (Service Level)</p>
                            <br>
                            <p><strong>***การหาค่า Z-score</strong> ค่า Z-score สามารถหาได้จาก ตาราง Z (Z-table) ซึ่งเป็นตารางที่ใช้ในสถิติเพื่อหาโอกาสในกรณีที่การกระจายตัวของข้อมูลเป็นการแจกแจงปกติ โดยที่ระดับการให้บริการ (Service Level) ที่ต้องการจะกำหนดว่าค่า Z จะเป็นเท่าไหร่</p>
                            <br>
                            <p><strong>ตัวอย่างค่า Z-score ที่นิยมใช้</strong></p>
                            <br>
                            <p>Service Level 90% → Z ≈ 1.28</p>
                            <p>Service Level 95% → Z ≈ 1.65</p>
                            <p>Service Level 99% → Z ≈ 2.33</p>
                            <br>
                            <p><strong>σd</strong> คือส่วนเบี่ยงเบนมาตรฐานของความต้องการ (Standard deviation of demand)</p>
                            <br>
                            <p><strong>***การหาค่าส่วนเบี่ยงเบนมาตรฐาน (σd)</strong></p>
                            <br>
                            <p><p>$$\sigma_d = \sqrt{\frac{\sum (X - \text{Average Demand})^2}{n}}$$</p></p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ</strong></p>
                            <br>
                            <p><strong>1. ข้อมูลความต้องการสินค้าใน 5 วัน</strong></p>
                            <br>
                            <p>วัน 1: 50 หน่วย</p>
                            <br>
                            <p>วัน 2: 55 หน่วย</p>
                            <br>
                            <p>วัน 3: 45 หน่วย</p>
                            <br>
                            <p>วัน 4: 60 หน่วย</p>
                            <br>
                            <p>วัน 5: 50 หน่วย</p>
                            <br>
                            <br>
                            <p><strong>2. คำนวณค่าเฉลี่ย (Average Demand)</strong></p>
                            <br>
                            <p>$$\text{Average Demand} = \frac{50 + 55 + 45 + 60 + 50}{5} = \frac{260}{5} = 52 \text{ หน่วย}$$</p>
                            <br>
                            <p><strong>3. คำนวณผลต่างจากค่าเฉลี่ย (Deviation)</strong></p>
                            <br>
                            <p>วัน 1: 50 - 52 = -2</p>
                            <br>
                            <p>วัน 2: 55 - 52 = 3</p>
                            <br>
                            <p>วัน 3: 45 - 52 = -7</p>
                            <br>
                            <p>วัน 4: 60 - 52 = 8</p>
                            <br>
                            <p>วัน 5: 50 - 52 = -2</p>
                            <br>
                            <p><strong>4. ยกกำลังสองของผลต่าง</strong></p>
                            <br>
                            <p>วัน 1: (-2)<sup>2</sup> = 4</p>
                            <br>
                            <p>วัน 2: 3<sup>2</sup> = 9</p>
                            <br>
                            <p>วัน 3: (-7)<sup>2</sup> = 49</p>
                            <br>
                            <p>วัน 4: 8<sup>2</sup> = 64</p>
                            <br>
                            <p>วัน 5: (-2)<sup>2</sup> = 4</p>
                            <br>
                            <p><strong>5. หาค่าเฉลี่ยของผลต่างยกกำลังสอง (Variance)</strong></p>
                            <br>
                            <p>$$\text{Variance} = \frac{4 + 9 + 49 + 64 + 4}{5} = \frac{130}{5} = 26$$</p>
                            <br>
                            <p><strong>6. หาค่ารากที่สองของค่าเฉลี่ย (Standard Deviation)</strong></p>
                            <br>
                            <p>$$\sigma_d = 26 \approx 5.10$$</p>
                            <br>
                            <p><strong>L</strong> คือระยะเวลาในการจัดส่ง (Lead Time)</p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณสินค้าสำรอง</strong></p>
                            <br>
                            <p>$$SS = 1.28 \times 5.10 \times \sqrt{2} \approx 1.28 \times 5.10 \times 1.414 \approx 8.98$$</p>
                            <br>
                            <p><strong>ดังนั้น</strong> สินค้าสำรอง (Safety Stock, SS) ที่คำนวณได้ในกรณีนี้คือประมาณ 8.98 หน่วย</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>ตัวอย่างการคำนวณ ROP</strong></h3>
                            <p>$$ROP = D \times L + SS$$</p>
                            <p>ใช้ข้อมูลจากข้างต้น:</p><br><p>Daily Usage Rate (𝐷) = 33 หน่วย</p><br><p>Lead Time (𝐿) = 10 วัน</p><br><p>Safety Stock (SS) = 8.98 หน่วย</p>
                            <p>$$ROP = 33 \times 10 + 8.98$$</p>

                            <p>$$ROP = 338.98$$</p>

                            <p>ดังนั้น: คุณควรสั่งซื้อสินค้าใหม่เมื่อสต็อกสินค้าถึง 338.98 หน่วย</p>
                           
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
