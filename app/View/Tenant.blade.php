@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .page-header {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .card {
        border-radius: 14px;
        border: none;
    }

    .card-header {
        font-weight: 600;
        background: #f8fafc;
    }

    .form-control, .form-select {
        border-radius: 10px;
    }

    .btn-primary {
        background: #4f46e5;
        border: none;
        border-radius: 10px;
    }

    .btn-warning {
        border-radius: 8px;
    }

    .btn-danger {
        border-radius: 8px;
    }

    table thead {
        background: #eef2ff;
    }

    .badge-open {
        background: #22c55e;
    }

    .badge-close {
        background: #ef4444;
    }
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="page-header">
        <h2 class="mb-1">Manajemen Tenant Kantin</h2>
        <p class="mb-0">Kelola data tenant makanan dan minuman secara terpusat</p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- FORM --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    {{ isset($editTenant) ? 'Edit Tenant' : 'Tambah Tenant Baru' }}
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($editTenant)
                            ? route('canteens.update', $editTenant->id)
                            : route('canteens.store') }}">
                        @csrf
                        @if(isset($editTenant))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Tenant</label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="Contoh: Ayam Geprek Pak Kumis"
                                   value="{{ old('name', $editTenant->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" class="form-control"
                                   placeholder="Makanan Berat / Minuman"
                                   value="{{ old('category', $editTenant->category ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="3" class="form-control"
                                      placeholder="Deskripsi singkat tenant">{{ old('description', $editTenant->description ?? '') }}</textarea>
                        </div>

                        @if(isset($editTenant))
                        <div class="mb-3">
                            <label class="form-label">Status Operasional</label>
                            <select name="is_open" class="form-select">
                                <option value="1" {{ $editTenant->is_open ? 'selected' : '' }}>Buka</option>
                                <option value="0" {{ !$editTenant->is_open ? 'selected' : '' }}>Tutup</option>
                            </select>
                        </div>
                        @endif

                        <button class="btn btn-primary w-100">
                            {{ isset($editTenant) ? 'Update Tenant' : 'Simpan Tenant' }}
                        </button>

                        @if(isset($editTenant))
                        <div class="text-center mt-2">
                            <a href="{{ route('canteens.index') }}" class="text-decoration-none">
                                Batal Edit
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Daftar Tenant Terdaftar
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tenant</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($canteens as $i => $tenant)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $tenant->name }}</strong><br>
                                    <small class="text-muted">{{ $tenant->description }}</small>
                                </td>
                                <td>{{ $tenant->category }}</td>
                                <td>
                                    <span class="badge {{ $tenant->is_open ? 'badge-open' : 'badge-close' }}">
                                        {{ $tenant->is_open ? 'Buka' : 'Tutup' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('canteens.index', ['edit' => $tenant->id]) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('canteens.destroy', $tenant->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus tenant ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada tenant kantin
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
