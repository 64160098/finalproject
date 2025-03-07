<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @font-face {
            font-family: 'THSarabun';
            src: url('{{ public_path('fonts/THSarabun-Regular.ttf') }}');
            font-weight: normal;
        }
        @font-face {
            font-family: 'THSarabun';
            src: url('{{ public_path('fonts/THSarabun-Bold.ttf') }}');
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .company-name {
            font-size: 32px;
            font-weight: 900;
            text-align: center;
            line-height: 0.8;
        }
        .company-details, .project-details {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .purchase-order {
            font-size: 32px;
            text-align: center;
            vertical-align: middle;
            height: 20px; /* ลดความสูงกรอบ */
            border: 1px solid black; /* เพิ่มเส้นกรอบสีดำ */
            line-height: 20px; /* ปรับความสูงของบรรทัดเพื่อให้ตรงกลาง */
        }
        .supplier-detail {
            font-size: 18px;
            margin-top: 40px;
            padding: 0px 5px 5px; /* ลดค่า padding ด้านบนให้เป็น 0 */
            border: 1px solid black;
            width: 60%; /* เพิ่มความกว้างของกรอบ */
            text-align: left;
        }
        .detail-item {
            border: 1px solid black; /* เส้นกรอบสีดำสำหรับแต่ละ div */
            padding: 2px; /* ระยะห่างภายในสำหรับ div */
            margin: 0; /* ลบ margin ทั้งหมดออกเพื่อให้กรอบชิดกัน */
            border-bottom: none; /* ลบเส้นขอบด้านล่างสำหรับ div แต่ละอัน (ยกเว้นอันสุดท้าย) */
        }

        .detail-item:last-child {
            border-bottom: 1px solid black; /* คงเส้นขอบด้านล่างสำหรับ div สุดท้าย */
        }
        .section {
             /* เส้นกรอบสีดำรอบตาราง */
            border-collapse: collapse; /* รวมเส้นกรอบให้แนบกัน */
        }

        th {
            border: 1px solid black; /* เส้นกรอบสีดำสำหรับแต่ละหัวข้อ */
            background-color: white; /* สีพื้นหลังของหัวข้อ */
            color: black; /* สีตัวหนังสือ */
            text-align: center; /* จัดตำแหน่งตัวหนังสือไปที่กลาง */
            padding: 2px; /* ระยะห่างภายใน */
        }

        td {
            border: 1px solid black; /* เส้นกรอบสีดำสำหรับเซลล์ */
            background-color: white; /* สีพื้นหลังของเซลล์ */
            text-align: center; /* จัดตำแหน่งตัวหนังสือไปที่กลาง */
            padding: 10px; /* ระยะห่างภายใน */
        }
        .narrow {
            width: 50px; /* กำหนดความกว้างให้ช่องลำดับ */
        }
        .wide {
            width: 220px; /* กำหนดความกว้างให้ช่องรายการ */
        }
        .qty {
            width: 60px; /* กำหนดความกว้างให้ช่องรายการ */
        }
        .per {
            width: 90px; /* กำหนดความกว้างให้ช่องรายการ */
        }
        .price {
            width: 150px; /* กำหนดความกว้างให้ช่องรายการ */
        }
        .product-detail {
            border-collapse: collapse; /* ให้เส้นขอบรวมกัน */
        }
        .product-detail td {
            border-top: none; /* ลบเส้นขอบด้านบนของ td */
            border-bottom: none; /* ลบเส้นขอบด้านล่างของ td */
            padding: 5px; /* กำหนดระยะห่างภายในเซลล์ */
        }
        /* เส้นขอบแนวตั้งสำหรับ td */
        .product-detail td:first-child {
            border-left: 1px solid black; /* เส้นขอบด้านซ้าย */
        }
        .product-detail td:last-child {
            border-right: 1px solid black; /* เส้นขอบด้านขวา */
        }
        /* เส้นขอบแนวตั้งระหว่างเซลล์ */
        .product-detail td:not(:last-child) {
            border-right: 1px solid black; /* เส้นขอบด้านขวาของทุก td ยกเว้นตัวสุดท้าย */
        }
        /* คลาสสำหรับแถวรวมทั้งหมด */
        .total-row td {
            border-top: 1px solid black; /* เส้นขอบด้านบน */
            border-bottom: 1px solid black; /* เส้นขอบด้านล่าง */
            font-weight: bold; /* ตัวหนา */
        }
        /* เซลล์ที่มีคลาส total-td2 */
        .total-td2 {
            border-bottom: 1px solid black; /* เส้นขอบด้านล่าง */
            font-weight: bold; /* ตัวหนา */
        }
        /* ลบเส้นขอบสำหรับ td สองอันบน */
        .total-row td:first-child, .total-row td:nth-child(2) {
            border-top: none; /* ลบเส้นขอบทั้งหมด */
        }
    </style>
        </head>
        <body>
            <div class="company-name">
                บริษัท ตัวอย่าง จำกัด (ร้านค้าส่ง)<br>EXAMPLE WHOLESALE CO., LTD.
            </div>

            <div class="company-details">
                สำนักงานใหญ่ : 789 ถนนสุขสวัสดิ์ แขวงบางประกอก เขตราษฎร์บูรณะ กทม. 10140<br>
                Head Office: 789 Suksawat Road, Bang Pakok, Rat Burana, Bangkok 10140<br>
                โทร. 02-123-4567 | Fax. 02-123-4568 | เลขประจำตัวผู้เสียภาษี 1234567890123
            </div>

            <table>
                <tr>
                    <td class="purchase-order">ใบสั่งซื้อ</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="supplier-detail">
                        <span style="display: inline-block; width: 70px; vertical-align: top;">เรียน บริษัท:</span> <span>{{ $order->supplier->supplier_name }}</span><br>
                        <span style="display: inline-block; width: 70px; vertical-align: top;">ชื่อผู้ติดต่อ:</span> <span>{{ $order->supplier->supplier_customer_name }}</span><br>
                        <span style="display: inline-block; width: 70px; vertical-align: top;">เบอร์ติดต่อ:</span> <span>{{ $order->supplier->supplier_contact_number }}</span><br>
                        <span style="display: inline-block; width: 70px; vertical-align: top;">อีเมล:</span> <span>{{ $order->supplier->supplier_email }}</span><br>
                        <br>TAX ID. <span>0 1011 11111 11 1</span>
                    </td>                    
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">เลขที่ใบสั่งซื้อ:</span> <span>{{ $order->id }}</span>
                        </div>
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">วันที่สั่งซื้อ:</span> <span>{{ $order->order_date }}</span>
                        </div>
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">ผู้สั่งซื้อ:</span> <span>{{ $order->employee->employee_firstname }} {{ $order->employee->employee_lastname }}</span>
                        </div>                    
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">กำหนดส่งสินค้า:</span> <span>1 - 8 วัน ( นับจากได้รับใบสั่งซื้อ )</span>
                        </div>                    
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">เงื่อนไขการชำระเงิน:</span> <span>เงินสด</span>
                        </div>                    
                        <div class="detail-item">
                            <span style="display: inline-block; width: 90px; vertical-align: top;">ชื่อบัญชี:</span> <span>ตัวอย่าง จำกัด</span>
                        </div>                                    
                </tr>
            </table> 
            
            <table class="section">
                <thead>
                    <tr>
                        <th class="narrow">ลำดับ</th>
                        <th class="wide">รายการ</th>
                        <th class="qty">จำนวน</th>
                        <th class="qty">หน่วย</th>
                        <th class="per">ราคา/หน่วย</th>
                        <th class="price">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody class="product-detail">
                    @php
                        $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมเงิน
                    @endphp
                    @foreach ($orderedProducts as $index => $product)
                    @php
                        // ค้นหารายละเอียดของสินค้าจาก Product โดยใช้ id ของสินค้า
                        $productDetail = $products->firstWhere('id', $product['id']);
                        $price = $productDetail->price ?? 0; // ตรวจสอบว่ามีราคาหรือไม่
                        $quantity = $product['quantity'];
                        $total = $price * $quantity;
                        $unitName = $productDetail->productUnit->unit ?? 'N/A';
                
                        $totalAmount += $total; // เพิ่มยอดรวมเงิน
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $productDetail->product_name ?? 'N/A' }}</td> <!-- ตรวจสอบข้อมูลสินค้า -->
                        <td>{{ $quantity }}</td>
                        <td>{{ $unitName }}</td>
                        <td>{{ number_format($price, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($total, 2) }}</td> <!-- แสดงราคาต่อหน่วย -->
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td></td>
                        <td></td>
                        <td class="total-td2" colspan="3" style="text-align: left;">รวมเงิน</td>
                        <td style="text-align: right;">{{ number_format($totalAmount, 2) }}</td> <!-- แสดงผลรวมเงิน -->
                    </tr>
                    
                    @php
                        $vat = $totalAmount * 0.07; // คำนวณ VAT 7%
                        $grandTotal = $totalAmount + $vat; // คำนวณรวมทั้งสิ้น
                    @endphp
                    
                    <tr class="vat-row">
                        <td colspan="2" style="border-left: none;"></td> <!-- ไม่มีเส้นขอบ -->
                        <td class="vat-td2" colspan="3" style="text-align: left; border-bottom: 1px solid black;">ภาษีมูลค่าเพิ่ม VAT 7%</td>
                        <td style="text-align: right; border-bottom: 1px solid black;">{{ number_format($vat, 2) }}</td> <!-- แสดงผล VAT -->
                    </tr>                                     
                    <tr class="totally-row">
                        <td colspan="2" style="border-left: none;"></td> <!-- ไม่มีเส้นขอบ -->
                        <td class="vat-td2" colspan="3" style="text-align: left; border-bottom: 1px solid black;">รวมทั้งสิ้น</td>
                        <td style="text-align: right; border-bottom: 1px solid black;">{{ number_format($grandTotal, 2) }}</td> <!-- แสดงผลรวมทั้งสิ้น -->
                    </tr>                                     
                </tbody>                            
            </table>
        
            <table style="margin-top: 10px; margin-left: auto; margin-right: 0; width: 40%;">

                <tr>
                    <td style="font-size: 20px; padding-top: 1px;">ผู้จัดทำใบเสนอราคา<br>
                        ........................................................ <br>
                        (.......................................................)
                    </td>
                </tr>
            </table>

            <table style="position: absolute; bottom: 80; left: 0; width: 100%;">
                <tr>
                    <td style="text-align: left; vertical-align: top; padding-top: 0;">
                        กรณีสั่งซื้อ กรุณาลงนามยืนยันการสั่งซื้อสินค้าด้านล่างนี้ หรือส่งใบสั่งซื้อของหน่วยงานท่านมาที่เลขหมายโทรสาร เลขหมายโทรสาร 02-154-1287 <br>
                        <br>
                        ลงชื่อ ........................................................................................ ผู้มีอำนาจ
                    </td>                                   
                </tr>
            </table>
            
        </body>
        </html>
        
    </table>
</body>
</html>			