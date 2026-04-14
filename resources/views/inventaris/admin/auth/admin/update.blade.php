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

            {{-- ALERT ERROR --}}
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
                    <h4 class="mb-0">Edit Account Form</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control @error('name') input-error @enderror"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control @error('email') input-error @enderror"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select @error('role') input-error @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PASSWORD OPTIONAL --}}
                        <div class="mb-3">
                            <label class="form-label">
                                New Password <small class="text-warning">optional</small>
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control @error('password') input-error @enderror"
                                placeholder="Kosongkan jika tidak ingin mengubah password">
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection