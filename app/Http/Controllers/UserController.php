<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
class UserController extends Controller
{
    public function index()
    {
        
        $currentUserRole = auth()->user()->role;
        $users = User::where('role', 'admin')->get();
        return view('inventaris.admin.auth.admin.authadmin', compact('users', 'currentUserRole'));
    }
    public function authoperator()
    {
        $currentUserRole = auth()->user()->role;
        $users = User::where('role', 'operator')->get();
        return view('inventaris.admin.auth.operator.authoperator', compact('users', 'currentUserRole'));
    }

    private function redirectByRole()
    {
        $role = auth()->user()->role;
        if ($role == 'admin') {
            return redirect()->route('users.index');
        } else if ($role == 'operator') {
            return redirect()->route('users.authoperator');
        }
        return redirect()->back();
    }
    
    public function create()
    {
        
        return view('inventaris.admin.auth.admin.add');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,operator',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'The role field is required.',
            'role.in' => 'The selected role is invalid.',
        ]);
        $first4 = substr($request->email, 0, 4);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => '', 
        ]);
        $passwordPlain = $first4 . $user->id;
        $user->password = bcrypt($passwordPlain);
        $user->save();
        return $this->redirectByRole()->with('success', 'User berhasil dibuat')->with('password', $passwordPlain);
    }
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('inventaris.admin.auth.admin.update', compact('user'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,operator',
            'password' => 'nullable|min:6',
        ]);
        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        return redirect()->route('inventaris.index')->with('success', 'User berhasil diupdate');
    }
    public function resetPassword(User $user)
    {
        $first4 = substr($user->email, 0, 4);
        $newPassword = $first4 . $user->id;
        $user->password = bcrypt($newPassword);
        $user->save();
        return $this->redirectByRole()->with('success', 'Password berhasil direset')->with('password', $newPassword);
    }
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->redirectByRole()->with('success', 'User berhasil dihapus');
    }

    public function exportExcel(Request $request) 
    {
        $role = $request->query('role'); 
        $fileName = $role ? 'Data_Akun_' . ucfirst($role) . '.xlsx' : 'Data_Semua_Akun.xlsx';
        return Excel::download(new UserExport($role), $fileName);
    }
}