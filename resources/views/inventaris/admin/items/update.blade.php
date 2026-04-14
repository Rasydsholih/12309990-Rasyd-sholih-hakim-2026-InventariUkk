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
                    <h4 class="mb-0">Edit Item</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- SELECT CATEGORY -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="form-select @error('category_id') input-error @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- INPUT NAME -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Item Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') input-error @enderror"
                                placeholder="Enter item name"
                                value="{{ old('name', $item->name) }}">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- INPUT TOTAL -->
                        <div class="mb-3">
                            <label for="total" class="form-label">Total Quantity</label>
                            <input
                                type="number"
                                name="total"
                                id="total"
                                class="form-control @error('total') input-error @enderror"
                                placeholder="Enter total quantity"
                                value="{{ old('total', $item->total) }}"
                                min="0">
                            @error('total')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- INPUT REPAIR -->
                        <div class="mb-3">
                            <label for="repair" class="form-label">New broke item <span style="color: gold;">(Currently: {{ $item->repair }})</span></label>
                            <input
                                type="number"
                                name="repair"
                                id="repair"
                                class="form-control @error('repair') input-error @enderror"
                                placeholder="Enter repair quantity"
                                value="{{ old('repair', $item->repair) }}"
                                min="0">
                            @error('repair')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div id="repair-error" class="error-message" style="display: none;">Jumlah repair tidak boleh lebih dari total items.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning" id="submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalInput = document.getElementById('total');
        const repairInput = document.getElementById('repair');
        const repairError = document.getElementById('repair-error');
        const submitBtn = document.getElementById('submit-btn');

        function validateRepair() {
            const total = parseInt(totalInput.value) || 0;
            const repair = parseInt(repairInput.value) || 0;

            if (repair > total) {
                repairError.style.display = 'block';
                repairInput.classList.add('input-error');
                submitBtn.disabled = true;
            } else {
                repairError.style.display = 'none';
                repairInput.classList.remove('input-error');
                submitBtn.disabled = false;
            }
        }

        totalInput.addEventListener('input', validateRepair);
        repairInput.addEventListener('input', validateRepair);

        // Initial check
        validateRepair();
    });
</script>
@endsection