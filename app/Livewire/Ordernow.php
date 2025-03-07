<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class Ordernow extends Component
{
    public $orderNumber;

    public function mount()
    {
        // สร้างเลขที่ใบสั่งซื้อใหม่เมื่อคอมโพเนนต์เริ่มทำงาน
        $this->generateOrderNumber();
    }

    public function generateOrderNumber()
    {
        // สร้างเลขที่ใบสั่งซื้อใหม่ที่นี่
        // ตัวอย่าง: ใช้เวลาปัจจุบันเป็นพื้นฐาน
        $this->orderNumber = 'ORD-' . date('YmdHis');
    }

    public function submit()
    {
        // เก็บเลขที่ใบสั่งซื้อใน session หรือทำการบันทึก
        session(['order_number' => $this->orderNumber]);

        // นำทางไปยังหน้าถัดไป
        return redirect()->route('ordernow.createstep1');
    }

    public function render()
    {
        return view('livewire.ordernow');
    }
}
