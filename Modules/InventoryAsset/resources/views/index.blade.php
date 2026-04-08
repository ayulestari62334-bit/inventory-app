<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Barang</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .modal {
            display: none;
        }
        .modal.active {
            display: flex;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            <i class="fas fa-tags mr-2"></i>Data Jenis Barang
                        </h2>
                        <p class="text-gray-600 mt-1">Kelola data jenis barang inventory</p>
                    </div>
                    <button type="button" 
                            onclick="openModal('createModal')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow">
            @if($jenisBarang->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jenisBarang as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                    {{ $item->kode_jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_jenis }}</td>
                            <td class="px-6 py-4">{{ $item->keterangan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <button type="button" 
                                            onclick="openEditModal('{{ $item->id }}', '{{ $item->kode_jenis }}', '{{ $item->nama_jenis }}', `{{ $item->keterangan }}`)"
                                            class="text-yellow-600 hover:text-yellow-900"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('jenisbarang.destroy', $item->id) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900"
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus jenis barang ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Data Kosong</h3>
                <p class="text-gray-500 mb-4">Belum ada data jenis barang.</p>
                <button type="button" 
                        onclick="openModal('createModal')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Tambah Data
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Tambah Jenis Barang</h3>
                <button type="button" 
                        onclick="closeModal('createModal')"
                        class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('jenisbarang.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="kode_jenis" class="block text-gray-700 mb-2">Kode Jenis *</label>
                    <input type="text" 
                           name="kode_jenis" 
                           id="kode_jenis"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label for="nama_jenis" class="block text-gray-700 mb-2">Nama Jenis *</label>
                    <input type="text" 
                           name="nama_jenis" 
                           id="nama_jenis"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label for="keterangan" class="block text-gray-700 mb-2">Keterangan *</label>
                    <textarea name="keterangan" 
                             id="keterangan" 
                             rows="3"
                             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeModal('createModal')"
                            class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Jenis Barang</h3>
                <button type="button" 
                        onclick="closeModal('editModal')"
                        class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_kode_jenis" class="block text-gray-700 mb-2">Kode Jenis *</label>
                    <input type="text" 
                           name="kode_jenis" 
                           id="edit_kode_jenis"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label for="edit_nama_jenis" class="block text-gray-700 mb-2">Nama Jenis *</label>
                    <input type="text" 
                           name="nama_jenis" 
                           id="edit_nama_jenis"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label for="edit_keterangan" class="block text-gray-700 mb-2">Keterangan *</label>
                    <textarea name="keterangan" 
                             id="edit_keterangan" 
                             rows="3"
                             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeModal('editModal')"
                            class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openEditModal(id, kode, nama, keterangan) {
        // Populate form fields
        document.getElementById('edit_kode_jenis').value = kode;
        document.getElementById('edit_nama_jenis').value = nama;
        document.getElementById('edit_keterangan').value = keterangan;
        
        // Set form action
        document.getElementById('editForm').action = '/jenisbarang/' + id;
        
        // Open modal
        openModal('editModal');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.fixed').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
    </script>
</body>
</html>