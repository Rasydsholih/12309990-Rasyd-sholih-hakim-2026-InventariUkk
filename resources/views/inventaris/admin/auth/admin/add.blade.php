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
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Accounts Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" novalidate>
                        @csrf
                        
                        <!-- INPUT NAME -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') input-error @enderror" 
                                placeholder="Enter name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control @error('email') input-error @enderror" 
                                placeholder="Enter email"
                                value="{{ old('email') }}">
                            @error('division')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select 
                                name="role" 
                                id="role" 
                                class="form-select @error('role') input-error @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection