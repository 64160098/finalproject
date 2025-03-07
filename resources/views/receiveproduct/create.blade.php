<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('เลือกข้อมูลใบสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex justify-between items-center gap-4">
                                <p class="bread"><span><a href="{{ route('receiveproduct.receiveproducts') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>เลือกข้อมูลใบสั่งซื้อ</span></p>
                                <form method="GET" action="{{ route('receiveproduct.create') }}">
                                    <x-text-input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ค้นหา" value="{{ request('search') }}" />
                                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                                </form>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td width="8%" align="left" valign="middle"><strong>วันที่สั่ง</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>เลขที่ใบสั่งซื้อ</strong></td>
                                            <td width="8%" align="left" valign="middle"><strong>รหัสผู้ขาย</strong></td>
                                            <td width="10%" align="left" valign="middle"><strong>ผู้สั่งซื้อ</strong></td>
                                            <td colspan="3" width="15%" align="center" valign="middle"><strong>Action</strong></td>
                                        </tr>
                                
                                        @foreach($orders as $order)
                                        <tr>
                                            <td width="8%" align="left" valign="middle">{{ $order->order_date }}</td>
                                            <td width="10%" align="left" valign="middle">{{ $order->id }}</td>
                                            <td width="8%" align="left" valign="middle">{{ $order->supplier_id }}</td>
                                            <td width="10%" align="left" valign="middle">{{ $order->employee->employee_firstname }} {{ $order->employee->employee_lastname }}</td>
                                            <td width="5%" align="center" valign="middle">
                                                <a href="{{ route('receiveproduct.index', ['orderId' => $order->id]) }}">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg> เลือก
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ฟังก์ชัน JavaScript เพื่ออัปเดต action ของฟอร์มเมื่อมีการเลือก order ID
        function updateFormAction(select) {
            var form = select.form;
            form.action = "{{ url('receiveproduct') }}" + "/" + select.value + "/details";
        }
    </script>

</x-appadmin-layout>
