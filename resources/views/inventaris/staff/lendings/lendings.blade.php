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
        border-radius: 20px;
        overflow: hidden; 
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
    
    .info-card {
        margin-top: -30px;
        background: #e9ecef;
        border-radius: 5px;
        padding: 15px 20px;
    }
    
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

        <!-- LOGO -->
        <img src="{{ asset('storage/assets/images/wk-icon.png') }}" alt="Logo" width="50" class="mb-2">

        <!-- TEXT -->
        <h5 class="mb-0 fw-semibold">Welcome Back, {{ auth()->user()->role }} - {{ auth()->user()->name }}</h5>

        <!-- DATE -->
        <div class="date fw-semibold">
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-4">

    
    <div class="info-card d-flex justify-content-between align-items-center">

        <span class="fw-medium">Check menu in sidebar</span>

        
        <div class="profile-box" onclick="toggleDropdown()">
            <i class="bi bi-person-circle fs-4"></i>
            <span class="ms-2">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <i class="bi bi-chevron-down ms-1"></i>

            
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
    <h4>Lendings Table</h4>
    <span>Data Of .Lendings</span>
    <div class="text-end">
        <a href="{{ route('lendings.export') }}" class="btn btn-sm btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('lendings.create') }}" class="btn btn-sm btn-primary">Add</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Total</th>
                <th>Name</th>
                <th>Ket.</th>
                <th>Date</th>
                <th>Returned</th>
                <th>Edited By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lendings as $lending)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lending->item->name }}</td>
                    <td>{{ $lending->total }}</td>
                    <td>{{ $lending->name }}</td>
                    <td>{{ $lending->keterangan }}</td>
                    
                    <td>{{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}</td>
                    
                    <td>
                        @if($lending->returned)
                            <span style="border: 1px solid #20c997; color: #20c997; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($lending->returned_date)->format('d F, Y') }}
                            </span>
                        @else
                            <span style="border: 1px solid #ffc107; color: #ffc107; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                not returned
                            </span>
                        @endif
                    </td>
                    
                    <td>
                        {{ $lending->edited_by }}
                        
                        @if($lending->penerima)
                            <br>
                            <span class="badge bg-info text-dark mt-1">
                                Diterima oleh: {{ $lending->penerima }}
                            </span>
                        @endif
                    </td>
                    
                    <td>
                        @if(!$lending->returned)
                            <form action="{{ route('lendings.return', $lending->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-warning text-dark fw-medium" style="background-color: #ffc107; border: none; padding: 5px 15px;" onclick="return confirm('Konfirmasi pengembalian barang?')">
                                    Returned
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('lendings.destroy', $lending->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
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

    
    window.onclick = function(e) {
        if (!e.target.closest('.profile-box')) {
            document.getElementById("dropdownMenu").style.display = "none";
        }
    }
</script>




@endsection