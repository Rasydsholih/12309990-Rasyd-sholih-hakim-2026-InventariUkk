@extends('inventaris.app')

@section('content')
<style>
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
        display: block;
    }
    .input-error {
        border-color: #dc3545 !important;
        background-color: #fff5f5;
    }
    .error-alert {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 12px 20px;
        border-radius: 0.25rem;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="error-alert">
                    <strong>Validasi gagal!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- INPUT NAME -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') input-error @enderror"
                                placeholder="Enter category name"
                                value="{{ old('name', $category->name) }}">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- SELECT DIVISION -->
                        <div class="mb-3">
                            <label for="division" class="form-label">Divisi</label>
                            <select
                                name="division"
                                id="division"
                                class="form-select @error('division') input-error @enderror">
                                <option value="">Pilih Divisi PJ</option>
                                <option value="Sarpas" {{ old('division', $category->division) == 'Sarpas' ? 'selected' : '' }}>Sarpas</option>
                                <option value="Tata Usaha" {{ old('division', $category->division) == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                                <option value="Tefa" {{ old('division', $category->division) == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                            </select>
                            @error('division')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection