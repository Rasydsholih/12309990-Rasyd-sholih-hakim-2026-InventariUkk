<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    // Menerima parameter role dari Controller
    public function __construct($role = null)
    {
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Filter berdasarkan role (misal: admin saja atau operator saja)
        if ($this->role) {
            return User::where('role', $this->role)->get();
        }
        
        return User::all();
    }

    /**
     * Menentukan judul kolom di baris pertama Excel
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password'
        ];
    }

    /**
     * Memetakan data user ke masing-masing kolom beserta logika password
     */
    public function map($user): array
    {
        $first4 = substr($user->email, 0, 4);
        $defaultPassword = $first4 . $user->id;

        // Logika pengecekan password dikembalikan seperti semula
        if (Hash::check($defaultPassword, $user->password)) {
            $passwordText = $defaultPassword;
        } elseif (Hash::check($user->password, $user->password)) {
            $passwordText = $user->password;  
        } else {
            $passwordText = 'This account already edited the password';
        }

        return [
            $user->name,
            $user->email,
            $passwordText
        ];
    }
}