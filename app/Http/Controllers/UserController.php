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

}