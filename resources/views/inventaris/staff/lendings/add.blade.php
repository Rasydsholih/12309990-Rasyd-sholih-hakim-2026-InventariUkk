@extends('inventaris.app')

@section('content')
<style>
    /* Styling Dasar Form Minimalis */
    .form-wrapper {
        background-color: #ffffff;
        padding: 30px 40px;
        border-radius: 10px;
        max-width: 800px;
        margin: auto;
    }

    .form-title {
        color: #2b3643;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 5px;
    }

    .form-subtitle {
        color: #8f9bb3;
        font-size: 0.85rem;
        margin-bottom: 30px;
    }

    .highlight-pink {
        color: #e491af;
        background-color: #fdf2f6;
        padding: 1px 6px;
        border-radius: 4px;
        font-family: monospace;
    }

    .custom-label {
        color: #2b3643;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 10px;
        display: block;
    }

    .custom-input {
        border: 1px solid #f1f3f6;
        background-color: #ffffff;
        border-radius: 6px;
        padding: 12px 15px;
        font-size: 0.9rem;
        color: #2b3643;
        box-shadow: none;
        width: 100%;
        transition: border-color 0.3s ease;
    }

    .custom-input::placeholder {
        color: #cbd4e1;
    }

    .custom-input:focus {
        border-color: #40bdf4;
        outline: none;
        box-shadow: 0 0 0 3px rgba(64, 189, 244, 0.1);
    }

    /* Select Option styling */
    select.custom-input {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23cbd4e1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    /* Toggle More */
    .toggle-more {
        color: #40bdf4;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .toggle-more:hover {
        color: #1aa3e0;
    }

    /* Styling Box Dinamis (Seperti di gambar) */
    .dynamic-box {
        border: 1px solid #cbd4e1;
        padding: 25px 20px 10px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        position: relative;
    }

    /* Styling Tombol X Merah */
    .remove-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #dc3545;
        color: #ffffff;
        border: none;
        border-radius: 3px;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        line-height: 1;
    }

    .remove-btn:hover {
        background-color: #c82333;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="form-wrapper">
        <h4 class="form-title">Lending Form</h4>
        <p class="form-subtitle">Please <span class="highlight-pink">.fill-all</span> input form with right value.</p>

        @if ($errors->any())
            <div class="error-alert alert alert-danger">
                <strong>Validasi gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lendings.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="custom-label">Name</label>
                <input type="text" name="name" id="name" class="form-control custom-input @error('name') input-error @enderror" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                    <span class="error-message text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="item_id" class="custom-label">Items</label>
                <select name="item_id[]" id="item_id" class="form-select custom-input @error('item_id') input-error @enderror" onchange="updateMaxStock(this, 'total')" required>
                    <option value="" disabled selected hidden>Select Items</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" data-stock="{{ $item->total}}" {{ old('item_id.0') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} (Stok: {{ $item->total }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="total" class="custom-label">Total</label>
                <input type="number" name="total[]" id="total" class="form-control custom-input @error('total') input-error @enderror" placeholder="total item" min="1" required>
            </div>
            
            <div id="dynamic-container"></div>

            <a class="toggle-more" onclick="addMoreItem()">
                <i class="bi bi-chevron-down"></i> More
            </a>

            <div class="mb-4 mt-2">
                <label for="keterangan" class="custom-label">Ket.</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="form-control custom-input @error('keterangan') input-error @enderror" placeholder="Tambahkan keterangan jika ada...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="d-flex justify-content-start mt-4 gap-2">
                <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: #6f42c1; border: none;">Submit</button>
                <button type="button" class="btn btn-light px-4 py-2" style="background-color: #f8f9fa; border: 1px solid #ddd;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="item-template" style="display: none;">
    <div class="dynamic-box">
        <button type="button" class="remove-btn" onclick="removeBox(this)">&times;</button>
        
        <div class="mb-4">
            <label class="custom-label">Items</label>
            <select name="item_id[]" class="form-select custom-input" onchange="updateMaxStock(this)" required>
                <option value="" disabled selected hidden>Select Items</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" data-stock="{{ $item->stock }}">{{ $item->name }} (Stok: {{ $item->stock }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="custom-label">Total</label>
            <input type="number" name="total[]" class="form-control custom-input input-total-dynamic" placeholder="total item" min="1" required>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menambah box form (Tetap)
    function addMoreItem() {
        let template = document.getElementById('item-template').innerHTML;
        document.getElementById('dynamic-container').insertAdjacentHTML('beforeend', template);
    }

    // Fungsi untuk menghapus box form (Tetap)
    function removeBox(button) {
        button.closest('.dynamic-box').remove();
    }

    // FUNGSI BARU: Dinamis atur limit 'max' input angka agar tidak melebihi stok
    function updateMaxStock(selectElement, firstInputId = null) {
        // Ambil stok dari atribut 'data-stock' pada <option> yang dipilih
        let selectedOption = selectElement.options[selectElement.selectedIndex];
        let maxStock = selectedOption.getAttribute('data-stock');
        
        let targetInput;
        
        if (firstInputId) {
            // Jika ini form paling pertama
            targetInput = document.getElementById(firstInputId);
        } else {
            // Jika ini form dari dynamic box (More)
            targetInput = selectElement.closest('.dynamic-box').querySelector('.input-total-dynamic');
        }

        if (targetInput && maxStock) {
            targetInput.setAttribute('max', maxStock);
            targetInput.setAttribute('placeholder', 'Maksimal: ' + maxStock);
        }
    }
</script>
@endsection