<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Informasi Profil Detail
                        </h3>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Terjadi kesalahan:</strong>
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.detail.update') }}" id="profileDetailForm">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Informasi Kontak -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Informasi Kontak</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-label for="no_hp" value="{{ __('Nomor HP') }}" />
                                        <x-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $userDetail->no_hp)" required autofocus />
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat dan Wilayah -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Alamat dan Wilayah</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Provinsi -->
                                    <div>
                                        <x-label for="kode_provinsi" value="{{ __('Provinsi') }}" />
                                        <select id="kode_provinsi" name="kode_provinsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            <option value="">-- Pilih Provinsi --</option>
                                            @foreach($provinsi as $prov)
                                                <option value="{{ $prov->kode }}" {{ old('kode_provinsi', $userDetail->kode_provinsi) == $prov->kode ? 'selected' : '' }}>
                                                    {{ $prov->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="kode_provinsi" class="mt-2" />
                                    </div>

                                    <!-- Kabupaten -->
                                    <div>
                                        <x-label for="kode_kabupaten" value="{{ __('Kabupaten/Kota') }}" />
                                        <select id="kode_kabupaten" name="kode_kabupaten" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            <option value="">-- Pilih Kabupaten/Kota --</option>
                                            @if(old('kode_provinsi', $userDetail->kode_provinsi))
                                                @foreach($kabupaten as $kab)
                                                    <option value="{{ $kab->kode }}" {{ old('kode_kabupaten', $userDetail->kode_kabupaten) == $kab->kode ? 'selected' : '' }}>
                                                        {{ $kab->nama }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <x-input-error for="kode_kabupaten" class="mt-2" />
                                        <div id="kabupaten-loading" class="mt-2 hidden">
                                            <div class="flex items-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span class="text-sm text-gray-500">Memuat kabupaten...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kecamatan -->
                                    <div>
                                        <x-label for="kecamatan" value="{{ __('Kecamatan (Opsional)') }}" />
                                        <x-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan', $userDetail->kecamatan)" placeholder="Masukkan nama kecamatan" />
                                        <x-input-error for="kecamatan" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pendidikan -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Informasi Pendidikan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-label for="asal_sekolah" value="{{ __('Asal Sekolah (Opsional)') }}" />
                                        <x-input id="asal_sekolah" name="asal_sekolah" type="text" class="mt-1 block w-full" :value="old('asal_sekolah', $userDetail->asal_sekolah)" placeholder="Masukkan nama sekolah" />
                                        <x-input-error for="asal_sekolah" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-label for="prodi" value="{{ __('Program Studi Target (Opsional)') }}" />
                                        <x-input id="prodi" name="prodi" type="text" class="mt-1 block w-full" :value="old('prodi', $userDetail->prodi)" placeholder="Contoh: Teknik Informatika" />
                                        <x-input-error for="prodi" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Informasi Tambahan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-label for="instagram" value="{{ __('Instagram (Opsional)') }}" />
                                        <x-input id="instagram" name="instagram" type="text" class="mt-1 block w-full" :value="old('instagram', $userDetail->instagram)" placeholder="@username" />
                                        <x-input-error for="instagram" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-label for="nama_kelompok" value="{{ __('Nama Kelompok (Opsional)') }}" />
                                        <x-input id="nama_kelompok" name="nama_kelompok" type="text" class="mt-1 block w-full" :value="old('nama_kelompok', $userDetail->nama_kelompok)" placeholder="Nama kelompok belajar" />
                                        <x-input-error for="nama_kelompok" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Sumber Informasi -->
                                <div class="mt-4">
                                    <x-label for="sumber_informasi" value="{{ __('Sumber Informasi (Opsional)') }}" />
                                    <div class="mt-2 space-y-2">
                                        @php
                                            $sumberInformasi = old('sumber_informasi', $userDetail->sumber_informasi ?? []);
                                            if (!is_array($sumberInformasi)) {
                                                $sumberInformasi = [$sumberInformasi];
                                            }
                                        @endphp
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Instagram" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Instagram', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Instagram</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Facebook" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Facebook', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Facebook</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Teman" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Teman', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Teman</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Website" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Website', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Website</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Google Ads" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Google Ads', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Google Ads</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="sumber_informasi[]" value="Lainnya" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Lainnya', $sumberInformasi) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">Lainnya</span>
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-error for="sumber_informasi" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-button class="ml-3">
                                {{ __('Simpan Perubahan') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Dynamic Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinsiSelect = document.getElementById('kode_provinsi');
            const kabupatenSelect = document.getElementById('kode_kabupaten');
            const kabupatenLoading = document.getElementById('kabupaten-loading');
            const form = document.getElementById('profileDetailForm');

            // Function to load kabupaten
            function loadKabupaten(kodeProvinsi, selectedKabupaten = '') {
                if (!kodeProvinsi) {
                    kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    return;
                }

                // Show loading
                kabupatenLoading.classList.remove('hidden');
                kabupatenSelect.disabled = true;

                // Fetch kabupaten
                fetch(`/profile/detail/kabupaten?kode_provinsi=${kodeProvinsi}`)
                    .then(response => response.json())
                    .then(data => {
                        kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                        
                        if (data.success && data.data.length > 0) {
                            data.data.forEach(function(kab) {
                                const option = document.createElement('option');
                                option.value = kab.kode;
                                option.textContent = kab.nama;
                                if (selectedKabupaten && selectedKabupaten === kab.kode) {
                                    option.selected = true;
                                }
                                kabupatenSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        kabupatenSelect.innerHTML = '<option value="">-- Error loading kabupaten --</option>';
                    })
                    .finally(() => {
                        kabupatenLoading.classList.add('hidden');
                        kabupatenSelect.disabled = false;
                    });
            }

            // Event listener untuk perubahan provinsi
            provinsiSelect.addEventListener('change', function() {
                const kodeProvinsi = this.value;
                
                // Reset kabupaten selection
                kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                
                if (kodeProvinsi) {
                    loadKabupaten(kodeProvinsi);
                }
            });

            // Load kabupaten jika ada provinsi yang dipilih
            if (provinsiSelect.value) {
                loadKabupaten(provinsiSelect.value, '{{ old("kode_kabupaten", $userDetail->kode_kabupaten) }}');
            }

            // Form validation
            form.addEventListener('submit', function(e) {
                const kodeProvinsi = provinsiSelect.value;
                const kodeKabupaten = kabupatenSelect.value;

                if (!kodeProvinsi) {
                    e.preventDefault();
                    alert('Silakan pilih provinsi terlebih dahulu.');
                    provinsiSelect.focus();
                    return;
                }

                if (!kodeKabupaten) {
                    e.preventDefault();
                    alert('Silakan pilih kabupaten/kota terlebih dahulu.');
                    kabupatenSelect.focus();
                    return;
                }
            });
        });
    </script>
</x-app-layout>