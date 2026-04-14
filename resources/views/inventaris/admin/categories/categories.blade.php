@extends('inventaris.app')

@section('content')

<style>

    .header {
        background: url('{{ asset("storage/assets/images/bgDashboard.jpg") }}') no-repeat center center;
        background-size: cover;
        height: 180px;
        position: relative;
        color: white;
        padding: 20px;
        border-radius: 20px; /* tambahkan ini */
        overflow: hidden; /* penting biar gambar ikut radius */
    }

    .header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: rgba(0,0,0,0.4);
    }
    .header-content {
        position: relative;
        z-index: 2;
    }
    .logo {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }
    .menu-icon {
        font-size: 22px;
        cursor: pointer;
    }
    .date {
        position: absolute;
        right: 20px;
        top: 20px;
    }
    /* CARD INFO */
    .info-card {
        margin-top: -30px;
        background: #e9ecef;
        border-radius: 5px;
        padding: 15px 20px;
    }
    /* PROFILE DROPDOWN */
    .profile-box {
        position: relative;
        cursor: pointer;
    }
    .dropdown-custom {
        position: absolute;
        right: 0;
        top: 60px;
        background: white;
        border-radius: 6px;
        width: 180px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        display: none;
    }
    .dropdown-custom a {
        display: block;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
    }
    .dropdown-custom a:hover {
        background: #f1f1f1;
    }
    /* TABLE STYLES */
    .table-data {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
    }
    .table tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-data .btn {
        margin-bottom: 15px;
    }
</style>


<!-- HEADER -->
<div class="header">
    <div class="header-overlay"></div>

    <div class="header-content d-flex align-items-center gap-3">
        <!-- MENU ICON -->
        <i class="bi bi-list menu-icon"></i>

        <!-- LOGO (GANTI SENDIRI) -->
        <img src="{{ asset('storage/assets/images/wk-icon.png') }}" alt="Logo" width="50" class="mb-2">

        <!-- TEXT -->
        <h5 class="mb-0 fw-semibold">Welcome Back, {{ auth()->user()->role }} - {{ auth()->user()->name }}</h5>

        <!-- DATE -->
        <div class="date fw-semibold">
            14 January, 2023
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-4">

    <!-- INFO CARD -->
    <div class="info-card d-flex justify-content-between align-items-center">

        <span class="fw-medium">Check menu in sidebar</span>

        <!-- PROFILE -->
        <div class="profile-box" onclick="toggleDropdown()">
            <i class="bi bi-person-circle fs-4"></i>
            <span class="ms-2">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <i class="bi bi-chevron-down ms-1"></i>

            <!-- DROPDOWN -->
            <div class="dropdown-custom" id="dropdownMenu">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer; padding: 12px 15px; color: #333;">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="table-data">
    <h4>Categores Table</h4>
    <span>Add,delete,update .Categories</span>
    <div class="text-end">
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Add</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Division PJ</th>
                <th>Total Items</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->division }}</td>
                <td>{{ $category->total_items }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                    <!-- <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown() {
        let dropdown = document.getElementById("dropdownMenu");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    // klik luar = tutup dropdown
    window.onclick = function(e) {
        if (!e.target.closest('.profile-box')) {
            document.getElementById("dropdownMenu").style.display = "none";
        }
    }
</script>




@endsection