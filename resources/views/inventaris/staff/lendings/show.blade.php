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
        top: 0; left: 0; right: 0; height: 100%;
        background: rgba(0,0,0,0.4);
    }
    .header-content { position: relative; z-index: 2; }

    
    .info-card {
        margin-top: -30px;
        background: white;
        border-radius: 5px;
        padding: 15px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        z-index: 3;
    }

    
    .table-data {
        margin-top: 20px;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }
    .table thead th {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding-bottom: 20px;
    }
    .table tbody td {
        padding: 20px 0;
        vertical-align: middle;
        border-top: 1px solid #f8f9fa;
    }
    .status-not-returned {
        border: 1px solid #ffeeba;
        color: #ffc107;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    .status-returned {
        border: 1px solid #c3e6cb;
        color: #28a745;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>

<div class="header">
    <div class="header-overlay"></div>
    <div class="header-content d-flex align-items-center gap-3">
        <img src="{{ asset('storage/assets/images/wk-icon.png') }}" alt="Logo" width="45">
        <h5 class="mb-0 fw-semibold">Welcome Back, {{ auth()->user()->role }} - {{ auth()->user()->name }}</h5>
        <div class="ms-auto fw-semibold">14 January, 2023</div>
    </div>
</div>

<div class="container mt-4">
    <div class="info-card d-flex justify-content-between align-items-center">
        <span class="fw-medium text-muted">Check menu in sidebar</span>
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <span class="fw-bold">{{ auth()->user()->name }}</span>
            <i class="bi bi-chevron-down ms-2"></i>
        </div>
    </div>

    <div class="table-data">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 fw-bold">Lending Table</h4>
                <span class="text-muted">Data of <span class="text-danger">.lendings</span></span>
            </div>
            <a href="{{ route('items.index') }}" class="btn btn-secondary px-4">Back</a>
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
                </tr>
            </thead>
            <tbody>
                @forelse($item->lendings as $index => $lending)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $item->name }}</td>
                    <td>{{ $lending->total }}</td>
                    <td>{{ $lending->name }}</td>
                    <td>{{ $lending->keterangan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}</td>
                    <td>
                        @if($lending->returned)
                            <span class="status-returned">
                                {{ \Carbon\Carbon::parse($lending->returned_date)->format('d F, Y') }}
                            </span>
                        @else
                            <span class="status-not-returned">not returned</span>
                        @endif
                    </td>
                    <td class="fw-bold text-dark">{{ $lending->edited_by }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No lending records found for this item.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection