@extends('layouts.app')

@section('content')

<style>
    .card-hover {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-hover img {
        transition: 0.3s;
    }

    .card-hover:hover img {
        transform: scale(1.1);
    }

    .hero-section {
        background-color: #f8f9fa;
    }

    .hero-section h1 {
        font-size: 42px;
        color: #000;
    }

    .hero-section p {
        font-size: 16px;
    }

    .hero-img {
        max-width: 600px;
        width: 100%;
    }
</style>


<div class="hero-section text-center py-5">
    <div class="container">
        <h1 class="fw-bold display-5 mb-3">
            Inventory Management of <br> SMK Wikrama
        </h1>
        <p class="text-muted mb-4">
            Management of incoming and outgoing items at SMK Wikrama Bogor.
        </p>
        <img src="#" alt="Dashboard Illustration" class="img-fluid hero-img">
    </div>
</div>

<div class="row g-4" style="margin-top: 100px;">

    <!-- Card 1 -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 card-hover text-center p-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPP5sbPVvn6GNxeySL_4NPSB1xIKj5HpTN6w&s" 
                     class="mb-3" width="60">
                <h6 class="text-muted">Items Data</h6>
            </div>
        </a>
    </div>

    <!-- Card 2 -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 card-hover text-center p-3">
                <img src="https://cdn-icons-png.flaticon.com/512/1995/1995574.png" 
                     class="mb-3" width="60">
                <h6 class="text-muted">Management Technician</h6>
            </div>
        </a>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 card-hover text-center p-3">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" 
                     class="mb-3" width="60">
                <h6 class="text-muted">Managed Landing</h6>
            </div>
        </a>
    </div>

    <!-- Card 4 -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 card-hover text-center p-3">
                <img src="https://cdn-icons-png.flaticon.com/512/1041/1041886.png" 
                     class="mb-3" width="60">
                <h6 class="text-muted">All can Borrow</h6>
            </div>
        </a>
    </div>

</div>



<!-- Section tambahan -->
<div class="card mt-4 shadow-sm border-0 rounded-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Selamat Datang 👋</h5>
        <p class="text-muted">
            Ini adalah dashboard sederhana. Kamu bisa mengelola data produk, user, dan transaksi di sini.
        </p>
    </div>
</div>



@include('layouts.footer')

@include('auth.modal-login')
@endsection