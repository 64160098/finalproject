<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    // Create Index
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $users = User::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $users = User::orderBy('id', 'asc')->paginate(5);
        }

        return view('user.users', ['users' => $users]);
    }

    // Create resource
    public function create() {
        return view('user.create');
    }

    //Store resource
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
              
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $request->password;
        $user->save();
        
        return redirect()->route('user.users')->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit(User $user) {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('user.users')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }   
    
    public function destroy(User $user) {
        $user->delete();
        return response()->json(['success' => 'ลบบัญชีผู้ใช้เรียบร้อยแล้ว'], 200);
    }
}
