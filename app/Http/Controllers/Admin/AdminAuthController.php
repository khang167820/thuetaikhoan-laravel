<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (session('admin_logged_in') === true) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }
    
    /**
     * Handle admin login
     * Check against `admin` table (same as legacy PHP)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        // Query admin table (same as legacy)
        $admin = DB::table('admin')
            ->where('username', $request->username)
            ->first();
        
        if (!$admin) {
            return back()->withErrors(['username' => 'Tên đăng nhập không tồn tại.'])->withInput();
        }
        
        // Try password_verify (bcrypt)
        $passwordValid = false;
        
        if (password_verify($request->password, $admin->password)) {
            $passwordValid = true;
        }
        // Fallback: direct comparison (plain text)
        elseif ($request->password === $admin->password) {
            $passwordValid = true;
        }
        
        if (!$passwordValid) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng.'])->withInput();
        }
        
        // Login successful - set session
        session([
            'admin_logged_in' => true,
            'admin_id' => $admin->id,
            'admin_username' => $admin->username,
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
    }
    
    /**
     * Handle admin logout
     */
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_username']);
        
        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất!');
    }
    
    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        
        $adminId = session('admin_id');
        $admin = DB::table('admin')->where('id', $adminId)->first();
        
        if (!$admin) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản admin.']);
        }
        
        // Verify current password
        if (!password_verify($request->current_password, $admin->password) && $request->current_password !== $admin->password) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
        
        // Update with new bcrypt hash
        DB::table('admin')
            ->where('id', $adminId)
            ->update(['password' => Hash::make($request->new_password)]);
        
        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
