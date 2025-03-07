<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('สินค้าคงคลัง') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end">
                <form method="GET" action="{{ route('inventory.inventories') }}" class="flex items-center">
                    <x-text-input type="text" name="search" id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" style="margin-right: 10px;" placeholder="ค้นหา" value="{{ request('search') }}" />
                    <x-primary-button type="submit">ค้นหา</x-primary-button>
                </form>
            </div>
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
                                <tbody>
                                    <tr>
                                        <td width="5%" align="left" valign="middle"><strong>รหัส</strong></td>
                                        <td width="16%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="6%" align="left" valign="middle"><strong>ประเภท</strong></td>
                                        <td width="6%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                        <td width="7%" align="left" valign="middle"><strong>ขนาด</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>จำนวน</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>ราคารวม</strong></td>
                                        <td width="10%" align="center" valign="middle"><strong>Action</strong></td>
                                    </tr>
                            
                                    @foreach ($inventories as $inventory)
                                    <tr>
                                        <td width="5%" align="left" valign="middle">{{ $inventory->product_id  }}</td>
                                        <td width="16%" align="left" valign="middle">{{ $inventory->product->product_name }}</td>
                                        <td width="6%" align="left" valign="middle">{{ $inventory->product->productType->product_type }}</td>
                                        <td width="6%" align="left" valign="middle">{{ $inventory->product->productUnit->unit }}</td>
                                        <td width="7%" align="left" valign="middle">{{ $inventory->product->product_width }}×{{ $inventory->product->product_length }}×{{ $inventory->product->product_height }}</td>
                                        <td width="5%" align="left" valign="middle">{{ $inventory->product->price }}</td>
                                        <td width="5%" align="left" valign="middle">{{ $inventory->amount > 0 ? $inventory->amount : '-' }}</td>
                                        <td width="5%" align="left" valign="middle">
                                            <span class="total-price" data-price="{{ $inventory->product->price }}" data-quantity="{{ $inventory->amount }}">
                                                {{ $inventory->amount > 0 ? $inventory->product->price * $inventory->amount : '-' }}
                                            </span>
                                        </td>
                                        <td width="10%" align="center" valign="middle">
                                            @if($inventory && $inventory->amount > 0)
                                                <a href="{{ route('inventory.edit', $inventory->id) }}">
                                                    <x-primary-button class="flex items-center space-x-2" style="margin-right: 10px; background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">
                                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                        </svg>แก้ไข
                                                    </x-primary-button> 
                                                </a>
                                            @else
                                                <a href="" onclick="alert('สินค้านี้ยังไม่ได้มีการรับเข้ามา ไม่สามารถแก้ไขได้'); return false;">
                                                    <x-primary-button class="flex items-center space-x-2" style="margin-right: 10px; background-color: #FFA500; color: white; text-shadow: 1px 1px 2px black;">
                                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                        </svg>แก้ไข
                                                    </x-primary-button> 
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $inventories->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceElements = document.querySelectorAll('.total-price');

            priceElements.forEach(element => {
                const price = parseFloat(element.getAttribute('data-price'));
                const quantity = parseInt(element.getAttribute('data-quantity'), 10);

                if (!isNaN(price) && !isNaN(quantity)) {
                    const totalPrice = price * quantity;
                    element.textContent = totalPrice.toFixed(2);
                }
            });
        });
    </script>
</x-appadmin-layout>
