@extends('layouts.app')

@section('content')

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD UTAMA --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-medium">Daftar Jenis Barang</span>
                
                <div class="d-flex gap-2 align-items-center">
                    {{-- SEARCH --}}
                    <form action="{{ url()->current() }}" method="GET" class="d-flex">
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Cari kode / nama"
                            value="{{ $search }}"
                            style="width: 200px;"
                        >
                        <button class="btn btn-outline-primary btn-sm ms-2" type="submit">
                            Cari
                        </button>
                    </form>
                    
                    {{-- TOMBOL TAMBAH --}}
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        + Tambah Data
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Kode Jenis</th>
                        <th>Nama Jenis</th>
                        <th>Keterangan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisBarang as $item)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration + ($jenisBarang->currentPage() - 1) * $jenisBarang->perPage() }}
                            </td>
                            <td>{{ $item->kode_jenis }}</td>
                            <td>{{ $item->nama_jenis }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <button
                                    class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('jenis-barang.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('jenis-barang.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Jenis Barang</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kode Jenis</label>
                                                <input type="text" name="kode_jenis"
                                                       class="form-control"
                                                       value="{{ $item->kode_jenis }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Jenis</label>
                                                <input type="text" name="nama_jenis"
                                                       class="form-control"
                                                       value="{{ $item->nama_jenis }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea name="keterangan"
                                                          class="form-control"
                                                          rows="3">{{ $item->keterangan }}</textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="card-footer bg-white">
            {{ $jenisBarang->links() }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('jenis-barang.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Barang</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Jenis</label>
                        <input type="text" name="kode_jenis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" name="nama_jenis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection