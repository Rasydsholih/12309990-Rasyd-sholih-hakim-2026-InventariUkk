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

    .info-card {
        margin-top: -30px;
        background: #e9ecef;
        border-radius: 5px;
        padding: 15px 20px;
    }

    .table-data {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table th {
        background-color: #f8f9fa;
    }
</style>

<!-- HEADER -->
<div class="header">
    <div class="header-overlay"></div>

    <div class="header-content d-flex align-items-center gap-3">
        <i class="bi bi-list menu-icon"></i>
        <img src="{{ asset('storage/assets/images/wk-icon.png') }}" width="50">

        <h5 class="mb-0 fw-semibold">
            Welcome Back, {{ auth()->user()->role }} - {{ auth()->user()->name }}
        </h5>

        <div class="date fw-semibold">
            {{ date('d F Y') }}
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-4">
    <div class="info-card d-flex justify-content-between align-items-center">
        <span class="fw-medium">Items data (view only)</span>

        <div>
            <i class="bi bi-person-circle"></i>
            {{ auth()->user()->name }}
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="table-data">
    <h4>Items Table</h4>
    <span>View items and availability</span>
    <div class="text-end">
        <a href="{{ route('items.export') }}" class="btn btn-sm btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Name Item</th>
                <th>Total</th>
                <th>Repair</th>
                <th>Available</th>
                <th>Lending</th>
            </tr>
        </thead>

        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ $item->category->name ?? 'N/A' }}
                        </span>
                    </td>

                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ $item->repair }}</td>

                    
                    <td>
                        <span class="badge bg-success">
                            {{ $item->total - $item->repair - ($item->lending_total ?? 0) }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($item->lending_count > 0)
                            <a href="{{ route('lendings.show', $item->id) }}" class="fw-bold text-primary">
                                {{ $item->lending_count }}
                            </a>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection