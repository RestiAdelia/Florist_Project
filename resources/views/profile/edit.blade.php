<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 space-y-8">

        <!-- PROFILE INFO -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Profile</h2>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- UPDATE PASSWORD -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Password</h2>
            @include('profile.partials.update-password-form')
        </div>

    </div>
</x-app-layout>
