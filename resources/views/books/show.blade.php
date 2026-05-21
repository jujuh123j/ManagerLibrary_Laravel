@extends('layouts.app')

@section('title', $book->title . ' - Biblioteca Digital')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Back Navigation -->
        <a href="{{ route('books.index') }}" class="btn btn-link text-decoration-none text-muted mb-4 p-0">
            <i class="bi bi-arrow-left me-1"></i> Voltar para o Acervo
        </a>

        <!-- Detail Card -->
        <div class="card card-custom border-0 overflow-hidden">
            <div class="row g-0">
                
                <!-- Mock Book Cover Side -->
                <div class="col-md-4 text-center p-5 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-right: 1px solid rgba(229, 231, 235, 0.5);">
                    <div class="book-cover shadow-lg p-3 text-white text-center rounded-3 position-relative d-flex flex-column justify-content-between" 
                         style="background: linear-gradient(135deg, #6366f1 0%, #312e81 100%); width: 160px; height: 240px; border-left: 6px solid #4f46e5; border-radius: 4px 12px 12px 4px !important;">
                        
                        <div class="text-start text-white-50"><i class="bi bi-award-fill"></i></div>
                        
                        <div>
                            <i class="bi bi-book-half fs-1 d-block mb-3 text-white-50"></i>
                            <h6 class="fw-bold px-1 text-wrap text-center text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; line-height: 1.3;">{{ $book->title }}</h6>
                        </div>
                        
                        <div class="text-white-50 text-truncate fw-medium" style="font-size: 0.65rem;">
                            {{ $book->author }}
                        </div>
                    </div>
                </div>

                <!-- Text Details Side -->
                <div class="col-md-8 p-5">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-indigo-light text-indigo mb-2" style="background: rgba(99, 102, 241, 0.15); color: #4f46e5;">ID #{{ $book->id }}</span>
                            <h2 class="fw-bold text-dark mb-1">{{ $book->title }}</h2>
                            <p class="text-muted fs-5 mb-0">por <strong class="text-dark">{{ $book->author }}</strong></p>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Attributes Grid -->
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <span class="text-muted d-block small text-uppercase fw-semibold">ISBN</span>
                            <span class="fs-5 fw-medium text-dark"><i class="bi bi-qr-code text-muted me-2"></i>{{ $book->isbn }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block small text-uppercase fw-semibold">Número de Páginas</span>
                            <span class="fs-5 fw-medium text-dark"><i class="bi bi-file-earmark-text text-muted me-2"></i>{{ $book->pages }} páginas</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block small text-uppercase fw-semibold">Preço do Título</span>
                            <span class="fs-4 fw-extrabold text-indigo" style="color: #4f46e5;"><i class="bi bi-tag-fill text-muted me-2"></i>R$ {{ number_format($book->price, 2, ',', '.') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block small text-uppercase fw-semibold">Data de Cadastro</span>
                            <span class="fs-6 fw-medium text-dark" title="{{ $book->created_at }}"><i class="bi bi-calendar-event text-muted me-2"></i>{{ $book->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Actions -->
                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-warning rounded-3 px-4">
                            <i class="bi bi-pencil-fill me-2"></i>Editar Registro
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja remover este livro definitivamente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-3 px-4">
                                <i class="bi bi-trash3-fill me-2"></i>Excluir Livro
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
