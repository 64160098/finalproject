<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('สรุปรายงานการขาย') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <p class="bread">
                            <span>
                                <a href="{{ route('productsalereport.productsalehistorys') }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">หน้าหลัก</a>
                            </span>
                            / 
                            <span>สรุปรายงานการขาย</span>
                        </p>
                    </div>
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <form method="GET" action="{{ route('productsalereport.monthlyproductsales') }}">
                                <div class="flex items-center">
                                    <div class="flex items-center space-x-2" style="margin-right: 20px;">
                                        <label for="year" class="mb-1">ปี:</label>
                                        <select id="year" name="year" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                            dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 100px;" onchange="this.form.submit()">
                                            @for ($i = 2019; $i <= \Carbon\Carbon::now()->year; $i++)
                                                <option value="{{ $i }}" {{ request('year', \Carbon\Carbon::now()->year) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label for="month">เดือน:</label>
                                        <select id="month" name="month" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                            dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 150px;">
                                            @foreach ($thaiMonths as $num => $name)
                                                <option value="{{ $num }}" {{ request('month', \Carbon\Carbon::now()->month) == $num ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="margin-top: 20px;">
                                    <x-primary-button type="submit" class="btn btn-primary">แสดงรายงาน</x-primary-button>
                                </div>
                            </form>

                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            
                            <!-- Display selected month and year -->
                            <h3 class="text-xl mb-4"><strong>รายละเอียดรายปี</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>ปี:</strong> 
                                    <span style="margin-left: 5px;">
                                        {{ $year }}
                                    </span>
                                </div>
                            </div>

                            <hr class="my-4 border-gray-300 dark:border-gray-700">

                            <!-- ตารางสรุปรายปี -->
                            <h3 class="text-l mb-4"><strong>รายการสินค้าที่ขายรายปี</strong></h3>
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td><strong>รหัสสินค้า</strong></td>
                                        <td><strong>ชื่อสินค้า</strong></td>
                                        <td><strong>จำนวน</strong></td>
                                        <td><strong>หน่วยนับ</strong></td>
                                        <td><strong>ราคา</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($finalYearlySalesData as $details)
                                        <tr>
                                            <td>{{ $details['product_id'] }}</td>
                                            <td>{{ $details['product_name'] }}</td>
                                            <td>{{ $details['quantity'] }}</td>
                                            <td>{{ $details['unit'] }}</td>
                                            <td>{{ number_format($details['total_sales'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex items-center">
                                <strong>จำนวนสินค้าทั้งหมด:</strong> 
                                <span style="margin-left: 5px;">
                                    {{ $finalYearlySalesData->sum('quantity') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <strong>ราคารวม:</strong> 
                                <span style="margin-left: 5px;">
                                    {{ number_format($finalYearlySalesData->sum('total_sales'), 2) }} บาท
                                </span>
                            </div>

                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            
                            <!-- Display selected month and year -->
                            <h3 class="text-xl mb-4"><strong>รายละเอียดรายเดือน</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>เดือน:</strong> 
                                    <span style="margin-left: 5px; margin-right: 10px;">
                                        {{ $thaiMonths[$month] ?? '' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <strong>ปี:</strong> 
                                    <span style="margin-left: 5px;">
                                        {{ $year }}
                                    </span>
                                </div>
                            </div>
                            
                            <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                            
                            <!-- ตารางสรุปรายเดือน -->
                            <h3 class="text-l mb-4"><strong>รายการสินค้าที่ขายรายเดือน</strong></h3>
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td><strong>รหัสสินค้า</strong></td>
                                        <td><strong>ชื่อสินค้า</strong></td>
                                        <td><strong>จำนวน</strong></td>
                                        <td><strong>หน่วยนับ</strong></td>
                                        <td><strong>ราคา</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($finalMonthlySalesData as $details)
                                        <tr>
                                            <td>{{ $details['product_id'] }}</td>
                                            <td>{{ $details['product_name'] }}</td>
                                            <td>{{ $details['quantity'] }}</td>
                                            <td>{{ $details['unit'] }}</td>
                                            <td>{{ number_format($details['total_sales'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex items-center">
                                <strong>จำนวนสินค้าทั้งหมด:</strong> 
                                <span style="margin-left: 5px;">
                                    {{ $finalMonthlySalesData->sum('quantity') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <strong>ราคารวม:</strong> 
                                <span style="margin-left: 5px;">
                                    {{ number_format($finalMonthlySalesData->sum('total_sales'), 2) }} บาท
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</x-appadmin-layout>
