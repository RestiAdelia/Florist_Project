@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.navigation-breeze' : 'layouts.navigation-user';
@endphp

<x-dynamic-component :component="$layout">
    <div class="min-h-screen bg-gray-50 pt-16 pb-8">
        <div class="max-w-4xl mx-auto px-4 space-y-6">
            
            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-800">Profil Saya</h1>
                    <p class="text-sm text-gray-500">Informasi detail akun Anda saat ini.</p>
                </div>
                <!-- Tombol Menuju Halaman Edit -->
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-pencil-square mr-2"></i> Edit Profil
                </a>
            </div>

            <!-- Card 1: Informasi Dasar -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <i class="bi bi-person-circle text-teal-600 mr-2 text-xl"></i> Informasi Pribadi
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-50 pt-6">
                        <!-- Nama -->
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                            <p class="text-lg text-gray-800 font-semibold">{{ $user->name }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Email</p>
                            <p class="text-lg text-gray-800 font-semibold">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Status & Keamanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <i class="bi bi-shield-check text-teal-600 mr-2 text-xl"></i> Detail Akun
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 border-t border-gray-50 pt-6">
                        <!-- Role -->
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tipe Akun</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-teal-100 text-teal-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <!-- Tanggal Bergabung -->
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Bergabung Sejak</p>
                            <p class="text-gray-700 font-medium">{{ $user->created_at->format('d F Y') }}</p>
                        </div>

                        <!-- Status Password -->
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keamanan</p>
                            <p class="text-gray-700 font-medium flex items-center">
                                <i class="bi bi-check-circle-fill text-green-500 mr-2"></i> Password Aktif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            
        </div>
    </div>
</x-dynamic-component>  