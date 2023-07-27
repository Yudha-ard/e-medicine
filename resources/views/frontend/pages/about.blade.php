@extends('frontend.layouts.layout')

@section('title', 'About')

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="position-relative">
                    <img src="{{ URL::asset('frontend/assets/images/capsul.png') }}" class="rounded img-fluid mx-auto d-block moving-object" alt="" />
                </div>
            </div>
            <div class="col-lg-7 col-md-7 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="section-title ml-lg-4">
                    <h4 class="title mb-4">About Us</h4>
                    <p class="text-muted">
                        <span class="text-primary font-weight-bold">E-Medicine</span>
                        adalah aplikasi kesehatan inovatif yang didesain untuk memberikan solusi medis yang efisien dan terjangkau kepada pengguna.
                        Aplikasi ini bertujuan untuk meningkatkan aksesibilitas layanan kesehatan, 
                        memudahkan pasien dalam mencari informasi tentang kesehatan, 
                        serta menyediakan fasilitas untuk konsultasi medis secara daring. 
                        Dengan teknologi canggih dan tim medis yang berpengalaman, 
                        E-Medicine berkomitmen untuk meningkatkan kualitas hidup masyarakat melalui layanan kesehatan digital yang aman dan berkualitas tinggi.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary mt-3">Get Started <i class="mdi mdi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-100 mt-60">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Service</h4>
                    <p class="text-muted para-desc mx-auto mb-0">
                        <span class="text-primary font-weight-bold">E-Medicine</span> 
                        menyediakan fitur pemesanan obat real-time yang memudahkan pengguna untuk memesan obat secara langsung melalui platform digital.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <div class="media key-feature align-items-center p-3 rounded shadow">
                    <div class="icon text-center rounded-circle mr-3">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="title mb-0">Pemesanan Obat Secara Daring</h4>
                        <p class="text-muted">
                            Pengguna dapat memesan obat-obatan yang mereka butuhkan melalui aplikasi E-Medicine dengan cara yang mudah dan cepat. 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <div class="media key-feature align-items-center p-3 rounded shadow">
                    <div class="icon text-center rounded-circle mr-3">
                        <i class="fas fa-database text-primary"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="title mb-0">Inventaris Obat yang Terupdate</h4>
                        <p class="text-muted">
                            Aplikasi E-Medicine terhubung dengan sistem manajemen inventaris apotek untuk memastikan ketersediaan obat yang akurat dan terbaru.  
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <div class="media key-feature align-items-center p-3 rounded shadow">
                    <div class="icon text-center rounded-circle mr-3">
                        <i class="fas fa-info-circle text-primary"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="title mb-0">Informasi Obat Lengkap</h4>
                        <p class="text-muted">
                            Setiap obat yang terdaftar di aplikasi E-Medicine dilengkapi dengan informasi lengkap, termasuk komposisi, dosis, efek samping, dan petunjuk penggunaan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <div class="media key-feature align-items-center p-3 rounded shadow">
                    <div class="icon text-center rounded-circle mr-3">
                        <i class="fas fa-history text-primary"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="title mb-0">Riwayat Pemesanan Obat</h4>
                        <p class="text-muted">
                            Aplikasi E-Medicine menyimpan riwayat pemesanan obat pengguna, sehingga mereka dapat melihat pesanan sebelumnya dan mengulang pemesanan dengan mudah jika diperlukan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <div class="media key-feature align-items-center p-3 rounded shadow">
                    <div class="icon text-center rounded-circle mr-3">
                        <i class="fas fa-headset text-primary"></i>
                    </div>
                    <div class="media-body">
                        <h4 class="title mb-0">Dukungan Pelanggan 24/7</h4>
                        <p class="text-muted">
                        Tim dukungan pelanggan E-Medicine siap membantu pengguna dalam proses pemesanan obat atau menjawab pertanyaan seputar pemesanan dengan layanan pelanggan yang aktif 24/7.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop