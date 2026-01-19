@extends('layouts.app')

@section('title', 'Data Lokasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Validasi Gagal!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title mb-0">Data Lokasi</h3>
                </div>

                {{-- BODY --}}
                <div class="card-body table-responsive">

                    {{-- BARIS ATAS TABEL: TAMBAH (KIRI) + SEARCH (KANAN) --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        {{-- Tombol Tambah --}}
                        <button class="btn btn-success btn-sm"
                                data-toggle="modal"
                                data-target="#modalTambah"
                                onclick="resetFormTambah()">
                            <i class="fas fa-plus"></i> Tambah Lokasi
                        </button>

                        {{-- Search --}}
                        <form action="{{ route('lokasi.index') }}" method="GET" class="m-0">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text"
                                       name="q"
                                       class="form-control"
                                       placeholder="Cari kode / nama / tipe..."
                                       value="{{ $q ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- TABLE --}}
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center bg-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Kode Lokasi</th>
                                <th>Nama Lokasi</th>
                                <th>Tipe</th>
                                <th>Keterangan</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lokasi as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + (($lokasi->currentPage() - 1) * $lokasi->perPage()) }}</td>
                                    <td class="font-weight-bold">{{ $item->kode_lokasi }}</td>
                                    <td>{{ $item->nama_lokasi }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeColors = [
                                                'gudang' => 'warning',
                                                'rak' => 'info',
                                                'toko' => 'success',
                                                'cabang' => 'primary',
                                                'etalase' => 'secondary'
                                            ];
                                            $color = $badgeColors[$item->tipe_lokasi] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">
                                            {{ ucfirst($item->tipe_lokasi) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm btn-edit"
                                                data-toggle="modal"
                                                data-target="#modalEdit{{ $item->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form action="{{ route('lokasi.destroy', $item->id) }}"
                                              method="POST"
                                              style="display:inline-block"
                                              onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="modalEdit{{ $item->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('lokasi.update', $item->id) }}" method="POST" id="formEdit{{ $item->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header bg-warning text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit"></i> Edit Lokasi
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Kode Lokasi <span class="text-danger">*</span></label>
                                                        <input type="text" name="kode_lokasi"
                                                               value="{{ old('kode_lokasi', $item->kode_lokasi) }}"
                                                               class="form-control kode-input" 
                                                               data-id="{{ $item->id }}"
                                                               data-type="kode"
                                                               required>
                                                        <div class="invalid-feedback kode-feedback"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nama Lokasi <span class="text-danger">*</span></label>
                                                        <input type="text" name="nama_lokasi"
                                                               value="{{ old('nama_lokasi', $item->nama_lokasi) }}"
                                                               class="form-control nama-input"
                                                               data-id="{{ $item->id }}"
                                                               data-type="nama"
                                                               required>
                                                        <div class="invalid-feedback nama-feedback"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tipe Lokasi <span class="text-danger">*</span></label>
                                                        <select name="tipe_lokasi" class="form-control" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="gudang" {{ old('tipe_lokasi', $item->tipe_lokasi) == 'gudang' ? 'selected' : '' }}>Gudang</option>
                                                            <option value="rak" {{ old('tipe_lokasi', $item->tipe_lokasi) == 'rak' ? 'selected' : '' }}>Rak</option>
                                                            <option value="toko" {{ old('tipe_lokasi', $item->tipe_lokasi) == 'toko' ? 'selected' : '' }}>Toko</option>
                                                            <option value="cabang" {{ old('tipe_lokasi', $item->tipe_lokasi) == 'cabang' ? 'selected' : '' }}>Cabang</option>
                                                            <option value="etalase" {{ old('tipe_lokasi', $item->tipe_lokasi) == 'etalase' ? 'selected' : '' }}>Etalase</option>
                                                            <!-- OPSI RUMAH DIHAPUS -->
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $item->keterangan) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Update
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fas fa-times"></i> Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        @if(!empty($q))
                                            <i class="fas fa-search fa-2x mb-2"></i><br>
                                            Data tidak ditemukan untuk pencarian "<b>{{ $q }}</b>"
                                        @else
                                            <i class="fas fa-database fa-2x mb-2"></i><br>
                                            Data lokasi masih kosong
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- PAGINATION --}}
                    @if($lokasi->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $lokasi->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('lokasi.store') }}" method="POST" id="formTambah">
                @csrf

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus"></i> Tambah Lokasi
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="kode_lokasi" 
                               class="form-control kode-input"
                               data-type="kode"
                               placeholder="Contoh: MAD-001"
                               value="{{ old('kode_lokasi') }}" 
                               required>
                        <div class="invalid-feedback kode-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label>Nama Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lokasi" 
                               class="form-control nama-input"
                               data-type="nama"
                               placeholder="Contoh: Gudang Utama"
                               value="{{ old('nama_lokasi') }}" 
                               required>
                        <div class="invalid-feedback nama-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label>Tipe Lokasi <span class="text-danger">*</span></label>
                        <select name="tipe_lokasi" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="gudang" {{ old('tipe_lokasi') == 'gudang' ? 'selected' : '' }}>Gudang</option>
                            <option value="rak" {{ old('tipe_lokasi') == 'rak' ? 'selected' : '' }}>Rak</option>
                            <option value="toko" {{ old('tipe_lokasi') == 'toko' ? 'selected' : '' }}>Toko</option>
                            <option value="cabang" {{ old('tipe_lokasi') == 'cabang' ? 'selected' : '' }}>Cabang</option>
                            <option value="etalase" {{ old('tipe_lokasi') == 'etalase' ? 'selected' : '' }}>Etalase</option>
                            <!-- OPSI RUMAH DIHAPUS -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Reset form tambah saat modal dibuka
function resetFormTambah() {
    $('#formTambah')[0].reset();
    $('#formTambah .form-control').removeClass('is-invalid');
    $('#formTambah .invalid-feedback').text('');
}

// Cek duplikat dengan AJAX (Real-time validation)
$(document).ready(function() {
    // Debounce function untuk delay input
    let debounceTimer;
    function debounce(func, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    // Event untuk cek duplikat kode lokasi
    $(document).on('input', '.kode-input', function() {
        let input = $(this);
        let value = input.val().trim();
        let type = input.data('type');
        let id = input.data('id') || null;
        
        if (value.length < 2) return; // Minimal 2 karakter
        
        debounce(function() {
            $.ajax({
                url: "{{ route('lokasi.checkDuplicate') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    type: type,
                    value: value,
                    id: id
                },
                success: function(response) {
                    if (response.exists) {
                        input.addClass('is-invalid');
                        input.siblings('.kode-feedback').text('Kode lokasi sudah terdaftar!');
                    } else {
                        input.removeClass('is-invalid');
                        input.siblings('.kode-feedback').text('');
                    }
                }
            });
        }, 500);
    });

    // Event untuk cek duplikat nama lokasi
    $(document).on('input', '.nama-input', function() {
        let input = $(this);
        let value = input.val().trim();
        let type = input.data('type');
        let id = input.data('id') || null;
        
        if (value.length < 2) return;
        
        debounce(function() {
            $.ajax({
                url: "{{ route('lokasi.checkDuplicate') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    type: type,
                    value: value,
                    id: id
                },
                success: function(response) {
                    if (response.exists) {
                        input.addClass('is-invalid');
                        input.siblings('.nama-feedback').text('Nama lokasi sudah terdaftar!');
                    } else {
                        input.removeClass('is-invalid');
                        input.siblings('.nama-feedback').text('');
                    }
                }
            });
        }, 500);
    });

    // Validasi sebelum submit form
    $('#formTambah').submit(function(e) {
        let hasError = false;
        
        // Cek kode lokasi
        let kodeInput = $(this).find('.kode-input');
        let kodeValue = kodeInput.val().trim();
        if (kodeInput.hasClass('is-invalid')) {
            hasError = true;
            alert('Kode lokasi sudah terdaftar! Harap ganti dengan kode lain.');
            kodeInput.focus();
        }
        
        // Cek nama lokasi
        let namaInput = $(this).find('.nama-input');
        if (namaInput.hasClass('is-invalid')) {
            hasError = true;
            alert('Nama lokasi sudah terdaftar! Harap ganti dengan nama lain.');
            if (!kodeInput.hasClass('is-invalid')) namaInput.focus();
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
    });

    // Auto open modal jika ada error dari server
    @if ($errors->any() && !old('_method'))
        $(document).ready(function() {
            $('#modalTambah').modal('show');
        });
    @endif

    // Auto open modal edit jika ada error dari update
    @if ($errors->any() && old('_method') == 'PUT')
        $(document).ready(function() {
            $('#modalEdit{{ old("id") }}').modal('show');
        });
    @endif
});
</script>
@endsection

@section('styles')
<style>
.badge {
    font-size: 12px;
    padding: 5px 10px;
}
.btn-sm {
    padding: 3px 8px;
    font-size: 12px;
}
.table th {
    background-color: #f8f9fa;
}
.modal-header {
    border-bottom: none;
    padding: 15px 20px 10px;
}
.invalid-feedback {
    display: block;
}
</style>
@endsection