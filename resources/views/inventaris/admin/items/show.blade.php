@extends('inventaris.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Item Details</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Item Information</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Item Name:</label>
                                <p class="form-control-plaintext">{{ $item->name }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-secondary">{{ $item->category->name ?? 'N/A' }}</span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Total Quantity:</label>
                                <p class="form-control-plaintext">{{ $item->total }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Timestamps</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Created At:</label>
                                <p class="form-control-plaintext">{{ $item->created_at->format('d M Y, H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated:</label>
                                <p class="form-control-plaintext">{{ $item->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>Edit Item
                        </a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline ms-2"
                              onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete Item
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection