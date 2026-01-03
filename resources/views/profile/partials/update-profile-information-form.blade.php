<form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('PATCH')

    <div>
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
            class="w-full border rounded px-3 py-2">
        @error('name')
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
            class="w-full border rounded px-3 py-2">
        @error('email')
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-teal-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

    @if (session('status') === 'profile-updated')
        <p class="text-green-600 text-sm mt-2">Profil diperbarui</p>
    @endif
</form>
