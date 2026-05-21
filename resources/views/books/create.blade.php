@extends('layouts.app')

@section('title', 'Cadastrar Livro - Biblioteca Digital')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Back Navigation -->
        <a href="{{ route('books.index') }}" class="btn btn-link text-decoration-none text-muted mb-4 p-0">
            <i class="bi bi-arrow-left me-1"></i> Voltar para o Acervo
        </a>

        <!-- Form Card -->
        <div class="card card-custom border-0">
            <div class="card-body p-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-indigo-light p-3 rounded-3 me-3" style="background: rgba(99, 102, 241, 0.15);">
                        <i class="bi bi-journal-plus text-indigo fs-3" style="color: #4f46e5;"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">Cadastrar Livro</h2>
                        <p class="text-muted mb-0">Insira as informações do novo título para catalogar no acervo.</p>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <!-- Form -->
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Título do Livro</label>
                        <input type="text" name="title" id="title" class="form-control form-control-custom @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Ex: Dom Casmurro" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="mb-4">
                        <label for="author" class="form-label fw-semibold">Autor</label>
                        <input type="text" name="author" id="author" class="form-control form-control-custom @error('author') is-invalid @enderror" value="{{ old('author') }}" placeholder="Ex: Machado de Assis" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div class="mb-4">
                        <label for="isbn" class="form-label fw-semibold">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="form-control form-control-custom @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" placeholder="Ex: 978-8575033708" required>
                        <div class="form-text text-muted">O ISBN deve ser um identificador único de 10 ou 13 dígitos.</div>
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Pages -->
                        <div class="col-md-6 mb-4">
                            <label for="pages" class="form-label fw-semibold">Número de Páginas</label>
                            <input type="number" name="pages" id="pages" min="1" class="form-control form-control-custom @error('pages') is-invalid @enderror" value="{{ old('pages') }}" placeholder="Ex: 256" required>
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label fw-semibold">Preço (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px; border: 1px solid #d1d5db;">R$</span>
                                <input type="number" name="price" id="price" step="0.01" min="0" class="form-control form-control-custom ps-2 @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Ex: 49.90" style="border-radius: 0 10px 10px 0;" required>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="{{ route('books.index') }}" class="btn btn-gradient-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-check-lg me-1"></i>Salvar Livro
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
