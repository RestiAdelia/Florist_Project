@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.navigation-breeze' : 'layouts.navigation-user';
@endphp

<x-dynamic-component :component="$layout">
    <div class="min-h-screen bg-gray-50 pt-20 pb-8 px-4">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Pengaturan Profil</h1>
                    <p class="text-sm text-gray-500">Kelola informasi akun dan keamanan dalam satu tempat.</p>
                </div>
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-teal-600 rounded-xl font-semibold text-sm hover:bg-teal-50 transition-all shadow-sm">
                    <i class="bi bi-arrow-left mr-2"></i> Kembali ke Profil
                </a>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- KOLOM KIRI: INFORMASI PROFIL (Lg: 5/12) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-person-vcard text-xl"></i>
                                </div>
                                <h2 class="text-lg font-bold text-gray-800">Informasi Pribadi</h2>
                            </div>
                            
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white outline-none transition-all @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white outline-none transition-all @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition-all shadow-md shadow-teal-100">
                                        Update Profil
                                    </button>
                                    
                                    @if (session('status') === 'profile-updated')
                                        <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-green-600 text-sm font-medium flex items-center">
                                            <i class="bi bi-check2-circle mr-1"></i> Tersimpan
                                        </span>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: KEAMANAN (Lg: 7/12) -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-shield-lock text-xl"></i>
                                </div>
                                <h2 class="text-lg font-bold text-gray-800">Keamanan Akun</h2>
                            </div>
                            
                            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                                        <input type="password" name="current_password" 
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white outline-none transition-all @error('current_password') border-red-500 @enderror">
                                        @error('current_password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Baru</label>
                                        <input type="password" name="password" 
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white outline-none transition-all @error('password') border-red-500 @enderror">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" 
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:bg-white outline-none transition-all">
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-gray-800 text-white font-bold rounded-lg hover:bg-black transition-all shadow-md shadow-gray-200">
                                        Perbarui Password
                                    </button>
                                    
                                    @if (session('status') === 'password-updated')
                                        <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-green-600 text-sm font-medium flex items-center">
                                            <i class="bi bi-shield-check mr-1"></i> Aman!
                                        </span>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div> <!-- End Grid -->

        </div>
    </div>
</x-dynamic-component>