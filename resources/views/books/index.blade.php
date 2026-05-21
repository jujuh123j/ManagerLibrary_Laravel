@extends('layouts.app')

@section('title', 'Acervo - Biblioteca Digital')

@section('content')
<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h1 class="fw-bold tracking-tight mb-1 text-dark">📖 Acervo de Livros</h1>
        <p class="text-muted">Gerencie e explore os títulos cadastrados na biblioteca.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('books.create') }}" class="btn btn-gradient-success">
            <i class="bi bi-plus-circle-fill me-2"></i>Cadastrar Novo Livro
        </a>
    </div>
</div>

<!-- Dashboard Stats Section -->
<div class="row g-4 mb-5">
    <!-- Stat 1: Total Books -->
    <div class="col-sm-6 col-lg-4">
        <div class="card card-custom border-0 p-4" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0.1) 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Total de Títulos</span>
                    <h2 class="fw-extrabold text-indigo mt-2 mb-0">{{ $books->count() }}</h2>
                </div>
                <div class="bg-indigo-light p-3 rounded-circle" style="background: rgba(99, 102, 241, 0.15);">
                    <i class="bi bi-bookshelf text-indigo fs-3" style="color: #4f46e5;"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat 2: Total Pages -->
    <div class="col-sm-6 col-lg-4">
        <div class="card card-custom border-0 p-4" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.05) 0%, rgba(236, 72, 153, 0.1) 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Total de Páginas</span>
                    <h2 class="fw-extrabold text-pink mt-2 mb-0">{{ $books->sum('pages') }}</h2>
                </div>
                <div class="bg-pink-light p-3 rounded-circle" style="background: rgba(236, 72, 153, 0.15);">
                    <i class="bi bi-file-earmark-text text-pink fs-3" style="color: #db2777;"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat 3: Avg Price -->
    <div class="col-sm-6 col-lg-4">
        <div class="card card-custom border-0 p-4" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(16, 185, 129, 0.1) 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Preço Médio</span>
                    <h2 class="fw-extrabold text-emerald mt-2 mb-0">R$ {{ number_format($books->avg('price') ?? 0, 2, ',', '.') }}</h2>
                </div>
                <div class="bg-emerald-light p-3 rounded-circle" style="background: rgba(16, 185, 129, 0.15);">
                    <i class="bi bi-tags text-emerald fs-3" style="color: #059669;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Books List Card -->
<div class="card card-custom border-0">
    <div class="card-body p-4">
        @if($books->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted mb-4 d-block"></i>
                <h4 class="fw-bold text-dark">Nenhum livro cadastrado</h4>
                <p class="text-muted max-w-md mx-auto mb-4">Comece a preencher o acervo adicionando o seu primeiro livro hoje mesmo!</p>
                <a href="{{ route('books.create') }}" class="btn btn-gradient-primary">
                    <i class="bi bi-plus-lg me-1"></i>Adicionar Livro
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 80px;">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Autor</th>
                            <th scope="col">ISBN</th>
                            <th scope="col" style="width: 120px;">Páginas</th>
                            <th scope="col" style="width: 140px;">Preço</th>
                            <th scope="col" class="text-end" style="width: 250px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td class="fw-bold text-secondary">#{{ $book->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 bg-light rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-book-half text-indigo fs-5" style="color: #4f46e5;"></i>
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-dark">{{ $book->title }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark"><i class="bi bi-person-fill text-muted me-1"></i>{{ $book->author }}</span>
                                </td>
                                <td>
                                    <code class="text-pink bg-light px-2 py-1 rounded small">{{ $book->isbn }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-file-earmark-text text-muted me-1"></i>{{ $book->pages }} págs</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-indigo" style="color: #4f46e5;">R$ {{ number_format($book->price, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm rounded-3" title="Visualizar">
                                            <i class="bi bi-eye-fill"></i> <span class="d-none d-xl-inline ms-1">Ver</span>
                                        </a>
                                        <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-warning btn-sm rounded-3" title="Editar">
                                            <i class="bi bi-pencil-fill"></i> <span class="d-none d-xl-inline ms-1">Editar</span>
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente remover o livro &quot;{{ $book->title }}&quot;?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-3" title="Excluir">
                                                <i class="bi bi-trash3-fill"></i> <span class="d-none d-xl-inline ms-1">Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
