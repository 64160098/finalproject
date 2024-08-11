<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Superadmin;
use App\Models\User;

class SuperadminController extends Controller
{
    public function index()
    {
        // นับจำนวนสินค้าทั้งหมด
        $userCount = User::count();
    
        // ส่งข้อมูลไปยัง view
        return view('superadmin', [
            'userCount' => $userCount,
        ]);
    }
}
