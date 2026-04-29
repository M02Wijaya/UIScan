<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - UIScan.id</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    </head>
<body style="background-color: #f4f7f6;">

    <div class="container-fluid" style="min-height: 100vh; padding: 20px;">
        <div class="row">
            
            <div class="col-md-2">
                <div class="card bg-dark text-white border-0 shadow-lg d-flex flex-column" style="border-radius: 20px; min-height: 85vh; position: sticky; top: 20px; background-color: #1e1e2d !important;">
                    
                    <div class="card-body text-center mt-4 flex-grow-0">
                        <div class="mb-3">
                            <i class="fas fa-user-shield text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-white">Admin Panel</h5>
                        <span class="badge bg-danger rounded-pill px-3 py-2 mt-1" style="font-size: 0.75rem;">Administrator</span>
                    </div>

                    <div class="card-body flex-grow-1 px-4 mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn {{ request()->routeIs('admin.dashboard') ? 'btn-danger' : 'btn-outline-light' }} w-100 fw-bold text-start px-3 py-3 shadow-sm mb-3" style="border-radius: 12px; transition: 0.3s;">
                            <i class="fas fa-globe me-2"></i> Dasbor Utama
                        </a>
                        
                        <a href="{{ route('admin.users') }}" class="btn {{ request()->routeIs('admin.users') ? 'btn-info text-dark' : 'btn-outline-light' }} w-100 fw-bold text-start px-3 py-3 shadow-sm mb-3" style="border-radius: 12px; transition: 0.3s;">
                            <i class="fas fa-users me-2"></i> Daftar Pengguna
                        </a>

                        <a href="{{ route('admin.documents') }}" class="btn {{ request()->routeIs('admin.documents') ? 'btn-warning text-dark' : 'btn-outline-light' }} w-100 fw-bold text-start px-3 py-3 shadow-sm mb-4" style="border-radius: 12px; transition: 0.3s;">
                            <i class="fas fa-file-alt me-2"></i> Riwayat Scan
                        </a>
                    </div>

                    <div class="card-body flex-grow-0 px-4 mb-3">
                        <a href="{{ route('admin.uji.layanan') }}" class="btn btn-outline-info w-100 fw-bold mb-4 py-2" style="border-radius: 12px; transition: 0.3s;">
                            <i class="fas fa-home me-1"></i> Kembali ke Website
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 fw-bold d-flex align-items-center justify-content-center w-100 mt-2" style="font-size: 0.95rem;">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-10 ps-4">
                @yield('admin_content')
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>