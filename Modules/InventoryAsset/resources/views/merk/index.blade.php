@extends('layouts.app')

@section('title', 'Data Merk')
@section('page-title', 'Data Merk')

@section('content')

{{-- Alert --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
@endif

<div class="card">

    {{-- Header --}}
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form method="GET" action="{{ route('merk.index') }}">
                    <div class="input-group">
                        <input type="text"
                               name="cari"
                               class="form-control"
                               placeholder="Cari kode / nama merk..."
                               value="{{ $cari }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6 text-right">
                <button class="btn btn-success"
                        data-toggle="modal"
                        data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Merk
                </button>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode Merk</th>
                    <th>Nama Merk</th>
                    <th>Keterangan</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($merks as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration + ($merks->currentPage() - 1) * $merks->perPage() }}
                    </td>
                    <td>{{ $item->kode_merk }}</td>
                    <td>{{ $item->nama_merk }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <form action="{{ route('merk.destroy', $item->id) }}"
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

                {{-- MODAL EDIT --}}
                <div class="modal fade" id="editModal{{ $item->id }}">
                    <div class="modal-dialog">
                        <form action="{{ route('merk.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Merk</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Kode Merk</label>
                                        <input type="text"
                                               name="kode_merk"
                                               class="form-control"
                                               value="{{ $item->kode_merk }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nama Merk</label>
                                        <input type="text"
                                               name="nama_merk"
                                               class="form-control"
                                               value="{{ $item->nama_merk }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan"
                                                  class="form-control">{{ $item->keterangan }}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Data merk belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="card-footer clearfix">
        {{ $merks->appends(['cari' => $cari])->links() }}
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="tambahModal">
    <div class="modal-dialog">
        <form action="{{ route('merk.store') }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Merk</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Merk</label>
                        <input type="text" name="kode_merk" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Merk</label>
                        <input type="text" name="nama_merk" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
