@extends('layouts.app')

@section('title', 'Data Kategori')
@section('page-title', 'Data Kategori Barang')

{{-- ================= STYLE ================= --}}
@push('styles')
<style>
    .table thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 2;
    }

    .table-hover tbody tr {
        transition: background .15s ease-in-out;
    }

    .table-hover tbody tr:hover {
        background: #f1f5f9;
    }
</style>
@endpush

@section('content')

{{-- ================= NOTIFIKASI ================= --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle mr-1"></i>
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="card shadow-sm">

    {{-- ================= HEADER CARD ================= --}}
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0">
            <i class="fas fa-tags mr-1"></i> Data Kategori Barang
        </h3>
    </div>

    {{-- ================= BODY ================= --}}
    <div class="card-body">

        {{-- ACTION BAR --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <button class="btn btn-success btn-sm"
                    data-toggle="modal"
                    data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah
            </button>

            <input type="text"
                   id="search"
                   class="form-control form-control-sm"
                   style="width:220px"
                   placeholder="Cari...">
        </div>

        {{-- TOTAL DATA (POSISI IDEAL) --}}
        <div class="mb-2 text-muted">
            Total Data: <strong>{{ $kategori->count() }}</strong>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @forelse($kategori as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#modalEdit{{ $item->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('kategori.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open mb-1"></i><br>
                            Data kosong
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
@foreach($kategori as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}">
    <div class="modal-dialog">
        <form action="{{ route('kategori.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i> Edit Kategori
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang"
                               value="{{ $item->kode_barang }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                               value="{{ $item->nama_kategori }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control">{{ $item->keterangan }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button class="btn btn-warning btn-sm">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection

{{-- ================= SCRIPT ================= --}}
@push('scripts')
<script>
    // auto hide alert
    setTimeout(() => {
        $('.alert').fadeOut('slow');
    }, 3000);

    // search client-side (AMAN)
    document.getElementById('search').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? '' : 'none';
        });
    });
</script>
@endpush
