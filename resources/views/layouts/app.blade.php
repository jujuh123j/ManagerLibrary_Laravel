<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biblioteca Digital')</title>
    <!-- Google Fonts - Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --secondary-gradient: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            --accent-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --background-gradient: radial-gradient(circle at 10% 20%, rgba(243, 244, 246, 1) 0%, rgba(229, 231, 235, 1) 90%);
            --card-border-radius: 16px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            color: #1f2937;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .navbar-brand-gradient {
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.4);
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(99, 102, 241, 0.6);
            color: white;
        }

        .btn-gradient-success {
            background: var(--accent-gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.4);
        }

        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(16, 185, 129, 0.6);
            color: white;
        }

        .btn-gradient-secondary {
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-gradient-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            color: white;
        }

        .card-custom {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--card-border-radius);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.1);
        }

        .form-control-custom {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        /* Custom Table Styling */
        .table-custom {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table-custom tr {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .table-custom tr:hover {
            transform: scale(1.005);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            border: none;
            background: transparent;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 16px;
        }

        .table-custom td {
            background: white;
            border: none;
            padding: 16px;
            vertical-align: middle;
        }

        .table-custom td:first-child, .table-custom th:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .table-custom td:last-child, .table-custom th:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Micro-animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .badge-custom {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Sticky Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('books.index') }}">
                <span class="navbar-brand-gradient"><i class="bi bi-book-half me-2"></i>Biblioteca Digital</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{ route('books.index') }}">
                            <i class="bi bi-grid-fill me-1"></i>Acervo
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('books.create') }}" class="btn btn-gradient-primary btn-sm mt-1 mt-lg-0">
                            <i class="bi bi-plus-lg me-1"></i>Novo Livro
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container my-5 animated-fade-in">
        
        <!-- Toast / Alerts for Success Messages -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4 p-3" role="alert" style="border-radius: 12px; background: rgba(209, 250, 229, 0.9); backdrop-filter: blur(8px);">
                <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                <div>
                    <strong class="text-success">Sucesso!</strong> 
                    <span class="text-success-emphasis ms-1">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-auto border-top" style="background: rgba(255,255,255,0.4); border-color: rgba(229,231,235,0.5) !important;">
        <div class="container text-muted">
            <p class="mb-0">📚 <strong>Biblioteca Digital</strong> &copy; {{ date('Y') }} - Desenvolvido com Laravel & Docker</p>
            <small>Curso Técnico em ADS - Disciplina de Desenvolvimento Web</small>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
